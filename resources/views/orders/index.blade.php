@extends('layouts.app')

@section('title', 'Đơn hàng của tôi - UITech')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Đơn hàng của tôi</h1>
                <p class="text-gray-500">Quản lý và theo dõi đơn hàng của bạn</p>
            </div>

            {{-- Filters --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <form method="GET" action="{{ route('orders.index') }}" class="flex flex-wrap gap-4 items-end">
                    {{-- Search by order code --}}
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tìm kiếm</label>
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                🔍
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Nhập mã đơn hàng..."
                                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:border-gray-900 focus:ring-2 focus:ring-gray-300 transition-all text-sm">
                        </div>
                    </div>

                    {{-- Status filter --}}
                    <div class="w-48">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Trạng thái</label>
                        <select name="status"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:border-gray-900 focus:ring-2 focus:ring-gray-300 transition-all text-sm appearance-none cursor-pointer">
                            <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Tất cả</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                            <option value="picking" {{ request('status') === 'picking' ? 'selected' : '' }}>Đang lấy hàng
                            </option>
                            <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Đang giao</option>
                            <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Đã giao
                            </option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy
                            </option>
                            <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Hoàn tiền
                            </option>
                        </select>
                    </div>

                    {{-- Filter buttons --}}
                    <div class="flex gap-2">
                        <button type="submit"
                            class="px-6 py-2.5 bg-gray-900 text-white hover:bg-gray-800 transition-all font-bold rounded-xl shadow-lg hover:shadow-gray-900/20 text-sm">
                            Lọc
                        </button>
                        @if(request('search') || request('status'))
                            <a href="{{ route('orders.index') }}"
                                class="px-6 py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all font-bold rounded-xl text-sm">
                                Xóa bộ lọc
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Orders List --}}
            @if($orders->isEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="text-6xl mb-6 opacity-50">📦</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        @if(request('search') || request('status'))
                            Không tìm thấy đơn hàng nào
                        @else
                            Bạn chưa có đơn hàng nào
                        @endif
                    </h3>
                    <p class="text-gray-500 mb-8">Hãy khám phá các sản phẩm tuyệt vời của chúng tôi</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-block px-8 py-3 bg-gray-900 text-white hover:bg-gray-800 transition-all font-bold rounded-xl shadow-lg hover:shadow-gray-900/20">
                        Bắt đầu mua sắm
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                            {{-- Order Header --}}
                            <div
                                class="p-6 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4 bg-gray-50/50">
                                <div class="flex items-center gap-6">
                                    <div>
                                        <p class="text-gray-900 font-bold text-lg">{{ $order->order_code }}</p>
                                        <p class="text-gray-500 text-sm mt-1">{{ $order->placed_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div>
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
                                        <span class="px-3 py-1 border rounded-full text-xs font-bold {{ $config['class'] }}">
                                            {{ $config['text'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-500 text-xs font-bold uppercase mb-1">Tổng tiền</p>
                                    <p class="text-gray-900 font-bold text-xl">{{ number_format($order->total, 0, ',', '.') }}₫</p>
                                </div>
                            </div>

                            {{-- Order Items Preview --}}
                            <div class="p-6">
                                <div class="space-y-4 mb-6">
                                    @foreach($order->items->take(3) as $item)
                                        <div class="flex gap-4 items-center group">
                                            <div
                                                class="w-16 h-16 bg-gray-50 rounded-lg border border-gray-100 flex-shrink-0 overflow-hidden p-1">
                                                @if($item->product && $item->product->images->first())
                                                    <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product->name }}"
                                                        class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p
                                                    class="text-gray-900 font-medium truncate text-sm group-hover:text-blue-600 transition-colors">
                                                    {{ $item->product ? $item->product->name : 'Sản phẩm không tồn tại' }}
                                                </p>
                                                <p class="text-gray-500 text-xs mt-1">
                                                    {{ number_format($item->price, 0, ',', '.') }}₫ × {{ $item->qty }}
                                                </p>
                                            </div>
                                            <p class="text-gray-900 font-bold text-sm">
                                                {{ number_format($item->price * $item->qty, 0, ',', '.') }}₫
                                            </p>
                                        </div>
                                    @endforeach
                                    @if($order->items->count() > 3)
                                        <p class="text-gray-500 text-xs text-center border-t border-gray-100 pt-3">
                                            + {{ $order->items->count() - 3 }} sản phẩm khác...
                                        </p>
                                    @endif
                                </div>

                                {{-- Actions --}}
                                <div class="flex flex-wrap gap-3 border-t border-gray-100 pt-4">
                                    <a href="{{ route('orders.show', $order) }}"
                                        class="flex-1 min-w-[150px] px-4 py-2.5 bg-gray-900 text-white hover:bg-gray-800 transition-all font-bold text-center rounded-xl text-sm shadow-lg hover:shadow-gray-500/30">
                                        Xem chi tiết
                                    </a>
                                    <form method="POST" action="{{ route('orders.reorder', $order) }}" class="flex-1 min-w-[150px]">
                                        @csrf
                                        <button type="submit"
                                            class="w-full px-4 py-2.5 border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all font-bold rounded-xl text-sm">
                                            Đặt lại
                                        </button>
                                    </form>
                                    @if(in_array($order->status, ['pending', 'paid']))
                                        <form method="POST" action="{{ route('orders.cancel', $order) }}"
                                            onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')"
                                            class="flex-1 min-w-[150px]">
                                            @csrf
                                            <button type="submit"
                                                class="w-full px-4 py-2.5 border border-red-100 text-red-600 hover:bg-red-50 hover:border-red-200 transition-all font-bold rounded-xl text-sm">
                                                Hủy đơn
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
    </div>
@endsection