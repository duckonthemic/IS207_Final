@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center space-x-4 mb-8">
            <a href="{{ route('admin.orders.index') }}" class="text-cyber-text-muted hover:text-cyber-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-black text-cyber-white uppercase tracking-tighter">Order Details</h1>
        </div>

        <!-- Order Header -->
        <div class="bg-cyber-black border border-cyber-border p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left: Order Info -->
                <div>
                    <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">Order Code</p>
                    <h2 class="text-2xl font-black text-cyber-white mb-4 font-mono">{{ $order->order_code }}</h2>

                    <div class="space-y-3">
                        <div>
                            <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">Order Date</p>
                            <p class="text-cyber-white font-mono text-sm">{{ $order->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">Customer</p>
                            <div>
                                <p class="text-cyber-white font-bold uppercase text-sm">{{ $order->user->name }}</p>
                                <p class="text-cyber-text-muted text-xs font-mono">{{ $order->user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary -->
                <div class="bg-cyber-gray border border-cyber-border p-4">
                    <h3 class="text-sm font-bold text-cyber-white mb-4 uppercase tracking-wider">Order Summary</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-cyber-text-muted uppercase text-xs">Subtotal:</span>
                            <span
                                class="text-cyber-white font-mono">{{ number_format($order->items->sum(fn($item) => $item->price * $item->quantity), 0, ',', '.') }}₫</span>
                        </div>
                        @if ($order->total_discount > 0)
                            <div class="flex justify-between">
                                <span class="text-cyber-text-muted uppercase text-xs">Discount:</span>
                                <span
                                    class="text-green-400 font-mono">-{{ number_format($order->total_discount, 0, ',', '.') }}₫</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-cyber-text-muted uppercase text-xs">Shipping:</span>
                            <span class="text-cyber-white font-mono">0₫</span>
                        </div>
                        <div class="border-t border-cyber-border my-2"></div>
                        <div class="flex justify-between text-base font-black">
                            <span class="text-cyber-white uppercase">Total:</span>
                            <span
                                class="text-cyber-white font-mono">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-cyber-black border border-cyber-border overflow-hidden mb-6">
            <div class="p-6 border-b border-cyber-border">
                <h3 class="text-lg font-black text-cyber-white uppercase tracking-wider">Order Items</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-cyber-gray text-cyber-text-muted text-xs uppercase tracking-wider">
                            <th class="px-6 py-3 text-left font-bold">Product</th>
                            <th class="px-6 py-3 text-center font-bold">Quantity</th>
                            <th class="px-6 py-3 text-right font-bold">Price</th>
                            <th class="px-6 py-3 text-right font-bold">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-cyber-border">
                        @foreach ($order->items as $item)
                            <tr class="hover:bg-cyber-gray transition">
                                <td class="px-6 py-4">
                                    <p class="text-cyber-white font-bold text-sm uppercase">{{ $item->product->name }}</p>
                                    <p class="text-cyber-text-muted text-xs font-mono">{{ $item->product->sku }}</p>
                                </td>
                                <td class="px-6 py-4 text-center text-cyber-white font-mono">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-right text-cyber-white font-mono">
                                    {{ number_format($item->price, 0, ',', '.') }}₫</td>
                                <td class="px-6 py-4 text-right font-bold text-cyber-white font-mono">
                                    {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Status Update Form -->
        <form action="{{ route('admin.orders.update', $order) }}" method="POST"
            class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            @csrf
            @method('PATCH')

            <!-- Order Status -->
            <div class="bg-cyber-black border border-cyber-border p-6">
                <h3 class="text-lg font-black text-cyber-white mb-4 uppercase tracking-wider">Update Order Status</h3>
                <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Order
                    Status</label>
                <select name="status"
                    class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition mb-4 font-mono text-sm uppercase">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <!-- Payment Status -->
            <div class="bg-cyber-black border border-cyber-border p-6">
                <h3 class="text-lg font-black text-cyber-white mb-4 uppercase tracking-wider">Update Payment Status</h3>
                <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Payment
                    Status</label>
                <select name="payment_status"
                    class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition mb-4 font-mono text-sm uppercase">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <button type="submit"
                    class="w-full px-6 py-4 bg-cyber-white text-cyber-black rounded-none hover:bg-gray-800 transition font-bold uppercase tracking-widest text-sm">
                    Update Order Status
                </button>
            </div>
        </form>

        <!-- Shipping Address -->
        <div class="bg-cyber-black border border-cyber-border p-6 mb-6">
            <h3 class="text-lg font-black text-cyber-white mb-4 uppercase tracking-wider">Delivery Address</h3>
            <div class="bg-cyber-gray border border-cyber-border p-4 text-cyber-white space-y-2 text-sm font-mono">
                <p class="font-bold uppercase">{{ $order->shipping_name ?? 'N/A' }}</p>
                <p>{{ $order->shipping_address ?? 'N/A' }}</p>
                <p>{{ $order->shipping_city ?? 'N/A' }}</p>
                <p>{{ $order->shipping_phone ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="bg-cyber-black border border-cyber-border p-6">
            <h3 class="text-lg font-black text-cyber-white mb-4 uppercase tracking-wider">Payment Information</h3>
            <div class="bg-cyber-gray border border-cyber-border p-4">
                <p class="text-cyber-white text-sm">
                    <span class="text-cyber-text-muted uppercase text-xs font-bold mr-2">Payment Method:</span>
                    <span class="font-bold uppercase">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                </p>
            </div>
        </div>
    </div>
@endsection