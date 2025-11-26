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
        $search = $request->input('search');
        $status = $request->input('status');
        $payment_status = $request->input('payment_status');

        $query = Order::with('user', 'items');

        // Search by order code or customer name/email
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by order status
        if ($status) {
            $query->where('status', $status);
        }

        // Filter by payment status
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

    /**
     * Update order status (separate method for route)
     */
    
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,picking,shipped,delivered,cancelled,refunded',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $order->update([
            'status' => $validated['status'],
            'payment_status' => $validated['payment_status'],
        ]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Trạng thái đơn hàng đã được cập nhật');
    }
}
