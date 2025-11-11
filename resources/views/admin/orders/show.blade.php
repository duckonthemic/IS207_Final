@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center space-x-4 mb-8">
        <a href="{{ route('admin.orders.index') }}" class="text-cyber-accent hover:text-cyan-300 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-cyber-accent">Order Details</h1>
    </div>

    <!-- Order Header -->
    <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left: Order Info -->
            <div>
                <p class="text-cyber-muted text-sm">Order Code</p>
                <h2 class="text-2xl font-bold text-cyber-accent mb-4">{{ $order->order_code }}</h2>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-cyber-muted text-sm">Order Date</p>
                        <p class="text-white">{{ $order->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-cyber-muted text-sm">Customer</p>
                        <div>
                            <p class="text-white font-semibold">{{ $order->user->name }}</p>
                            <p class="text-cyber-muted text-sm">{{ $order->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Summary -->
            <div class="bg-cyber-dark bg-opacity-50 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-cyber-accent mb-4">Order Summary</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-cyber-muted">Subtotal:</span>
                        <span class="text-white">{{ number_format($order->items->sum(fn($item) => $item->price * $item->quantity), 0, ',', '.') }} VNĐ</span>
                    </div>
                    @if ($order->total_discount > 0)
                    <div class="flex justify-between">
                        <span class="text-cyber-muted">Discount:</span>
                        <span class="text-cyber-success">-{{ number_format($order->total_discount, 0, ',', '.') }} VNĐ</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-cyber-muted">Shipping:</span>
                        <span class="text-white">0 VNĐ</span>
                    </div>
                    <hr class="border-cyber-accent border-opacity-20 my-2" />
                    <div class="flex justify-between text-base font-semibold">
                        <span class="text-cyber-accent">Total:</span>
                        <span class="text-cyber-accent">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg overflow-hidden mb-6">
        <div class="p-6 border-b border-cyber-accent border-opacity-20">
            <h3 class="text-lg font-semibold text-cyber-accent">Order Items</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-cyber-dark text-cyber-accent text-sm uppercase tracking-wide">
                        <th class="px-6 py-3 text-left">Product</th>
                        <th class="px-6 py-3 text-center">Quantity</th>
                        <th class="px-6 py-3 text-right">Price</th>
                        <th class="px-6 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-cyber-accent divide-opacity-10">
                    @foreach ($order->items as $item)
                    <tr class="hover:bg-cyber-dark hover:bg-opacity-50 transition">
                        <td class="px-6 py-4">
                            <p class="text-white font-medium">{{ $item->product->name }}</p>
                            <p class="text-cyber-muted text-sm">{{ $item->product->sku }}</p>
                        </td>
                        <td class="px-6 py-4 text-center text-white">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 text-right text-white">{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                        <td class="px-6 py-4 text-right font-semibold text-cyber-accent">
                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }} VNĐ
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
        <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-cyber-accent mb-4">Update Order Status</h3>
            <label class="block text-cyber-accent text-sm font-medium mb-2">Order Status</label>
            <select name="status" class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition mb-4">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <!-- Payment Status -->
        <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-cyber-accent mb-4">Update Payment Status</h3>
            <label class="block text-cyber-accent text-sm font-medium mb-2">Payment Status</label>
            <select name="payment_status" class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition mb-4">
                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>
        </div>

        <div class="md:col-span-2">
            <button type="submit" class="w-full px-6 py-3 bg-cyber-accent text-cyber-dark rounded-lg hover:bg-cyan-400 transition font-semibold">
                Update Order Status
            </button>
        </div>
    </form>

    <!-- Shipping Address -->
    <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-cyber-accent mb-4">Delivery Address</h3>
        <div class="bg-cyber-dark bg-opacity-50 rounded-lg p-4 text-white space-y-2">
            <p class="font-semibold">{{ $order->orderAddress->full_name }}</p>
            <p>{{ $order->orderAddress->street_address }}</p>
            <p>{{ $order->orderAddress->city }}, {{ $order->orderAddress->province }} {{ $order->orderAddress->postal_code }}</p>
            <p>{{ $order->orderAddress->phone }}</p>
        </div>
    </div>

    <!-- Payment Information -->
    <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-cyber-accent mb-4">Payment Information</h3>
        <div class="bg-cyber-dark bg-opacity-50 rounded-lg p-4">
            <p class="text-white">
                <span class="text-cyber-muted">Payment Method:</span>
                <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
            </p>
        </div>
    </div>
</div>
@endsection
