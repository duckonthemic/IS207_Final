@extends('layouts.app')

@section('title', 'Admin Dashboard - UITech')

@section('content')
<div class="min-h-screen bg-cyber-dark">
    <div class="max-w-7xl mx-auto px-4 py-12">
        {{-- Header --}}
        <div class="mb-12">
            <div class="text-cyber-accent text-sm font-mono font-bold mb-2">// ADMIN DASHBOARD</div>
            <h1 class="text-4xl font-bold text-cyber-text">Bảng Điều Khiển</h1>
            <p class="text-cyber-muted mt-2">Quản lý hệ thống UITech</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            {{-- Products Card --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 hover:border-cyber-accent/50 transition-colors">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-cyber-muted text-sm mb-2">SẢN PHẨM</p>
                        <h3 class="text-3xl font-bold text-cyber-accent">{{ \App\Models\Product::count() }}</h3>
                        <p class="text-cyber-muted text-xs mt-2">{{ \App\Models\Product::whereNull('deleted_at')->count() }} còn hoạt động</p>
                    </div>
                    <div class="text-5xl opacity-20">📦</div>
                </div>
            </div>

            {{-- Categories Card --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 hover:border-cyber-accent/50 transition-colors">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-cyber-muted text-sm mb-2">DANH MỤC</p>
                        <h3 class="text-3xl font-bold text-cyber-accent">{{ \App\Models\Category::count() }}</h3>
                        <p class="text-cyber-muted text-xs mt-2">Bộ sưu tập sản phẩm</p>
                    </div>
                    <div class="text-5xl opacity-20">📂</div>
                </div>
            </div>

            {{-- Orders Card --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 hover:border-cyber-accent/50 transition-colors">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-cyber-muted text-sm mb-2">ĐƠN HÀNG</p>
                        <h3 class="text-3xl font-bold text-cyber-accent">{{ \App\Models\Order::count() }}</h3>
                        <p class="text-cyber-muted text-xs mt-2">Tổng cộng</p>
                    </div>
                    <div class="text-5xl opacity-20">🛒</div>
                </div>
            </div>

            {{-- Users Card --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 hover:border-cyber-accent/50 transition-colors">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-cyber-muted text-sm mb-2">NGƯỜI DÙNG</p>
                        <h3 class="text-3xl font-bold text-cyber-accent">{{ \App\Models\User::count() }}</h3>
                        <p class="text-cyber-muted text-xs mt-2">Thành viên hệ thống</p>
                    </div>
                    <div class="text-5xl opacity-20">👥</div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            {{-- Left Column --}}
            <div>
                <div class="text-cyber-accent text-sm font-mono font-bold mb-4">▸ QUẢN LÝ SẢN PHẨM</div>
                <div class="space-y-3">
                    <a href="#" class="block p-4 bg-cyber-card border border-cyber-border rounded-lg hover:border-cyber-accent/50 transition-colors group">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-cyber-text group-hover:text-cyber-accent transition-colors">Thêm Sản Phẩm Mới</h4>
                                <p class="text-cyber-muted text-sm">Tạo sản phẩm mới cho kho</p>
                            </div>
                            <div class="text-2xl">➕</div>
                        </div>
                    </a>
                    
                    <a href="#" class="block p-4 bg-cyber-card border border-cyber-border rounded-lg hover:border-cyber-accent/50 transition-colors group">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-cyber-text group-hover:text-cyber-accent transition-colors">Quản Lý Sản Phẩm</h4>
                                <p class="text-cyber-muted text-sm">Chỉnh sửa, xóa sản phẩm hiện tại</p>
                            </div>
                            <div class="text-2xl">✏️</div>
                        </div>
                    </a>
                    
                    <a href="#" class="block p-4 bg-cyber-card border border-cyber-border rounded-lg hover:border-cyber-accent/50 transition-colors group">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-cyber-text group-hover:text-cyber-accent transition-colors">Danh Mục</h4>
                                <p class="text-cyber-muted text-sm">Quản lý danh mục sản phẩm</p>
                            </div>
                            <div class="text-2xl">📂</div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Right Column --}}
            <div>
                <div class="text-cyber-accent text-sm font-mono font-bold mb-4">▸ QUẢN LÝ ĐƠN HÀNG</div>
                <div class="space-y-3">
                    <a href="#" class="block p-4 bg-cyber-card border border-cyber-border rounded-lg hover:border-cyber-accent/50 transition-colors group">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-cyber-text group-hover:text-cyber-accent transition-colors">Xem Tất Cả Đơn</h4>
                                <p class="text-cyber-muted text-sm">Danh sách toàn bộ đơn hàng</p>
                            </div>
                            <div class="text-2xl">📋</div>
                        </div>
                    </a>
                    
                    <a href="#" class="block p-4 bg-cyber-card border border-cyber-border rounded-lg hover:border-cyber-accent/50 transition-colors group">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-cyber-text group-hover:text-cyber-accent transition-colors">Đơn Chưa Xử Lý</h4>
                                <p class="text-cyber-muted text-sm">Các đơn hàng mới</p>
                            </div>
                            <div class="text-2xl">⏳</div>
                        </div>
                    </a>
                    
                    <a href="#" class="block p-4 bg-cyber-card border border-cyber-border rounded-lg hover:border-cyber-accent/50 transition-colors group">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-cyber-text group-hover:text-cyber-accent transition-colors">Báo Cáo Bán Hàng</h4>
                                <p class="text-cyber-muted text-sm">Thống kê bán hàng theo thời gian</p>
                            </div>
                            <div class="text-2xl">📊</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Recent Products --}}
        <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
            <h3 class="text-cyber-accent text-sm font-mono font-bold mb-6">▸ SẢN PHẨM GẦN ĐÂY</h3>
            
            @php
                $recentProducts = \App\Models\Product::with('category')->latest()->limit(5)->get();
            @endphp

            @if($recentProducts->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-cyber-border">
                            <th class="text-left text-cyber-muted text-xs font-mono uppercase py-3">Sản Phẩm</th>
                            <th class="text-left text-cyber-muted text-xs font-mono uppercase py-3">Danh Mục</th>
                            <th class="text-right text-cyber-muted text-xs font-mono uppercase py-3">Giá</th>
                            <th class="text-right text-cyber-muted text-xs font-mono uppercase py-3">Kho</th>
                            <th class="text-right text-cyber-muted text-xs font-mono uppercase py-3">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-cyber-border">
                        @foreach($recentProducts as $product)
                        <tr class="hover:bg-cyber-darker/50 transition-colors">
                            <td class="py-3">
                                <div class="flex items-center gap-3">
                                    @if($product->image)
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-10 h-10 rounded object-cover">
                                    @else
                                    <div class="w-10 h-10 rounded bg-cyber-darker flex items-center justify-center text-cyber-muted">📦</div>
                                    @endif
                                    <div>
                                        <p class="text-cyber-text font-semibold line-clamp-1">{{ $product->name }}</p>
                                        <p class="text-cyber-muted text-xs">{{ $product->sku }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-cyber-muted text-sm">{{ $product->category->name }}</td>
                            <td class="py-3 text-right text-cyber-accent font-bold">{{ number_format($product->price, 0, ',', '.') }}₫</td>
                            <td class="py-3 text-right">
                                @if($product->stock > 0)
                                <span class="text-cyber-success text-sm font-mono">{{ $product->stock }} cái</span>
                                @else
                                <span class="text-cyber-error text-sm font-mono">Hết hàng</span>
                                @endif
                            </td>
                            <td class="py-3 text-right">
                                <a href="#" class="text-cyber-accent hover:text-cyber-accent text-xs font-mono">Sửa</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-12 text-cyber-muted">
                <p>Chưa có sản phẩm nào</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
