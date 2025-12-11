@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-black text-cyber-white uppercase tracking-tighter">Manage Orders</h1>
            <p class="text-cyber-text-muted font-mono text-sm mt-1">// ORDER_MANAGEMENT_SYSTEM</p>
        </div>

        <!-- Search and Filter -->
        <div class="bg-cyber-black border border-cyber-border p-6 mb-6">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Search
                            Order Code</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ORD-XXXXXXXX-XXXXXX"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm">
                    </div>

                    <!-- Order Status Filter -->
                    <div>
                        <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Order
                            Status</label>
                        <select name="status"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm uppercase">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing
                            </option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>

                    <!-- Payment Status Filter -->
                    <div>
                        <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Payment
                            Status</label>
                        <select name="payment_status"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm uppercase">
                            <option value="">All Payment Status</option>
                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed
                            </option>
                            <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Date Range Filter -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">From
                            Date</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm">
                    </div>
                    <div>
                        <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">To
                            Date</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm">
                    </div>
                    <div class="flex items-end gap-2 lg:col-span-2">
                        <button type="submit"
                            class="px-6 py-2 bg-cyber-white text-cyber-black rounded-none hover:bg-gray-300 transition font-bold uppercase tracking-wider text-sm">
                            Filter
                        </button>
                        <a href="{{ route('admin.orders.index') }}"
                            class="px-6 py-2 bg-transparent border border-cyber-white text-cyber-white rounded-none hover:bg-cyber-white hover:text-cyber-black transition font-bold uppercase tracking-wider text-sm">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-cyber-black border border-cyber-border overflow-hidden">
            @if ($orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr
                                class="bg-cyber-gray text-cyber-text-muted text-xs uppercase tracking-wider border-b border-cyber-border">
                                <th class="px-6 py-4 text-left font-bold">Order Code</th>
                                <th class="px-6 py-4 text-left font-bold">Customer</th>
                                <th class="px-6 py-4 text-right font-bold">Total</th>
                                <th class="px-6 py-4 text-center font-bold">Payment</th>
                                <th class="px-6 py-4 text-center font-bold">Status</th>
                                <th class="px-6 py-4 text-left font-bold">Date</th>
                                <th class="px-6 py-4 text-right font-bold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cyber-border">
                            @foreach ($orders as $order)
                                <tr class="hover:bg-cyber-gray transition group">
                                    <td class="px-6 py-4">
                                        <span class="font-mono text-cyber-white font-bold">{{ $order->order_code }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="text-cyber-white font-bold uppercase text-sm">{{ $order->user->name }}</p>
                                            <p class="text-cyber-text-muted text-xs font-mono">{{ $order->user->email }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span
                                            class="text-cyber-white font-mono font-bold">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $paymentColors = [
                                                'pending' => 'bg-yellow-900 text-yellow-200 border-yellow-700',
                                                'paid' => 'bg-green-900 text-green-200 border-green-700',
                                                'failed' => 'bg-red-900 text-red-200 border-red-700',
                                                'refunded' => 'bg-blue-900 text-blue-200 border-blue-700',
                                            ];
                                            $paymentColor = $paymentColors[$order->payment_status] ?? 'bg-gray-800 text-gray-300 border-gray-600';
                                        @endphp
                                        <span
                                            class="inline-block px-2 py-1 border {{ $paymentColor }} text-xs font-bold uppercase tracking-wider">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-900 text-yellow-200 border-yellow-700',
                                                'processing' => 'bg-blue-900 text-blue-200 border-blue-700',
                                                'shipped' => 'bg-cyan-900 text-cyan-200 border-cyan-700',
                                                'delivered' => 'bg-green-900 text-green-200 border-green-700',
                                                'cancelled' => 'bg-red-900 text-red-200 border-red-700',
                                            ];
                                            $statusColor = $statusColors[$order->status] ?? 'bg-gray-800 text-gray-300 border-gray-600';
                                        @endphp
                                        <span
                                            class="inline-block px-2 py-1 border {{ $statusColor }} text-xs font-bold uppercase tracking-wider">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-left text-cyber-text-muted text-xs font-mono">
                                        {{ $order->created_at->format('Y-m-d') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="inline-flex items-center px-3 py-1 border border-cyber-white text-cyber-white hover:bg-cyber-white hover:text-cyber-black transition text-xs font-bold uppercase tracking-wider">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
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
                <div class="px-6 py-4 border-t border-cyber-border bg-cyber-gray">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center border-t border-cyber-border">
                    <div class="text-4xl mb-4 opacity-50">📦</div>
                    <p class="text-cyber-text-muted uppercase tracking-widest text-sm">No orders found</p>
                </div>
            @endif
        </div>
    </div>
@endsection