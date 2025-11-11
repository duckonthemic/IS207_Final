<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard with KPIs
     */
    public function index(): View
    {
        // Key Performance Indicators
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_products' => Product::count(),
            'total_customers' => \App\Models\User::where('role', 'user')->count(),
        ];

        // Recent orders
        $recent_orders = Order::with('user')
            ->latest('placed_at')
            ->limit(10)
            ->get();

        // Sales data (last 30 days)
        $sales_data = Order::where('payment_status', 'paid')
            ->where('placed_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(placed_at) as date, SUM(total) as revenue, COUNT(*) as orders')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        // Top products
        $top_products = Product::withCount(['orderItems as total_sold' => function ($query) {
            $query->join('orders', 'order_items.order_id', '=', 'orders.id')
                  ->where('orders.payment_status', 'paid');
        }])
        ->orderByDesc('total_sold')
        ->limit(10)
        ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'sales_data', 'top_products'));
    }
}
