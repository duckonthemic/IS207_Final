@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-cyber-dark py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 mb-8 text-sm">
            <a href="{{ route('products.index') }}" class="text-cyber-accent hover:underline">Home</a>
            <span class="text-cyber-muted">/</span>
            <a href="{{ route('orders.index') }}" class="text-cyber-accent hover:underline">My Orders</a>
            <span class="text-cyber-muted">/</span>
            <span class="text-cyber-muted">{{ $order->order_code }}</span>
        </nav>

        <!-- Order Header Card -->
        <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg p-6 mb-6 hover:border-opacity-40 transition">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left: Order Info -->
                <div>
                    <h1 class="text-3xl font-bold text-cyber-accent mb-4">{{ $order->order_code }}</h1>
                    <div class="space-y-3">
                        <div>
                            <p class="text-cyber-muted text-sm">Order Date</p>
                            <p class="text-white">{{ $order->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-cyber-muted text-sm">Order Status</p>
                            <div class="mt-1">
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
                            </div>
                        </div>
                        <div>
                            <p class="text-cyber-muted text-sm">Payment Status</p>
                            <div class="mt-1">
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

        <!-- Items Table -->
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
                                <div class="flex items-center space-x-4">
                                    <div class="h-12 w-12 bg-cyber-accent bg-opacity-10 rounded overflow-hidden">
                                        @if ($item->product->images->first())
                                        <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        @else
                                        <div class="w-full h-full flex items-center justify-center text-cyber-muted">No Image</div>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('products.show', $item->product) }}" class="text-cyber-accent hover:underline font-medium">
                                            {{ $item->product->name }}
                                        </a>
                                        <p class="text-cyber-muted text-sm">SKU: {{ $item->product->sku }}</p>
                                    </div>
                                </div>
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

        <!-- Payment Method -->
        <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-cyber-accent mb-4">Payment Information</h3>
            <div class="bg-cyber-dark bg-opacity-50 rounded-lg p-4">
                <p class="text-white">
                    <span class="text-cyber-muted">Payment Method:</span>
                    <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                </p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('orders.index') }}" class="flex-1 sm:flex-none px-6 py-3 bg-cyber-darker text-cyber-accent border border-cyber-accent rounded-lg hover:bg-cyber-accent hover:text-cyber-dark transition font-medium text-center">
                Back to Orders
            </a>
            @if ($order->status !== 'cancelled')
            <form action="{{ route('orders.cancel', $order) }}" method="POST" class="flex-1 sm:flex-none" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                @csrf
                @method('PATCH')
                <button type="submit" class="w-full px-6 py-3 bg-cyber-error text-white border border-cyber-error rounded-lg hover:bg-red-600 transition font-medium">
                    Cancel Order
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
