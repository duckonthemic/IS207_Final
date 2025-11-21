@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto px-4">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-700 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Chi tiết đơn hàng</h1>
            <p class="text-gray-600 mt-1">{{ $order->order_code }}</p>
        </div>
    </div>

    {{-- Order Header --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- Left: Order Info --}}
        <div class="lg:col-span-2 bg-white rounded-lg shadow border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">{{ $order->order_code }}</h2>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Ngày đặt hàng</p>
                    <p class="font-semibold text-gray-900">{{ $order->placed_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Trạng thái</p>
                    <p class="font-semibold">
                        @php
                            $statusColors = [
                                'pending' => 'text-yellow-700',
                                'processing' => 'text-blue-700',
                                'shipped' => 'text-cyan-700',
                                'delivered' => 'text-green-700',
                                'cancelled' => 'text-red-700',
                            ];
                        @endphp
                        <span class="{{ $statusColors[$order->status] ?? 'text-gray-700' }}">{{ ucfirst($order->status) }}</span>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Khách hàng</p>
                    <p class="font-semibold text-gray-900">{{ $order->user->name }}</p>
                    <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Trạng thái thanh toán</p>
                    <p class="font-semibold">
                        @php
                            $paymentColors = [
                                'pending' => 'text-yellow-700',
                                'paid' => 'text-green-700',
                                'failed' => 'text-red-700',
                                'refunded' => 'text-blue-700',
                            ];
                        @endphp
                        <span class="{{ $paymentColors[$order->payment_status] ?? 'text-gray-700' }}">{{ ucfirst($order->payment_status) }}</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Right: Summary --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Tóm tắt đơn hàng</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Tạm tính:</span>
                    <span class="font-semibold text-gray-900">{{ number_format($order->total, 0, ',', '.') }}₫</span>
                </div>
                <div class="flex justify-between pt-3 border-t border-gray-200">
                    <span class="font-semibold text-gray-900">Tổng cộng:</span>
                    <span class="text-lg font-bold text-blue-600">{{ number_format($order->total, 0, ',', '.') }}₫</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Order Items --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Sản phẩm trong đơn hàng</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Sản phẩm</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Số lượng</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900">Giá</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($order->items as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                            <p class="text-sm text-gray-600">{{ $item->product->sku }}</p>
                        </td>
                        <td class="px-6 py-4 text-center text-gray-900">{{ $item->qty }}</td>
                        <td class="px-6 py-4 text-right text-gray-900">{{ number_format($item->price, 0, ',', '.') }}₫</td>
                        <td class="px-6 py-4 text-right font-semibold text-gray-900">
                            {{ number_format($item->price * $item->qty, 0, ',', '.') }}₫
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Status Update Form --}}
    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        @csrf

        {{-- Order Status --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Cập nhật trạng thái đơn hàng</h3>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Trạng thái đơn hàng</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:border-blue-500 focus:outline-none transition" required>
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Payment Status --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Cập nhật trạng thái thanh toán</h3>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Trạng thái thanh toán</label>
                <select name="payment_status" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:border-blue-500 focus:outline-none transition" required>
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
                @error('payment_status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="md:col-span-2">
            <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                Cập nhật trạng thái
            </button>
        </div>
    </form>

    {{-- Shipping Address --}}
    @if($order->shipping_address)
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Địa chỉ giao hàng</h3>
        <div class="bg-gray-50 rounded-lg p-4 text-gray-900 space-y-2">
            <p class="font-semibold">{{ $order->shipping_name }}</p>
            <p>{{ $order->shipping_address }}</p>
            <p>{{ $order->shipping_city }}</p>
            <p>{{ $order->shipping_phone }}</p>
        </div>
    </div>
    @endif

    {{-- Payment Information --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Thông tin thanh toán</h3>
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-gray-900">
                <span class="text-gray-600">Phương thức thanh toán:</span>
                <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}</span>
            </p>
        </div>
    </div>
</div>
@endsection
