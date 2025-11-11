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
        $orders = auth()->user()->orders()
            ->with('items.product', 'address')
            ->latest('placed_at')
            ->paginate(10);

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

        $order->load('items.product', 'address', 'promotions');

        return view('orders.show', compact('order'));
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

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Đơn hàng đã bị hủy');
    }
}
