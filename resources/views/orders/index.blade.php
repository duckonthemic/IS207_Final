@extends('layouts.app')

@section('title', 'Đơn hàng của tôi - UITech')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-cyber-text mb-2">Đơn hàng của tôi</h1>
        <p class="text-cyber-muted">Quản lý và theo dõi đơn hàng của bạn</p>
    </div>

    {{-- Filters --}}
    <div class="bg-cyber-card border border-cyber-border rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('orders.index') }}" class="flex flex-wrap gap-4 items-end">
            {{-- Search by order code --}}
            <div class="flex-1 min-w-[200px]">
                <label class="block text-cyber-text text-sm font-medium mb-2">Tìm kiếm</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Nhập mã đơn hàng..." 
                       class="w-full px-4 py-2 bg-cyber-darker border border-cyber-border rounded-lg text-cyber-text focus:border-cyber-accent focus:outline-none">
            </div>

            {{-- Status filter --}}
            <div class="w-48">
                <label class="block text-cyber-text text-sm font-medium mb-2">Trạng thái</label>
                <select name="status" class="w-full px-4 py-2 bg-cyber-darker border border-cyber-border rounded-lg text-cyber-text focus:border-cyber-accent focus:outline-none">
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Tất cả</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                    <option value="picking" {{ request('status') === 'picking' ? 'selected' : '' }}>Đang lấy hàng</option>
                    <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Đang giao</option>
                    <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Đã giao</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Hoàn tiền</option>
                </select>
            </div>

            {{-- Filter buttons --}}
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-cyber-accent text-cyber-darker rounded-lg hover:shadow-glow-cyan transition-all font-semibold">
                    🔍 Lọc
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('orders.index') }}" class="px-6 py-2 border border-cyber-border text-cyber-text rounded-lg hover:border-cyber-accent transition-all">
                        ✕ Xóa bộ lọc
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Orders List --}}
    @if($orders->isEmpty())
        <div class="bg-cyber-card border border-cyber-border rounded-lg p-12 text-center">
            <svg class="w-20 h-20 mx-auto mb-4 text-cyber-muted opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="text-cyber-muted text-lg mb-6">
                @if(request('search') || request('status'))
                    Không tìm thấy đơn hàng nào
                @else
                    Bạn chưa có đơn hàng nào
                @endif
            </p>
            <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-cyber-accent text-cyber-darker rounded-lg hover:shadow-glow-cyan transition-all font-semibold">
                Bắt đầu mua sắm
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-cyber-card border border-cyber-border rounded-lg hover:border-cyber-accent transition-colors">
                    {{-- Order Header --}}
                    <div class="p-4 border-b border-cyber-border flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div>
                                <p class="text-cyber-text font-bold">{{ $order->order_code }}</p>
                                <p class="text-cyber-muted text-sm">{{ $order->placed_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                @php
                                    $statusConfig = [
                                        'pending' => ['text' => 'Chờ xử lý', 'class' => 'bg-yellow-500/20 text-yellow-400'],
                                        'paid' => ['text' => 'Đã thanh toán', 'class' => 'bg-blue-500/20 text-blue-400'],
                                        'picking' => ['text' => 'Đang lấy hàng', 'class' => 'bg-purple-500/20 text-purple-400'],
                                        'shipped' => ['text' => 'Đang giao', 'class' => 'bg-cyan-500/20 text-cyan-400'],
                                        'delivered' => ['text' => 'Đã giao', 'class' => 'bg-cyber-glow/20 text-cyber-glow'],
                                        'cancelled' => ['text' => 'Đã hủy', 'class' => 'bg-cyber-error/20 text-cyber-error'],
                                        'refunded' => ['text' => 'Hoàn tiền', 'class' => 'bg-gray-500/20 text-gray-400'],
                                    ];
                                    $config = $statusConfig[$order->status] ?? ['text' => $order->status, 'class' => 'bg-cyber-border text-cyber-muted'];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $config['class'] }}">
                                    {{ $config['text'] }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-cyber-muted text-sm">Tổng tiền</p>
                            <p class="text-cyber-accent font-bold text-lg">{{ number_format($order->total, 0, ',', '.') }}₫</p>
                        </div>
                    </div>

                    {{-- Order Items Preview --}}
                    <div class="p-4">
                        <div class="space-y-3 mb-4">
                            @foreach($order->items->take(3) as $item)
                                <div class="flex gap-3 items-center">
                                    <div class="w-16 h-16 bg-cyber-darker rounded flex-shrink-0 overflow-hidden">
                                        @if($item->product && $item->product->images->first())
                                            <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-cyber-text font-medium truncate">
                                            {{ $item->product ? $item->product->name : 'Sản phẩm không tồn tại' }}
                                        </p>
                                        <p class="text-cyber-muted text-sm">
                                            {{ number_format($item->price, 0, ',', '.') }}₫ × {{ $item->qty }}
                                        </p>
                                    </div>
                                    <p class="text-cyber-accent font-bold">
                                        {{ number_format($item->price * $item->qty, 0, ',', '.') }}₫
                                    </p>
                                </div>
                            @endforeach
                            @if($order->items->count() > 3)
                                <p class="text-cyber-muted text-sm text-center">
                                    và {{ $order->items->count() - 3 }} sản phẩm khác...
                                </p>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('orders.show', $order) }}" class="flex-1 min-w-[150px] px-4 py-2 bg-cyber-accent text-cyber-darker rounded-lg hover:shadow-glow-cyan transition-all font-semibold text-center">
                                Xem chi tiết
                            </a>
                            <form method="POST" action="{{ route('orders.reorder', $order) }}" class="flex-1 min-w-[150px]">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 border border-cyber-accent text-cyber-accent rounded-lg hover:bg-cyber-accent/10 transition-all font-semibold">
                                    🔄 Đặt lại
                                </button>
                            </form>
                            @if(in_array($order->status, ['pending', 'paid']))
                                <form method="POST" action="{{ route('orders.cancel', $order) }}" 
                                      onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')"
                                      class="flex-1 min-w-[150px]">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 border border-cyber-error text-cyber-error rounded-lg hover:bg-cyber-error/10 transition-all font-semibold">
                                        ✕ Hủy đơn
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
