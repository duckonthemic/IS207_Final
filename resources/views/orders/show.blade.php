@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng - UITech')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-5xl">
        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 mb-8 text-sm">
            <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-gray-900 transition-colors">Đơn hàng của tôi</a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-900 font-medium">{{ $order->order_code }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                {{-- Order Info Card --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">{{ $order->order_code }}</h1>
                            <p class="text-gray-500 text-sm mt-1">{{ $order->placed_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @php
                            $statusConfig = [
                                'pending' => ['text' => 'Chờ xử lý', 'class' => 'bg-yellow-100 text-yellow-700'],
                                'processing' => ['text' => 'Đang xử lý', 'class' => 'bg-blue-100 text-blue-700'],
                                'picking' => ['text' => 'Đang lấy hàng', 'class' => 'bg-purple-100 text-purple-700'],
                                'shipped' => ['text' => 'Đang giao', 'class' => 'bg-cyan-100 text-cyan-700'],
                                'delivered' => ['text' => 'Đã giao', 'class' => 'bg-green-100 text-green-700'],
                                'cancelled' => ['text' => 'Đã hủy', 'class' => 'bg-red-100 text-red-700'],
                                'refunded' => ['text' => 'Hoàn tiền', 'class' => 'bg-gray-100 text-gray-600'],
                            ];
                            $config = $statusConfig[$order->status] ?? ['text' => $order->status, 'class' => 'bg-gray-100 text-gray-600'];
                        @endphp
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $config['class'] }}">
                            {{ $config['text'] }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-6 text-sm">
                        <div>
                            <p class="text-gray-400 text-xs uppercase tracking-wide mb-1">Thanh toán</p>
                            <p class="text-gray-900 font-medium">
                                @switch($order->payment_method)
                                    @case('cod') COD @break
                                    @case('bank_transfer') Chuyển khoản @break
                                    @case('atm') Thẻ ATM/Visa @break
                                    @case('fundiin') Fundiin @break
                                    @case('payoo') Payoo @break
                                    @default {{ $order->payment_method }}
                                @endswitch
                                <span class="ml-2 {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                    ({{ $order->payment_status === 'paid' ? 'Đã TT' : 'Chờ TT' }})
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs uppercase tracking-wide mb-1">Vận chuyển</p>
                            <p class="text-gray-900 font-medium">
                                @switch($order->shipping_method ?? 'standard')
                                    @case('standard') Tiêu chuẩn @break
                                    @case('express') Nhanh @break
                                    @case('same_day') Trong ngày @break
                                    @default Tiêu chuẩn
                                @endswitch
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Order Items --}}
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <h2 class="font-bold text-gray-900">Sản phẩm ({{ $order->items->count() }})</h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                            <div class="p-5 flex gap-4 hover:bg-gray-50 transition-colors">
                                <div class="w-16 h-16 bg-gray-50 rounded-lg border border-gray-100 flex-shrink-0 overflow-hidden p-1">
                                    @if($item->product && $item->product->images->first())
                                        <img src="{{ asset($item->product->images->first()->url) }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-gray-900 text-sm truncate">
                                        @if($item->product)
                                            <a href="{{ route('products.show', $item->product) }}" class="hover:text-blue-600 transition-colors">
                                                {{ $item->product->name }}
                                            </a>
                                        @else
                                            Sản phẩm không tồn tại
                                        @endif
                                    </h3>
                                    <p class="text-gray-400 text-xs mt-1">{{ number_format($item->price, 0, ',', '.') }}₫ × {{ $item->qty }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold text-gray-900">{{ number_format($item->price * $item->qty, 0, ',', '.') }}₫</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Shipping Address --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h2 class="font-bold text-gray-900 mb-4">Địa chỉ giao hàng</h2>
                    <div class="text-sm space-y-1">
                        <p class="font-medium text-gray-900">{{ $order->shipping_name }}</p>
                        <p class="text-gray-500">{{ $order->shipping_phone }}</p>
                        <p class="text-gray-500">{{ $order->shipping_address }}, {{ $order->shipping_city }}</p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex gap-4">
                    <form method="POST" action="{{ route('orders.reorder', $order) }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-6 py-3 bg-gray-900 text-white rounded-xl hover:bg-gray-800 transition-all font-medium text-sm">
                            Đặt lại đơn hàng
                        </button>
                    </form>
                    @if(in_array($order->status, ['pending', 'processing']))
                        <form method="POST" action="{{ route('orders.cancel', $order) }}" 
                              onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')"
                              class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all font-medium text-sm">
                                Hủy đơn
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Order Timeline - Clean Node Style --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-900 mb-6">Trạng thái đơn hàng</h3>
                    
                    @php
                        $steps = [
                            ['key' => 'pending', 'label' => 'Đặt hàng'],
                            ['key' => 'processing', 'label' => 'Xác nhận'],
                            ['key' => 'picking', 'label' => 'Lấy hàng'],
                            ['key' => 'shipped', 'label' => 'Giao hàng'],
                            ['key' => 'delivered', 'label' => 'Hoàn thành'],
                        ];

                        $statusOrder = ['pending' => 0, 'processing' => 1, 'picking' => 2, 'shipped' => 3, 'delivered' => 4];
                        $currentIndex = $statusOrder[$order->status] ?? 0;

                        if ($order->status === 'cancelled') {
                            $steps = [
                                ['key' => 'pending', 'label' => 'Đặt hàng'],
                                ['key' => 'cancelled', 'label' => 'Đã hủy'],
                            ];
                            $currentIndex = 1;
                        } elseif ($order->status === 'refunded') {
                            $steps[] = ['key' => 'refunded', 'label' => 'Hoàn tiền'];
                            $currentIndex = 5;
                        }
                    @endphp

                    <div class="space-y-0">
                        @foreach($steps as $index => $step)
                            @php
                                $isActive = $index <= $currentIndex;
                                $isCurrent = $step['key'] === $order->status;
                            @endphp
                            <div class="flex items-start gap-3">
                                {{-- Node --}}
                                <div class="flex flex-col items-center">
                                    <div class="w-3 h-3 rounded-full border-2 {{ $isActive ? 'bg-gray-900 border-gray-900' : 'bg-white border-gray-300' }}"></div>
                                    @if(!$loop->last)
                                        <div class="w-0.5 h-8 {{ $isActive && $index < $currentIndex ? 'bg-gray-900' : 'bg-gray-200' }}"></div>
                                    @endif
                                </div>
                                
                                {{-- Label --}}
                                <div class="pb-8 {{ $loop->last ? 'pb-0' : '' }}">
                                    <p class="text-sm font-medium {{ $isActive ? 'text-gray-900' : 'text-gray-400' }}">{{ $step['label'] }}</p>
                                    @if($isCurrent)
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Chi tiết thanh toán</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Tạm tính</span>
                            <span>{{ number_format($order->subtotal ?? ($order->total - ($order->shipping_fee ?? 0) + ($order->discount ?? 0)), 0, ',', '.') }}₫</span>
                        </div>
                        
                        @if(($order->discount ?? 0) > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Giảm giá</span>
                                <span>-{{ number_format($order->discount, 0, ',', '.') }}₫</span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between text-gray-600">
                            <span>Phí vận chuyển</span>
                            <span>{{ ($order->shipping_fee ?? 0) > 0 ? number_format($order->shipping_fee, 0, ',', '.') . '₫' : 'Miễn phí' }}</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-900">Tổng cộng</span>
                            <span class="text-xl font-bold text-gray-900">{{ number_format($order->total, 0, ',', '.') }}₫</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
