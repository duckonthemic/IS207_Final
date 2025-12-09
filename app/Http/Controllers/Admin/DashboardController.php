<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard with KPIs
     */
    public function index(): View
    {
        // Optimize query execution by combining similar queries
        $completedStatuses = ['completed', 'shipping', 'processing'];
        
        // Total stats - combine related queries
        $orderStats = Order::selectRaw('
            COUNT(*) as total_orders,
            SUM(CASE WHEN status IN ("completed", "shipping", "processing") THEN total ELSE 0 END) as total_revenue,
            COUNT(CASE WHEN status = "pending" THEN 1 END) as pending_orders
        ')->first();
        
        $totalOrders = $orderStats->total_orders;
        $totalRevenue = $orderStats->total_revenue;
        $pendingOrders = $orderStats->pending_orders;
        
        $totalUsers = User::where('role', 'user')->count();
        $totalProducts = Product::count();

        // Today stats - combine queries
        $todayStats = Order::selectRaw('
            SUM(CASE WHEN status IN ("completed", "shipping", "processing") THEN total ELSE 0 END) as revenue_today
        ')
        ->whereDate('created_at', today())
        ->first();
        
        $revenueToday = $todayStats->revenue_today ?? 0;
        $newUsersToday = User::whereDate('created_at', today())->count();
        
        // Low stock products (stock <= 10)
        $lowStockCount = Product::where('stock', '<=', 10)->where('stock', '>', 0)->count();
        $lowStockProducts = Product::with(['images' => function($query) {
                $query->orderBy('is_primary', 'desc')->limit(1);
            }])
            ->where('stock', '<=', 10)
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->limit(5)
            ->get();

        // Recent orders - eager load user to avoid N+1
        $recentOrders = Order::with('user:id,name,email')
            ->latest()
            ->limit(8)
            ->get();

        // Revenue chart data (last 7 days) - use single query
        $chartLabels = [];
        $chartData = [];
        
        $revenueByDate = Order::selectRaw('
            DATE(created_at) as date,
            SUM(total) as revenue
        ')
        ->where('created_at', '>=', Carbon::today()->subDays(6))
        ->whereIn('status', $completedStatuses)
        ->groupBy('date')
        ->pluck('revenue', 'date');
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d/m');
            $chartData[] = $revenueByDate->get($date->toDateString(), 0);
        }

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalUsers',
            'totalProducts',
            'pendingOrders',
            'revenueToday',
            'newUsersToday',
            'lowStockCount',
            'lowStockProducts',
            'recentOrders',
            'chartLabels',
            'chartData'
        ));
    }
}
