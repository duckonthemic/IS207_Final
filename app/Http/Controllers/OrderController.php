<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display user's orders
     */
    public function index(): View
    {
        $query = auth()->user()->orders()->with(['items.product.images']);

        // Filter by status
        if (request('status') && request('status') !== 'all') {
            $query->where('status', request('status'));
        }

        // Search by order code
        if (request('search')) {
            $query->where('order_code', 'like', '%' . request('search') . '%');
        }

        $orders = $query->latest('placed_at')->paginate(10)->withQueryString();

        return view('orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function show(Order $order): View
    {
        // Check authorization
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product.images');

        return view('orders.show', compact('order'));
    }

    /**
     * Reorder - add all order items to cart
     */
    public function reorder(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $cart = auth()->user()->getActiveCart();
        $addedCount = 0;

        foreach ($order->items as $item) {
            // Check if product still exists and has stock
            if ($item->product && $item->product->status === 'active' && $item->product->stock > 0) {
                $existingItem = $cart->items()->where('product_id', $item->product_id)->first();

                if ($existingItem) {
                    // Update quantity if item already in cart
                    $newQty = min($existingItem->qty + $item->qty, $item->product->stock);
                    $existingItem->update(['qty' => $newQty]);
                } else {
                    // Add new item to cart
                    $cart->items()->create([
                        'product_id' => $item->product_id,
                        'price' => $item->product->getDisplayPrice(),
                        'qty' => min($item->qty, $item->product->stock),
                    ]);
                }
                $addedCount++;
            }
        }

        if ($addedCount > 0) {
            return redirect()->route('cart.index')->with('success', "Đã thêm {$addedCount} sản phẩm vào giỏ hàng");
        } else {
            return back()->with('error', 'Không có sản phẩm nào khả dụng để đặt lại');
        }
    }

    /**
     * Cancel order (user can only cancel pending orders)
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($order->status, ['pending', 'paid'])) {
            return back()->with('error', 'Không thể hủy đơn hàng này');
        }

        $oldStatus = $order->status;

        // Restore product stock
        $order->load('items.product');
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->qty);
            }
        }

        $order->update(['status' => 'cancelled']);

        // Log the cancellation
        \App\Services\AuditService::logOrderStatusChange($order, $oldStatus, 'cancelled');

        return back()->with('success', 'Đơn hàng đã bị hủy');
    }
}
