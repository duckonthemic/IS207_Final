<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Show checkout form
     */
    public function show(): View
    {
        $user = auth()->user();
        $cart = $user->getActiveCart();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        $cart->load('items.product');
        $addresses = $user->addresses()->get();
        $defaultAddress = $user->getDefaultAddress();

        return view('checkout.show', compact('cart', 'addresses', 'defaultAddress'));
    }

    /**
     * Process checkout and create order
     */
    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id|belongs_to_user',
            'promotion_code' => 'nullable|exists:promotions,code',
            'payment_method' => 'required|in:cod,bank_transfer,credit_card',
        ]);

        $user = auth()->user();
        $cart = $user->getActiveCart();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        $cart->load('items.product');
        $address = $user->addresses()->findOrFail($request->address_id);

        // Calculate total
        $total = $cart->items->sum(function ($item) {
            return $item->price * $item->qty;
        });

        // Apply promotion if provided
        $discount = 0;
        $promotion = null;

        if ($request->filled('promotion_code')) {
            $promotion = Promotion::where('code', $request->promotion_code)->first();

            if ($promotion && $promotion->canUse($total)) {
                $discount = $promotion->calculateDiscount($total);
            }
        }

        $total = $total - $discount;

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => $this->generateOrderCode(),
            'payment_status' => 'pending',
            'status' => 'pending',
            'total' => $total,
            'placed_at' => now(),
        ]);

        // Create order items
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'price' => $item->price,
                'qty' => $item->qty,
            ]);
        }

        // Create order address
        OrderAddress::create([
            'order_id' => $order->id,
            'fullname' => $address->fullname,
            'phone' => $address->phone,
            'address' => $address->address,
            'city' => $address->city,
            'postal_code' => $address->postal_code,
        ]);

        // Apply promotion
        if ($promotion) {
            $order->promotions()->attach($promotion->id, ['discount_value' => $discount]);
            $promotion->increment('usage_count');
        }

        // Mark cart as ordered
        $cart->update(['status' => 'ordered']);

        // TODO: Process payment based on payment_method

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Đơn hàng đã được tạo thành công');
    }

    private function generateOrderCode(): string
    {
        do {
            $code = 'ORD-' . date('Ymd') . '-' . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (Order::where('order_code', $code)->exists());

        return $code;
    }
}
