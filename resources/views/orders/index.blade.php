@extends('layouts.app')

@section('title', 'Đơn hàng của tôi - Tech Parts')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-cyber-text mb-2">Đơn hàng của tôi</h1>
        <p class="text-cyber-muted">Quản lý và theo dõi các đơn hàng</p>
    </div>

    @if($orders->isEmpty())
        <div class="bg-cyber-card border border-cyber-border rounded-lg p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-cyber-muted opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
            <p class="text-cyber-muted mb-6">Bạn chưa có đơn hàng nào</p>
            <a href="{{ route('products.index') }}" class="inline-block px-6 py-2 bg-cyber-accent text-cyber-darker rounded-lg hover:shadow-glow-cyan transition-all font-semibold">
                Tiếp tục mua sắm
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <a href="{{ route('orders.show', $order) }}" class="block">
                    <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 hover:border-cyber-accent hover:shadow-glow-cyan transition-all">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
                            {{-- Order Code --}}
                            <div>
                                <p class="text-cyber-muted text-sm">Mã đơn hàng</p>
                                <p class="text-cyber-accent font-bold">{{ $order->order_code }}</p>
                            </div>

                            {{-- Date --}}
                            <div>
                                <p class="text-cyber-muted text-sm">Ngày đặt</p>
                                <p class="text-cyber-text">{{ $order->placed_at->format('d/m/Y') }}</p>
                            </div>

                            {{-- Total --}}
                            <div>
                                <p class="text-cyber-muted text-sm">Tổng tiền</p>
                                <p class="text-cyber-accent font-bold">{{ number_format($order->total, 0, ',', '.') }}₫</p>
                            </div>

                            {{-- Status --}}
                            <div>
                                <p class="text-cyber-muted text-sm">Trạng thái</p>
                                <span class="inline-block px-3 py-1 rounded text-xs font-bold 
                                    @if($order->status === 'pending') bg-cyber-muted/20 text-cyber-muted
                                    @elseif($order->status === 'paid') bg-cyber-success/20 text-cyber-success
                                    @elseif($order->status === 'shipped') bg-cyber-accent/20 text-cyber-accent
                                    @elseif($order->status === 'delivered') bg-cyber-success/20 text-cyber-success
                                    @elseif($order->status === 'cancelled') bg-cyber-error/20 text-cyber-error
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            {{-- Action --}}
                            <div class="text-right">
                                <svg class="w-5 h-5 text-cyber-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $orders->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection
