@extends('layouts.app')

@section('title', 'Admin Dashboard - UITech')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-12">
        <h1 class="text-3xl font-bold text-cyber-text">Bảng điều khiển quản lý</h1>
        <p class="text-cyber-muted">Tổng quan về hoạt động kinh doanh</p>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        {{-- Total Orders --}}
        <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 hover:border-cyber-accent transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-cyber-muted text-sm">Tổng đơn hàng</p>
                    <p class="text-3xl font-bold text-cyber-text">{{ $totalOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-cyber-accent/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-cyber-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 hover:border-cyber-accent transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-cyber-muted text-sm">Tổng doanh thu</p>
                    <p class="text-3xl font-bold text-cyber-accent">{{ number_format($totalRevenue, 0, ',', '.') }}₫</p>
                </div>
                <div class="w-12 h-12 bg-cyber-accent/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-cyber-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 hover:border-cyber-accent transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-cyber-muted text-sm">Đơn hàng chờ xử lý</p>
                    <p class="text-3xl font-bold text-cyber-error">{{ $pendingOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-cyber-error/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-cyber-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Products --}}
        <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 hover:border-cyber-accent transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-cyber-muted text-sm">Tổng sản phẩm</p>
                    <p class="text-3xl font-bold text-cyber-text">{{ $totalProducts }}</p>
                </div>
                <div class="w-12 h-12 bg-cyber-success/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-cyber-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
        {{-- Recent Orders Table --}}
        <div class="lg:col-span-2">
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-text mb-4">Đơn hàng gần đây</h2>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-cyber-border">
                                <th class="text-left py-3 px-2 text-cyber-muted">Mã đơn</th>
                                <th class="text-left py-3 px-2 text-cyber-muted">Khách hàng</th>
                                <th class="text-left py-3 px-2 text-cyber-muted">Tổng tiền</th>
                                <th class="text-left py-3 px-2 text-cyber-muted">Trạng thái</th>
                                <th class="text-left py-3 px-2 text-cyber-muted">Ngày</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr class="border-b border-cyber-border/30 hover:bg-cyber-darker/30 transition-colors">
                                    <td class="py-3 px-2 text-cyber-accent font-semibold">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-cyber-glow">
                                            {{ $order->order_code }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-2 text-cyber-text">{{ $order->user->name }}</td>
                                    <td class="py-3 px-2 text-cyber-text">{{ number_format($order->total, 0, ',', '.') }}₫</td>
                                    <td class="py-3 px-2">
                                        <span class="px-2 py-1 rounded text-xs font-bold 
                                            @if($order->status === 'pending') bg-cyber-muted/20 text-cyber-muted
                                            @elseif($order->status === 'paid') bg-cyber-success/20 text-cyber-success
                                            @elseif($order->status === 'shipped') bg-cyber-accent/20 text-cyber-accent
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-2 text-cyber-muted">{{ $order->placed_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-cyber-muted">Chưa có đơn hàng</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Top Products --}}
        <div>
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-text mb-4">Sản phẩm bán chạy</h2>
                
                <div class="space-y-3">
                    @forelse($topProducts as $item)
                        <div class="pb-3 border-b border-cyber-border/30 last:border-0">
                            <p class="text-cyber-text font-semibold line-clamp-1">{{ $item->product->name }}</p>
                            <div class="flex justify-between mt-1">
                                <span class="text-cyber-muted text-sm">{{ $item->quantity }} đã bán</span>
                                <span class="text-cyber-accent font-bold">{{ number_format($item->revenue, 0, ',', '.') }}₫</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-cyber-muted text-sm">Chưa có dữ liệu</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Management Links --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('admin.products.index') }}" class="bg-cyber-card border border-cyber-border rounded-lg p-6 hover:border-cyber-accent hover:shadow-glow-cyan transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-cyber-text group-hover:text-cyber-accent">Quản lý sản phẩm</h3>
                    <p class="text-cyber-muted text-sm">{{ $totalProducts }} sản phẩm</p>
                </div>
                <svg class="w-8 h-8 text-cyber-accent/30 group-hover:text-cyber-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        <a href="{{ route('admin.orders.index') }}" class="bg-cyber-card border border-cyber-border rounded-lg p-6 hover:border-cyber-accent hover:shadow-glow-cyan transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-cyber-text group-hover:text-cyber-accent">Quản lý đơn hàng</h3>
                    <p class="text-cyber-muted text-sm">{{ $totalOrders }} đơn hàng</p>
                </div>
                <svg class="w-8 h-8 text-cyber-accent/30 group-hover:text-cyber-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>
    </div>
</div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium mb-2">Người dùng</h3>
            <p class="text-3xl font-bold text-gray-900">0</p>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Quản lý nhanh</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.products.create') }}" class="block p-4 border-2 border-indigo-200 rounded-lg hover:border-indigo-600 transition duration-200">
                <h3 class="font-semibold text-indigo-600 mb-2">➕ Thêm sản phẩm</h3>
                <p class="text-sm text-gray-600">Thêm sản phẩm mới vào kho</p>
            </a>
            <a href="{{ route('admin.products.index') }}" class="block p-4 border-2 border-indigo-200 rounded-lg hover:border-indigo-600 transition duration-200">
                <h3 class="font-semibold text-indigo-600 mb-2">📋 Quản lý sản phẩm</h3>
                <p class="text-sm text-gray-600">Xem và chỉnh sửa sản phẩm</p>
            </a>
            <a href="#" class="block p-4 border-2 border-indigo-200 rounded-lg hover:border-indigo-600 transition duration-200">
                <h3 class="font-semibold text-indigo-600 mb-2">📊 Xem báo cáo</h3>
                <p class="text-sm text-gray-600">Xem thống kê bán hàng</p>
            </a>
        </div>
    </div>
</div>
@endsection
