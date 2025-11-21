@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Quản Lý Đơn Hàng</h1>
        <p class="text-gray-600 mt-2">Xem và quản lý đơn hàng của khách hàng</p>
    </div>

    {{-- Search and Filter --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Search --}}
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Tìm Kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo mã đơn hoặc khách hàng..." class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:border-blue-500 focus:outline-none transition">
                </div>

                {{-- Order Status Filter --}}
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Order Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:border-blue-500 focus:outline-none transition">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                {{-- Payment Status Filter --}}
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Payment Status</label>
                    <select name="payment_status" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:border-blue-500 focus:outline-none transition">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    Tìm Kiếm
                </button>
                <a href="{{ route('admin.orders.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-200 transition font-medium">
                    Xóa Bộ Lọc
                </a>
            </div>
        </form>
    </div>

    {{-- Orders Table --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
        @if ($orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Order Code</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Customer</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-900">Total</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Payment</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Date</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <span class="font-mono font-semibold text-blue-600">{{ $order->order_code }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $order->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-semibold text-gray-900">{{ number_format($order->total, 0, ',', '.') }}₫</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $paymentBadges = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'paid' => 'bg-green-100 text-green-700',
                                    'failed' => 'bg-red-100 text-red-700',
                                    'refunded' => 'bg-blue-100 text-blue-700',
                                ];
                                $paymentBadge = $paymentBadges[$order->payment_status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $paymentBadge }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusBadges = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'processing' => 'bg-blue-100 text-blue-700',
                                    'shipped' => 'bg-cyan-100 text-cyan-700',
                                    'delivered' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                                $statusBadge = $statusBadges[$order->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $statusBadge }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $order->placed_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-sm font-medium" title="View Details">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $orders->links() }}
        </div>
        @else
        <div class="px-6 py-12 text-center">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></p>
            </svg>
            <p class="text-gray-500">No orders found</p>
        </div>
        @endif
    </div>
</div>
@endsection
