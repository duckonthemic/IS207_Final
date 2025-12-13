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

                {{-- Review Section - Show only for delivered orders --}}
                @if($order->status === 'delivered')
                    @php
                        $userReviews = Auth::user()->reviews()->whereIn('product_id', $order->items->pluck('product_id'))->pluck('product_id')->toArray();
                        $unreviewedItems = $order->items->filter(fn($item) => !in_array($item->product_id, $userReviews) && $item->product);
                    @endphp
                    
                    @if($unreviewedItems->count() > 0)
                        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                            <div class="p-5 border-b border-gray-100 bg-green-50">
                                <h2 class="font-bold text-gray-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                    Đánh giá sản phẩm
                                </h2>
                                <p class="text-sm text-gray-600 mt-1">Đơn hàng đã hoàn thành! Hãy chia sẻ đánh giá của bạn về sản phẩm.</p>
                            </div>
                            
                            <div class="divide-y divide-gray-100">
                                @foreach($unreviewedItems as $item)
                                    <div class="p-5" x-data="{ rating: 0, hoverRating: 0, showForm: false }">
                                        <div class="flex gap-4 items-start">
                                            <div class="w-14 h-14 bg-gray-50 rounded-lg border border-gray-100 flex-shrink-0 overflow-hidden p-1">
                                                @if($item->product->images->first())
                                                    <img src="{{ asset($item->product->images->first()->url) }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain">
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="font-medium text-gray-900 text-sm">{{ $item->product->name }}</h3>
                                                
                                                <button @click="showForm = !showForm" 
                                                        class="mt-2 text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                                                    <span x-text="showForm ? 'Ẩn form' : 'Viết đánh giá'"></span>
                                                    <svg class="w-4 h-4 transition-transform" :class="showForm && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div x-show="showForm" x-collapse class="mt-4">
                                            <form action="{{ route('reviews.store', $item->product) }}" method="POST" class="space-y-4">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                
                                                {{-- Star Rating --}}
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Đánh giá của bạn</label>
                                                    <div class="flex gap-1">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <button type="button" 
                                                                    @click="rating = {{ $i }}"
                                                                    @mouseenter="hoverRating = {{ $i }}"
                                                                    @mouseleave="hoverRating = 0"
                                                                    class="text-2xl focus:outline-none transition-colors"
                                                                    :class="(hoverRating || rating) >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'">
                                                                ★
                                                            </button>
                                                        @endfor
                                                        <input type="hidden" name="rating" :value="rating" required>
                                                    </div>
                                                    <p class="text-xs text-gray-500 mt-1" x-show="rating > 0">
                                                        <span x-text="['', 'Rất tệ', 'Tệ', 'Bình thường', 'Tốt', 'Rất tốt'][rating]"></span>
                                                    </p>
                                                </div>
                                                
                                                {{-- Comment --}}
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nhận xét (tùy chọn)</label>
                                                    <textarea name="comment" rows="3" 
                                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                                              placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..."></textarea>
                                                </div>
                                                
                                                <button type="submit" 
                                                        :disabled="rating === 0"
                                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-sm font-medium transition-colors">
                                                    Gửi đánh giá
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-green-50 border border-green-200 rounded-2xl p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-green-800">Đã đánh giá tất cả sản phẩm</p>
                                    <p class="text-sm text-green-600">Cảm ơn bạn đã chia sẻ đánh giá!</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

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
