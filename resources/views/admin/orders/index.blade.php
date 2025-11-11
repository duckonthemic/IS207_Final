@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-cyber-accent">Manage Orders</h1>
        <p class="text-cyber-muted mt-2">View and manage customer orders</p>
    </div>

    <!-- Search and Filter -->
    <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg p-6 mb-6 mt-6">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by order code or customer..." class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white placeholder-cyber-muted rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">
                </div>

                <!-- Order Status Filter -->
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Order Status</label>
                    <select name="status" class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- Payment Status Filter -->
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Payment Status</label>
                    <select name="payment_status" class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">
                        <option value="">All Payment Status</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-cyber-accent text-cyber-dark rounded-lg hover:bg-cyan-400 transition font-medium">
                    Search
                </button>
                <a href="{{ route('admin.orders.index') }}" class="px-6 py-2 bg-cyber-darker border border-cyber-accent text-cyber-accent rounded-lg hover:border-cyan-400 transition font-medium">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg overflow-hidden">
        @if ($orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-cyber-dark text-cyber-accent text-sm uppercase tracking-wide border-b border-cyber-accent border-opacity-20">
                        <th class="px-6 py-4 text-left">Order Code</th>
                        <th class="px-6 py-4 text-left">Customer</th>
                        <th class="px-6 py-4 text-right">Total</th>
                        <th class="px-6 py-4 text-center">Payment Status</th>
                        <th class="px-6 py-4 text-center">Order Status</th>
                        <th class="px-6 py-4 text-left">Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-cyber-accent divide-opacity-10">
                    @foreach ($orders as $order)
                    <tr class="hover:bg-cyber-dark hover:bg-opacity-50 transition">
                        <td class="px-6 py-4">
                            <span class="font-mono text-cyber-accent font-semibold">{{ $order->order_code }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-white font-medium">{{ $order->user->name }}</p>
                                <p class="text-cyber-muted text-sm">{{ $order->user->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-white font-semibold">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $paymentColors = [
                                    'pending' => 'bg-yellow-900 text-yellow-200',
                                    'paid' => 'bg-green-900 text-green-200',
                                    'failed' => 'bg-red-900 text-cyber-error',
                                    'refunded' => 'bg-blue-900 text-blue-200',
                                ];
                                $paymentColor = $paymentColors[$order->payment_status] ?? 'bg-gray-700 text-gray-200';
                            @endphp
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $paymentColor }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-900 text-yellow-200',
                                    'processing' => 'bg-blue-900 text-blue-200',
                                    'shipped' => 'bg-cyan-900 text-cyber-accent',
                                    'delivered' => 'bg-green-900 text-green-200',
                                    'cancelled' => 'bg-red-900 text-cyber-error',
                                ];
                                $statusColor = $statusColors[$order->status] ?? 'bg-gray-700 text-gray-200';
                            @endphp
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-left text-cyber-muted text-sm">
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center px-3 py-1 bg-cyber-accent bg-opacity-20 text-cyber-accent rounded hover:bg-opacity-40 transition text-sm font-medium">
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

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-cyber-accent border-opacity-20">
            {{ $orders->links() }}
        </div>
        @else
        <div class="px-6 py-12 text-center">
            <svg class="w-12 h-12 text-cyber-muted mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <p class="text-cyber-muted">No orders found</p>
        </div>
        @endif
    </div>
</div>
@endsection
