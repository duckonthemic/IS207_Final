<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display list of all orders
     */
    public function index(Request $request): View
    {
        $perPage = $request->input('per_page', 20);
        $status = $request->input('status');
        $payment_status = $request->input('payment_status');

        // Optimize eager loading - only load necessary user fields
        $query = Order::with('user:id,name,email', 'items:id,order_id,product_id,qty,price');

        if ($status) {
            $query->where('status', $status);
        }

        if ($payment_status) {
            $query->where('payment_status', $payment_status);
        }

        $orders = $query->latest('placed_at')->paginate($perPage);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function show(Order $order): View
    {
        // Eager load with specific fields to reduce data transfer
        $order->load([
            'user:id,name,email',
            'items.product:id,name,slug,price,image',
            'items.product.images' => function($query) {
                $query->where('is_primary', true)->limit(1);
            }
        ]);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,picking,shipped,delivered,cancelled,refunded',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $order->update($validated);

        return back()->with('success', 'Trạng thái đơn hàng đã được cập nhật');
    }
}
