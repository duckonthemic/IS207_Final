@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng - UITech')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-6xl">
        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 mb-8 text-sm">
            <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-blue-600 transition-colors">Đơn hàng của tôi</a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-900 font-bold">{{ $order->order_code }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                {{-- Order Info Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $order->order_code }}</h1>
                            <p class="text-gray-500 text-sm mt-1">Đặt lúc: {{ $order->placed_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @php
                            $statusConfig = [
                                'pending' => ['text' => 'Chờ xử lý', 'class' => 'bg-yellow-50 text-yellow-700 border-yellow-200'],
                                'paid' => ['text' => 'Đã thanh toán', 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
                                'picking' => ['text' => 'Đang lấy hàng', 'class' => 'bg-purple-50 text-purple-700 border-purple-200'],
                                'shipped' => ['text' => 'Đang giao', 'class' => 'bg-cyan-50 text-cyan-700 border-cyan-200'],
                                'delivered' => ['text' => 'Đã giao', 'class' => 'bg-green-50 text-green-700 border-green-200'],
                                'cancelled' => ['text' => 'Đã hủy', 'class' => 'bg-red-50 text-red-700 border-red-200'],
                                'refunded' => ['text' => 'Hoàn tiền', 'class' => 'bg-gray-50 text-gray-600 border-gray-200'],
                            ];
                            $config = $statusConfig[$order->status] ?? ['text' => $order->status, 'class' => 'bg-gray-50 text-gray-600 border-gray-200'];
                        @endphp
                        <span class="px-4 py-2 border rounded-full text-xs font-bold {{ $config['class'] }}">
                            {{ $config['text'] }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-6 text-sm">
                        <div>
                            <p class="text-gray-500 text-xs uppercase font-bold mb-1">Phương thức thanh toán</p>
                            <p class="text-gray-900 font-medium flex items-center gap-2">
                                @if($order->payment_method === 'cod')
                                    <span class="text-xl">💵</span> COD (Thanh toán khi nhận hàng)
                                @else
                                    <span class="text-xl">🏦</span> Chuyển khoản ngân hàng
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs uppercase font-bold mb-1">Trạng thái thanh toán</p>
                            <p class="text-gray-900 font-medium">
                                @if($order->payment_status === 'pending') 
                                    <span class="text-yellow-600">⏳ Chờ thanh toán</span>
                                @elseif($order->payment_status === 'paid') 
                                    <span class="text-green-600">✓ Đã thanh toán</span>
                                @elseif($order->payment_status === 'failed') 
                                    <span class="text-red-600">✕ Thất bại</span>
                                @else 
                                    <span class="text-gray-600">Hoàn tiền</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Order Items --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900">Sản phẩm</h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                            <div class="p-6 flex gap-6 hover:bg-gray-50 transition-colors group">
                                <div class="w-20 h-20 bg-gray-50 rounded-lg border border-gray-100 flex-shrink-0 overflow-hidden p-1">
                                    @if($item->product && $item->product->images->first())
                                        <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 text-sm mb-1">
                                        @if($item->product)
                                            <a href="{{ route('products.show', $item->product) }}" class="hover:text-blue-600 transition-colors">
                                                {{ $item->product->name }}
                                            </a>
                                        @else
                                            Sản phẩm không tồn tại
                                        @endif
                                    </h3>
                                    <p class="text-gray-500 text-xs mb-2">SKU: {{ $item->product->sku ?? 'N/A' }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600 text-sm">{{ number_format($item->price, 0, ',', '.') }}₫ x {{ $item->qty }}</span>
                                        <span class="text-blue-600 font-bold">{{ number_format($item->price * $item->qty, 0, ',', '.') }}₫</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Shipping Address --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Địa chỉ giao hàng</h2>
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <p class="font-bold text-gray-900 text-lg">{{ $order->shipping_name }}</p>
                        <p class="text-sm text-gray-500 mt-1 font-medium">{{ $order->shipping_phone }}</p>
                        <p class="text-sm text-gray-600 mt-2 leading-relaxed">
                             {{ $order->shipping_address }}, {{ $order->shipping_city }}
                        </p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-wrap gap-4">
                    <form method="POST" action="{{ route('orders.reorder', $order) }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-6 py-3.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all font-bold shadow-lg hover:shadow-blue-500/30 transform hover:-translate-y-0.5 text-sm">
                             Đặt lại đơn hàng này
                        </button>
                    </form>
                    @if(in_array($order->status, ['pending', 'paid']))
                        <form method="POST" action="{{ route('orders.cancel', $order) }}" 
                              onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')"
                              class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3.5 border-2 border-red-100 text-red-600 rounded-xl hover:bg-red-50 hover:border-red-200 transition-all font-bold text-sm">
                                 Hủy đơn hàng
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Order Timeline --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h3 class="font-bold text-gray-900 text-lg mb-6">Lịch sử đơn hàng</h3>
                    
                    @php
                        $timeline = [
                            ['status' => 'pending', 'label' => 'Đơn hàng đã đặt', 'icon' => '📝', 'active' => true],
                            ['status' => 'paid', 'label' => 'Đã thanh toán', 'icon' => '💳', 'active' => in_array($order->status, ['paid', 'picking', 'shipped', 'delivered'])],
                            ['status' => 'picking', 'label' => 'Đang lấy hàng', 'icon' => '📦', 'active' => in_array($order->status, ['picking', 'shipped', 'delivered'])],
                            ['status' => 'shipped', 'label' => 'Đang giao hàng', 'icon' => '🚚', 'active' => in_array($order->status, ['shipped', 'delivered'])],
                            ['status' => 'delivered', 'label' => 'Đã giao hàng', 'icon' => '✅', 'active' => $order->status === 'delivered'],
                        ];

                        if ($order->status === 'cancelled') {
                            $timeline = [
                                ['status' => 'pending', 'label' => 'Đơn hàng đã đặt', 'icon' => '📝', 'active' => true],
                                ['status' => 'cancelled', 'label' => 'Đã hủy', 'icon' => '❌', 'active' => true],
                            ];
                        } elseif ($order->status === 'refunded') {
                            $timeline[] = ['status' => 'refunded', 'label' => 'Đã hoàn tiền', 'icon' => '💸', 'active' => true];
                        }
                    @endphp

                    <div class="relative pl-2">
                        @foreach($timeline as $index => $step)
                            <div class="flex items-start gap-4 {{ !$loop->last ? 'pb-8' : '' }}">
                                {{-- Timeline line --}}
                                @if(!$loop->last)
                                    <div class="absolute left-[1.15rem] top-8 w-0.5 h-full {{ $step['active'] ? 'bg-blue-200' : 'bg-gray-100' }}"></div>
                                @endif

                                {{-- Icon --}}
                                <div class="relative z-10 w-10 h-10 flex items-center justify-center text-lg rounded-full border-2 {{ $step['active'] ? 'bg-blue-50 border-blue-200 text-blue-600' : 'bg-gray-50 border-gray-100 text-gray-400' }}">
                                    {{ $step['icon'] }}
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 pt-2">
                                    <p class="font-bold text-sm {{ $step['active'] ? 'text-gray-900' : 'text-gray-400' }}">
                                        {{ $step['label'] }}
                                    </p>
                                    @if($step['status'] === $order->status)
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $order->updated_at->format('d/m/Y H:i') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 text-lg mb-4">Tổng quan</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Tạm tính:</span>
                            <span class="font-medium">{{ number_format($order->total - 30000, 0, ',', '.') }}₫</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Phí vận chuyển:</span>
                            <span class="font-medium">30.000₫</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <div class="flex justify-between items-end">
                            <span class="font-bold text-gray-900 text-lg">Tổng cộng:</span>
                            <span class="text-2xl font-bold text-blue-600">{{ number_format($order->total, 0, ',', '.') }}₫</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
