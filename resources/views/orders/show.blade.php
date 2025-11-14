@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng - UITech')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Breadcrumb --}}
    <nav class="flex items-center space-x-2 mb-8 text-sm">
        <a href="{{ route('orders.index') }}" class="text-cyber-accent hover:underline">Đơn hàng của tôi</a>
        <span class="text-cyber-muted">/</span>
        <span class="text-cyber-text">{{ $order->order_code }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            {{-- Order Info Card --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-cyber-text">{{ $order->order_code }}</h1>
                        <p class="text-cyber-muted text-sm mt-1">Đặt lúc: {{ $order->placed_at->format('d/m/Y H:i') }}</p>
                    </div>
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
                    <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $config['class'] }}">
                        {{ $config['text'] }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-cyber-muted">Phương thức thanh toán</p>
                        <p class="text-cyber-text font-semibold mt-1">
                            {{ $order->payment_method === 'cod' ? 'COD (Thanh toán khi nhận hàng)' : 'Chuyển khoản ngân hàng' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-cyber-muted">Trạng thái thanh toán</p>
                        <p class="text-cyber-text font-semibold mt-1">
                            @if($order->payment_status === 'pending') Chờ thanh toán
                            @elseif($order->payment_status === 'paid') Đã thanh toán
                            @elseif($order->payment_status === 'failed') Thất bại
                            @else Hoàn tiền
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Order Items --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-text mb-6">Sản phẩm</h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex gap-4 pb-4 border-b border-cyber-border last:border-0">
                            <div class="w-20 h-20 bg-cyber-darker rounded-lg flex-shrink-0 overflow-hidden">
                                @if($item->product && $item->product->images->first())
                                    <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-cyber-text">
                                    @if($item->product)
                                        <a href="{{ route('products.show', $item->product) }}" class="hover:text-cyber-accent transition-colors">
                                            {{ $item->product->name }}
                                        </a>
                                    @else
                                        Sản phẩm không tồn tại
                                    @endif
                                </h3>
                                <p class="text-cyber-muted text-sm mt-1">SKU: {{ $item->product->sku ?? 'N/A' }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-cyber-muted text-sm">{{ number_format($item->price, 0, ',', '.') }}  {{ $item->qty }}</span>
                                    <span class="text-cyber-accent font-bold">{{ number_format($item->price * $item->qty, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-text mb-4">Địa chỉ giao hàng</h2>
                <div class="bg-cyber-darker rounded-lg p-4">
                    <p class="font-semibold text-cyber-text">{{ $order->shipping_name }}</p>
                    <p class="text-sm text-cyber-muted mt-1"> {{ $order->shipping_phone }}</p>
                    <p class="text-sm text-cyber-text mt-2">
                         {{ $order->shipping_address }}, {{ $order->shipping_city }}
                    </p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap gap-4">
                <form method="POST" action="{{ route('orders.reorder', $order) }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full px-6 py-3 bg-cyber-accent text-cyber-darker rounded-lg hover:shadow-glow-cyan transition-all font-bold">
                         Đặt lại đơn hàng này
                    </button>
                </form>
                @if(in_array($order->status, ['pending', 'paid']))
                    <form method="POST" action="{{ route('orders.cancel', $order) }}" 
                          onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')"
                          class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-6 py-3 border-2 border-cyber-error text-cyber-error rounded-lg hover:bg-cyber-error/10 transition-all font-bold">
                             Hủy đơn hàng
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Order Timeline --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 sticky top-20">
                <h3 class="font-bold text-cyber-text text-lg mb-6">Lịch sử đơn hàng</h3>
                
                @php
                    $timeline = [
                        ['status' => 'pending', 'label' => 'Đơn hàng đã đặt', 'icon' => '', 'active' => true],
                        ['status' => 'paid', 'label' => 'Đã thanh toán', 'icon' => '', 'active' => in_array($order->status, ['paid', 'picking', 'shipped', 'delivered'])],
                        ['status' => 'picking', 'label' => 'Đang lấy hàng', 'icon' => '', 'active' => in_array($order->status, ['picking', 'shipped', 'delivered'])],
                        ['status' => 'shipped', 'label' => 'Đang giao hàng', 'icon' => '', 'active' => in_array($order->status, ['shipped', 'delivered'])],
                        ['status' => 'delivered', 'label' => 'Đã giao hàng', 'icon' => '', 'active' => $order->status === 'delivered'],
                    ];

                    if ($order->status === 'cancelled') {
                        $timeline = [
                            ['status' => 'pending', 'label' => 'Đơn hàng đã đặt', 'icon' => '', 'active' => true],
                            ['status' => 'cancelled', 'label' => 'Đã hủy', 'icon' => '', 'active' => true],
                        ];
                    } elseif ($order->status === 'refunded') {
                        $timeline[] = ['status' => 'refunded', 'label' => 'Đã hoàn tiền', 'icon' => '', 'active' => true];
                    }
                @endphp

                <div class="relative">
                    @foreach($timeline as $index => $step)
                        <div class="flex items-start gap-4 {{ !$loop->last ? 'pb-8' : '' }}">
                            {{-- Timeline line --}}
                            @if(!$loop->last)
                                <div class="absolute left-5 top-12 w-0.5 h-full {{ $step['active'] ? 'bg-cyber-accent' : 'bg-cyber-border' }}"></div>
                            @endif

                            {{-- Icon --}}
                            <div class="relative z-10 w-10 h-10 rounded-full flex items-center justify-center text-lg {{ $step['active'] ? 'bg-cyber-accent text-cyber-darker' : 'bg-cyber-darker border-2 border-cyber-border' }}">
                                {{ $step['icon'] }}
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 pt-1">
                                <p class="font-semibold {{ $step['active'] ? 'text-cyber-accent' : 'text-cyber-muted' }}">
                                    {{ $step['label'] }}
                                </p>
                                @if($step['status'] === $order->status)
                                    <p class="text-xs text-cyber-muted mt-1">
                                        {{ $order->updated_at->format('d/m/Y H:i') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <h3 class="font-bold text-cyber-text text-lg mb-4">Tổng quan</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between text-cyber-text">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($order->total - 30000, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-cyber-text">
                        <span>Phí vận chuyển:</span>
                        <span>30,000</span>
                    </div>
                </div>

                <div class="border-t border-cyber-border pt-4 mt-4">
                    <div class="flex justify-between font-bold text-cyber-accent text-xl">
                        <span>Tổng cộng:</span>
                        <span>{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
