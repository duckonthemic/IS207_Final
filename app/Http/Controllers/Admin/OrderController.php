<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\AuditService;
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
        $search = $request->input('search');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $query = Order::with('user', 'items');

        // Search by order code
        if ($search) {
            $query->where('order_code', 'like', "%{$search}%");
        }

        // Filter by status
        if ($status) {
            $query->where('status', $status);
        }

        // Filter by payment status
        if ($payment_status) {
            $query->where('payment_status', $payment_status);
        }

        // Filter by date range
        if ($dateFrom) {
            $query->whereDate('placed_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('placed_at', '<=', $dateTo);
        }

        $orders = $query->latest('placed_at')->paginate($perPage)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function show(Order $order): View
    {
        $order->load(['user', 'items.product.images', 'promotions']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,picking,shipped,delivered,cancelled,refunded',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        // Store old values for comparison
        $oldStatus = $order->status;
        $oldPaymentStatus = $order->payment_status;

        // Check if status is changing to cancelled/refunded
        $isBecomingCancelled = in_array($validated['status'], ['cancelled', 'refunded'])
            && !in_array($oldStatus, ['cancelled', 'refunded']);

        // Check if payment is being refunded
        $isPaymentRefunded = $validated['payment_status'] === 'refunded'
            && $oldPaymentStatus !== 'refunded';

        // Restore stock if order is being cancelled/refunded
        if ($isBecomingCancelled || $isPaymentRefunded) {
            $this->restoreStock($order);
        }

        $order->update($validated);

        // Log status change
        if ($oldStatus !== $validated['status']) {
            AuditService::logOrderStatusChange($order, $oldStatus, $validated['status']);
        }

        // Log payment status change
        if ($oldPaymentStatus !== $validated['payment_status']) {
            AuditService::logPaymentStatusChange($order, $oldPaymentStatus, $validated['payment_status']);
        }

        return back()->with('success', 'Trạng thái đơn hàng đã được cập nhật');
    }

    /**
     * Update order status via AJAX
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'sometimes|in:pending,processing,picking,shipped,delivered,cancelled,refunded',
            'payment_status' => 'sometimes|in:pending,paid,failed,refunded',
        ]);

        // Store old values
        $oldStatus = $order->status;
        $oldPaymentStatus = $order->payment_status;

        // Check if status is changing to cancelled/refunded
        $newStatus = $validated['status'] ?? $oldStatus;
        $newPaymentStatus = $validated['payment_status'] ?? $oldPaymentStatus;

        $isBecomingCancelled = in_array($newStatus, ['cancelled', 'refunded'])
            && !in_array($oldStatus, ['cancelled', 'refunded']);

        $isPaymentRefunded = $newPaymentStatus === 'refunded'
            && $oldPaymentStatus !== 'refunded';

        // Restore stock if being cancelled/refunded
        if ($isBecomingCancelled || $isPaymentRefunded) {
            $this->restoreStock($order);
        }

        $order->update($validated);

        // Log changes
        if (isset($validated['status']) && $oldStatus !== $validated['status']) {
            AuditService::logOrderStatusChange($order, $oldStatus, $validated['status']);
        }
        if (isset($validated['payment_status']) && $oldPaymentStatus !== $validated['payment_status']) {
            AuditService::logPaymentStatusChange($order, $oldPaymentStatus, $validated['payment_status']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Trạng thái đã được cập nhật',
            'order' => [
                'status' => $order->status,
                'payment_status' => $order->payment_status,
            ]
        ]);
    }

    /**
     * Restore product stock when order is cancelled/refunded
     */
    private function restoreStock(Order $order): void
    {
        $order->load('items.product');

        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->qty);
            }
        }
    }
}
