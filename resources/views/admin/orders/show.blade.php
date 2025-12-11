@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.orders.index') }}" class="text-cyber-text-muted hover:text-cyber-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-black text-cyber-white uppercase tracking-tighter">Chi tiết đơn hàng</h1>
            </div>
            <div class="flex items-center gap-3">
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-500',
                        'processing' => 'bg-blue-500',
                        'picking' => 'bg-purple-500',
                        'shipped' => 'bg-indigo-500',
                        'delivered' => 'bg-green-500',
                        'cancelled' => 'bg-red-500',
                        'refunded' => 'bg-gray-500',
                    ];
                    $paymentColors = [
                        'pending' => 'bg-yellow-500',
                        'paid' => 'bg-green-500',
                        'failed' => 'bg-red-500',
                        'refunded' => 'bg-gray-500',
                    ];
                @endphp
                <span class="px-3 py-1 {{ $statusColors[$order->status] ?? 'bg-gray-500' }} text-white text-xs font-bold uppercase rounded">
                    {{ $order->status }}
                </span>
                <span class="px-3 py-1 {{ $paymentColors[$order->payment_status] ?? 'bg-gray-500' }} text-white text-xs font-bold uppercase rounded">
                    {{ $order->payment_status }}
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 mb-6 text-sm font-bold uppercase">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 mb-6 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Order Header -->
        <div class="bg-cyber-black border border-cyber-border p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left: Order Info -->
                <div>
                    <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">Mã đơn hàng</p>
                    <h2 class="text-2xl font-black text-cyber-white mb-4 font-mono">{{ $order->order_code }}</h2>

                    <div class="space-y-3">
                        <div>
                            <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">Ngày đặt</p>
                            <p class="text-cyber-white font-mono text-sm">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">Khách hàng</p>
                            <div>
                                <p class="text-cyber-white font-bold uppercase text-sm">{{ $order->user->name }}</p>
                                <p class="text-cyber-text-muted text-xs font-mono">{{ $order->user->email }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">Phương thức thanh toán</p>
                            <p class="text-cyber-white font-bold uppercase text-sm">
                                @switch($order->payment_method)
                                    @case('cod') Thanh toán khi nhận hàng @break
                                    @case('bank_transfer') Chuyển khoản @break
                                    @case('atm') Thẻ ATM/Visa @break
                                    @case('fundiin') Fundiin @break
                                    @case('payoo') Payoo @break
                                    @default {{ $order->payment_method }}
                                @endswitch
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary -->
                <div class="bg-cyber-gray border border-cyber-border p-4">
                    <h3 class="text-sm font-bold text-cyber-white mb-4 uppercase tracking-wider">Tổng đơn hàng</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-cyber-text-muted uppercase text-xs">Tạm tính:</span>
                            <span class="text-cyber-white font-mono">{{ number_format($order->subtotal ?? $order->items->sum(fn($item) => $item->price * $item->qty), 0, ',', '.') }}₫</span>
                        </div>
                        @if(($order->discount ?? 0) > 0)
                            <div class="flex justify-between">
                                <span class="text-cyber-text-muted uppercase text-xs">Giảm giá:</span>
                                <span class="text-green-400 font-mono">-{{ number_format($order->discount, 0, ',', '.') }}₫</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-cyber-text-muted uppercase text-xs">Phí ship:</span>
                            <span class="text-cyber-white font-mono">
                                {{ ($order->shipping_fee ?? 0) > 0 ? number_format($order->shipping_fee, 0, ',', '.') . '₫' : 'Miễn phí' }}
                            </span>
                        </div>
                        <div class="border-t border-cyber-border my-2"></div>
                        <div class="flex justify-between text-base font-black">
                            <span class="text-cyber-white uppercase">Tổng cộng:</span>
                            <span class="text-cyber-white font-mono">{{ number_format($order->total, 0, ',', '.') }}₫</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-cyber-black border border-cyber-border overflow-hidden mb-6">
            <div class="p-6 border-b border-cyber-border">
                <h3 class="text-lg font-black text-cyber-white uppercase tracking-wider">Sản phẩm ({{ $order->items->count() }})</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-cyber-gray text-cyber-text-muted text-xs uppercase tracking-wider">
                            <th class="px-6 py-3 text-left font-bold">Sản phẩm</th>
                            <th class="px-6 py-3 text-center font-bold">SL</th>
                            <th class="px-6 py-3 text-right font-bold">Đơn giá</th>
                            <th class="px-6 py-3 text-right font-bold">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-cyber-border">
                        @foreach ($order->items as $item)
                            <tr class="hover:bg-cyber-gray transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($item->product && $item->product->images->first())
                                            <img src="{{ asset($item->product->images->first()->url) }}" alt="" class="w-12 h-12 object-contain bg-white rounded">
                                        @endif
                                        <div>
                                            <p class="text-cyber-white font-bold text-sm">{{ $item->product->name ?? 'Sản phẩm đã xóa' }}</p>
                                            <p class="text-cyber-text-muted text-xs font-mono">SKU: {{ $item->product->sku ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center text-cyber-white font-mono">{{ $item->qty }}</td>
                                <td class="px-6 py-4 text-right text-cyber-white font-mono">
                                    {{ number_format($item->price, 0, ',', '.') }}₫
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-cyber-white font-mono">
                                    {{ number_format($item->price * $item->qty, 0, ',', '.') }}₫
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Status Update Form -->
        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            @csrf
            @method('PATCH')

            <!-- Order Status -->
            <div class="bg-cyber-black border border-cyber-border p-6">
                <h3 class="text-lg font-black text-cyber-white mb-4 uppercase tracking-wider">Trạng thái đơn hàng</h3>
                <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Trạng thái</label>
                <select name="status"
                    class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition mb-4 font-mono text-sm uppercase">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Chờ xử lý</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>🔄 Đang xử lý</option>
                    <option value="picking" {{ $order->status == 'picking' ? 'selected' : '' }}>📦 Đang lấy hàng</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 Đang giao</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ Đã giao</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Đã hủy</option>
                    <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>💰 Hoàn tiền</option>
                </select>
            </div>

            <!-- Payment Status -->
            <div class="bg-cyber-black border border-cyber-border p-6">
                <h3 class="text-lg font-black text-cyber-white mb-4 uppercase tracking-wider">Trạng thái thanh toán</h3>
                <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Thanh toán</label>
                <select name="payment_status"
                    class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition mb-4 font-mono text-sm uppercase">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>⏳ Chờ thanh toán</option>
                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>✅ Đã thanh toán</option>
                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>❌ Thất bại</option>
                    <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>💰 Đã hoàn tiền</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <button type="submit"
                    class="w-full px-6 py-4 bg-cyber-white text-cyber-black rounded-none hover:bg-gray-200 transition font-bold uppercase tracking-widest text-sm">
                    Cập nhật trạng thái
                </button>
            </div>
        </form>

        <!-- Shipping Address -->
        <div class="bg-cyber-black border border-cyber-border p-6 mb-6">
            <h3 class="text-lg font-black text-cyber-white mb-4 uppercase tracking-wider">Địa chỉ giao hàng</h3>
            <div class="bg-cyber-gray border border-cyber-border p-4 text-cyber-white space-y-2 text-sm font-mono">
                <p class="font-bold uppercase">{{ $order->shipping_name ?? 'N/A' }}</p>
                <p>{{ $order->shipping_phone ?? 'N/A' }}</p>
                <p>{{ $order->shipping_address ?? 'N/A' }}</p>
                <p>{{ $order->shipping_city ?? 'N/A' }}</p>
                @if($order->shipping_method)
                    <p class="text-cyber-text-muted">
                        Phương thức: 
                        @switch($order->shipping_method)
                            @case('standard') Giao hàng tiêu chuẩn @break
                            @case('express') Giao hàng nhanh @break
                            @case('same_day') Giao trong ngày @break
                            @default {{ $order->shipping_method }}
                        @endswitch
                    </p>
                @endif
            </div>
        </div>

        <!-- Promotions Applied -->
        @if($order->promotions && $order->promotions->count() > 0)
        <div class="bg-cyber-black border border-cyber-border p-6 mb-6">
            <h3 class="text-lg font-black text-cyber-white mb-4 uppercase tracking-wider">Mã giảm giá đã áp dụng</h3>
            <div class="space-y-2">
                @foreach($order->promotions as $promo)
                    <div class="bg-cyber-gray border border-cyber-border p-3 flex justify-between items-center">
                        <div>
                            <span class="text-cyber-white font-bold font-mono">{{ $promo->code }}</span>
                            <span class="text-cyber-text-muted text-sm ml-2">{{ $promo->name }}</span>
                        </div>
                        <span class="text-green-400 font-bold font-mono">-{{ number_format($promo->pivot->discount_value, 0, ',', '.') }}₫</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
@endsection