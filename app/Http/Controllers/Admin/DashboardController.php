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
        // Total stats
        $totalOrders = Order::count();
        $totalRevenue = Order::whereIn('status', ['completed', 'shipping', 'processing'])->sum('grand_total');
        $totalUsers = User::where('role', 'user')->count();
        $totalProducts = Product::count();

        // Today stats
        $pendingOrders = Order::where('status', 'pending')->count();
        $revenueToday = Order::whereDate('created_at', today())
            ->whereIn('status', ['completed', 'shipping', 'processing'])
            ->sum('grand_total');
        $newUsersToday = User::whereDate('created_at', today())->count();
        
        // Low stock products (stock <= 10)
        $lowStockCount = Product::where('stock', '<=', 10)->where('stock', '>', 0)->count();
        $lowStockProducts = Product::with('images')
            ->where('stock', '<=', 10)
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->limit(5)
            ->get();

        // Recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(8)
            ->get();

        // Revenue chart data (last 7 days)
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d/m');
            
            $revenue = Order::whereDate('created_at', $date)
                ->whereIn('status', ['completed', 'shipping', 'processing'])
                ->sum('grand_total');
            
            $chartData[] = $revenue;
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
