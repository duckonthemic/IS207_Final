@extends('layouts.admin')

@section('title', 'Admin Dashboard - PC Parts Store')

@section('content')
    <div class="min-h-screen bg-cyber-black p-8">
        <div class="max-w-7xl mx-auto">
            {{-- Header --}}
            <div class="mb-8 border-b border-cyber-border pb-6">
                <h1 class="text-3xl font-black text-cyber-white uppercase tracking-tighter mb-2">Dashboard</h1>
                <p class="text-cyber-text-muted font-mono text-sm">// SYSTEM_OVERVIEW</p>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                {{-- Total Orders --}}
                <a href="{{ route('admin.orders.index') }}"
                    class="bg-cyber-black border border-cyber-border p-6 hover:border-cyber-white transition-colors group block">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Tổng đơn hàng
                            </p>
                            <h3 class="text-3xl font-black text-cyber-white font-mono">{{ $totalOrders }}</h3>
                            <p class="text-xs text-cyber-text-muted mt-2 font-mono">
                                <span class="text-green-400 font-bold">{{ $pendingOrders }}</span> PENDING
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-cyber-gray border border-cyber-border flex items-center justify-center group-hover:bg-cyber-white group-hover:text-cyber-black transition-colors text-cyber-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- Total Revenue --}}
                <a href="{{ route('admin.orders.index') }}?status=delivered"
                    class="bg-cyber-black border border-cyber-border p-6 hover:border-cyber-white transition-colors group block">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Doanh thu</p>
                            <h3 class="text-3xl font-black text-cyber-white font-mono">
                                {{ number_format($totalRevenue, 0, ',', '.') }}₫
                            </h3>
                            <p class="text-xs text-cyber-text-muted mt-2 font-mono">
                                <span
                                    class="text-green-400 font-bold">+{{ number_format($revenueToday, 0, ',', '.') }}₫</span>
                                TODAY
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-cyber-gray border border-cyber-border flex items-center justify-center group-hover:bg-cyber-white group-hover:text-cyber-black transition-colors text-cyber-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- Total Users --}}
                <div class="bg-cyber-black border border-cyber-border p-6 hover:border-cyber-white transition-colors group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Người dùng</p>
                            <h3 class="text-3xl font-black text-cyber-white font-mono">{{ $totalUsers }}</h3>
                            <p class="text-xs text-cyber-text-muted mt-2 font-mono">
                                <span class="text-blue-400 font-bold">{{ $newUsersToday }}</span> NEW TODAY
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-cyber-gray border border-cyber-border flex items-center justify-center group-hover:bg-cyber-white group-hover:text-cyber-black transition-colors text-cyber-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total Products --}}
                <a href="{{ route('admin.products.index') }}"
                    class="bg-cyber-black border border-cyber-border p-6 hover:border-cyber-white transition-colors group block">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Sản phẩm</p>
                            <h3 class="text-3xl font-black text-cyber-white font-mono">{{ $totalProducts }}</h3>
                            <p class="text-xs text-cyber-text-muted mt-2 font-mono">
                                <span class="text-red-500 font-bold">{{ $lowStockCount }}</span> LOW STOCK
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-cyber-gray border border-cyber-border flex items-center justify-center group-hover:bg-cyber-white group-hover:text-cyber-black transition-colors text-cyber-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                {{-- Recent Orders --}}
                <div class="lg:col-span-2 bg-cyber-black border border-cyber-border p-6">
                    <div class="flex items-center justify-between mb-6 border-b border-cyber-border pb-4">
                        <h2 class="text-lg font-black text-cyber-white uppercase tracking-wider">Đơn hàng gần đây</h2>
                        <a href="{{ route('admin.orders.index') }}"
                            class="text-cyber-text-muted hover:text-cyber-white text-xs font-bold uppercase tracking-wider transition-colors">
                            Xem tất cả →
                        </a>
                    </div>

                    @if($recentOrders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="border-b border-cyber-border">
                                        <th class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider py-3">Mã đơn
                                        </th>
                                        <th class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider py-3">Khách
                                            hàng</th>
                                        <th
                                            class="text-right text-cyber-text-muted text-xs font-bold uppercase tracking-wider py-3">
                                            Tổng tiền</th>
                                        <th
                                            class="text-center text-cyber-text-muted text-xs font-bold uppercase tracking-wider py-3">
                                            Trạng thái</th>
                                        <th
                                            class="text-right text-cyber-text-muted text-xs font-bold uppercase tracking-wider py-3">
                                            Thời gian</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-cyber-border">
                                    @foreach($recentOrders as $order)
                                        <tr class="hover:bg-cyber-gray transition-colors">
                                            <td class="py-3">
                                                <a href="{{ route('admin.orders.show', $order) }}"
                                                    class="text-cyber-white hover:text-cyber-text-muted font-mono text-sm font-bold">
                                                    {{ $order->order_code ?? 'ORD-' . $order->id }}
                                                </a>
                                            </td>
                                            <td class="py-3 text-cyber-text text-sm">
                                                {{ $order->user->name ?? $order->shipping_name ?? 'N/A' }}
                                            </td>
                                            <td class="py-3 text-right text-cyber-white font-mono font-bold text-sm">
                                                {{ number_format($order->total ?? 0, 0, ',', '.') }}₫
                                            </td>
                                            <td class="py-3 text-center">
                                                @php
                                                    $statusClasses = [
                                                        'pending' => 'text-yellow-500 border-yellow-500',
                                                        'processing' => 'text-purple-400 border-purple-400',
                                                        'picking' => 'text-blue-400 border-blue-400',
                                                        'shipped' => 'text-indigo-400 border-indigo-400',
                                                        'delivered' => 'text-green-400 border-green-400',
                                                        'cancelled' => 'text-red-500 border-red-500',
                                                        'refunded' => 'text-gray-400 border-gray-400',
                                                    ];
                                                    $statusLabels = [
                                                        'pending' => 'Chờ xử lý',
                                                        'processing' => 'Đang xử lý',
                                                        'picking' => 'Đang lấy hàng',
                                                        'shipped' => 'Đang giao',
                                                        'delivered' => 'Đã giao',
                                                        'cancelled' => 'Đã hủy',
                                                        'refunded' => 'Hoàn tiền',
                                                    ];
                                                @endphp
                                                <span
                                                    class="inline-block px-2 py-1 border text-[10px] font-bold uppercase tracking-wider {{ $statusClasses[$order->status] ?? 'text-gray-400 border-gray-400' }}">
                                                    {{ $statusLabels[$order->status] ?? $order->status }}
                                                </span>
                                            </td>
                                            <td class="py-3 text-right text-cyber-text-muted text-xs font-mono">
                                                {{ $order->created_at->diffForHumans() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12 text-cyber-text-muted border border-cyber-border border-dashed">
                            <p class="uppercase tracking-widest text-sm">Chưa có đơn hàng nào</p>
                        </div>
                    @endif
                </div>

                {{-- Low Stock Alerts --}}
                <div class="bg-cyber-black border border-cyber-border p-6">
                    <div class="flex items-center justify-between mb-6 border-b border-cyber-border pb-4">
                        <h2 class="text-lg font-black text-cyber-white uppercase tracking-wider">Cảnh báo tồn kho</h2>
                        <span
                            class="inline-flex items-center px-2 py-1 border border-red-500 text-red-500 text-xs font-bold font-mono">
                            {{ $lowStockProducts->count() }}
                        </span>
                    </div>

                    @if($lowStockProducts->count() > 0)
                        <div class="space-y-4">
                            @foreach($lowStockProducts as $product)
                                <div
                                    class="flex items-center gap-3 p-3 bg-cyber-gray border border-cyber-border hover:border-red-500 transition-colors group">
                                    <div class="flex-shrink-0 w-12 h-12 bg-cyber-black border border-cyber-border p-1">
                                        @if($product->images->first())
                                            <img src="{{ asset($product->images->first()->url) }}" alt="{{ $product->name }}"
                                                class="w-full h-full object-contain">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-cyber-text-muted text-xs">
                                                IMG</div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p
                                            class="text-sm font-bold text-cyber-white truncate group-hover:text-red-500 transition-colors">
                                            {{ $product->name }}
                                        </p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs text-red-500 font-bold uppercase tracking-wider">Stock:
                                                {{ $product->stock }}</span>
                                            <span class="text-xs text-cyber-text-muted font-mono">SKU: {{ $product->sku }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="flex-shrink-0 text-cyber-text-muted hover:text-cyber-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 text-cyber-text-muted border border-cyber-border border-dashed">
                            <p class="uppercase tracking-widest text-sm">Tất cả sản phẩm đều đủ hàng</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Revenue Chart (Last 7 Days) --}}
            <div class="bg-cyber-black border border-cyber-border p-6">
                <h2
                    class="text-lg font-black text-cyber-white mb-6 border-b border-cyber-border pb-4 uppercase tracking-wider">
                    Doanh thu 7 ngày gần đây</h2>

                <div class="h-64">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue Chart
        const ctx = document.getElementById('revenueChart').getContext('2d');

        // Cyber Theme Colors
        const cyberWhite = '#ffffff';
        const cyberBorder = '#333333';
        const cyberTextMuted = '#888888';

        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Doanh thu (₫)',
                    data: @json($chartData),
                    borderColor: cyberWhite,
                    backgroundColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 2,
                    tension: 0, // Sharp lines for cyber feel
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#000000',
                    pointBorderColor: cyberWhite,
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#000000',
                        titleColor: cyberWhite,
                        bodyColor: cyberWhite,
                        borderColor: cyberBorder,
                        borderWidth: 1,
                        padding: 12,
                        titleFont: {
                            family: 'Courier New',
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            family: 'Courier New',
                            size: 13
                        },
                        callbacks: {
                            label: function (context) {
                                return 'REVENUE: ' + context.parsed.y.toLocaleString('vi-VN') + '₫';
                            }
                        },
                        displayColors: false,
                        cornerRadius: 0
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: cyberTextMuted,
                            font: {
                                family: 'Courier New',
                                size: 10
                            },
                            callback: function (value) {
                                return (value / 1000000).toFixed(0) + 'M';
                            }
                        },
                        grid: {
                            color: cyberBorder,
                            drawBorder: false,
                        },
                        border: {
                            display: false
                        }
                    },
                    x: {
                        ticks: {
                            color: cyberTextMuted,
                            font: {
                                family: 'Courier New',
                                size: 10
                            }
                        },
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endsection