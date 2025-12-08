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

        $query = Order::with('user', 'items');

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
        $order->load('user', 'items.product');

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
