@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-cyber-white uppercase tracking-tighter">User Details</h1>
                <p class="text-cyber-text-muted font-mono text-sm mt-1">// USER_ID: {{ $user->id }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}"
                    class="px-4 py-2 bg-yellow-600 text-cyber-black hover:bg-yellow-500 transition font-bold uppercase tracking-wider text-sm">
                    Edit User
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="px-4 py-2 bg-transparent border border-cyber-white text-cyber-white hover:bg-cyber-white hover:text-cyber-black transition font-bold uppercase tracking-wider text-sm">
                    Back to List
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- User Info Card -->
            <div class="lg:col-span-1">
                <div class="bg-cyber-black border border-cyber-border p-6">
                    <div class="text-center mb-6">
                        <div
                            class="w-20 h-20 mx-auto bg-cyber-gray border border-cyber-border flex items-center justify-center text-cyber-white text-3xl font-bold uppercase mb-4">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <h2 class="text-xl font-bold text-cyber-white uppercase">{{ $user->name }}</h2>
                        @php
                            $roleColors = [
                                'admin' => 'bg-red-900 text-red-200 border-red-700',
                                'moderator' => 'bg-yellow-900 text-yellow-200 border-yellow-700',
                                'user' => 'bg-green-900 text-green-200 border-green-700',
                            ];
                            $roleColor = $roleColors[$user->role] ?? 'bg-gray-800 text-gray-300 border-gray-600';
                        @endphp
                        <span
                            class="inline-block px-3 py-1 mt-2 border {{ $roleColor }} text-xs font-bold uppercase tracking-wider">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                    <div class="space-y-4 border-t border-cyber-border pt-4">
                        <div>
                            <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">Email</p>
                            <p class="text-cyber-white font-mono text-sm">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">Phone</p>
                            <p class="text-cyber-white font-mono text-sm">{{ $user->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">Joined</p>
                            <p class="text-cyber-white font-mono text-sm">{{ $user->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">Email Verified
                            </p>
                            <p class="text-cyber-white font-mono text-sm">
                                @if($user->email_verified_at)
                                    <span class="text-green-400">{{ $user->email_verified_at->format('Y-m-d') }}</span>
                                @else
                                    <span class="text-red-400">Not Verified</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Order Statistics -->
                <div class="bg-cyber-black border border-cyber-border p-6 mt-4">
                    <h3 class="text-lg font-bold text-cyber-white uppercase tracking-tighter mb-4">Order Stats</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-cyber-gray border border-cyber-border">
                            <p class="text-2xl font-black text-cyber-white">{{ $orderStats['total'] }}</p>
                            <p class="text-cyber-text-muted text-xs uppercase">Total Orders</p>
                        </div>
                        <div class="text-center p-3 bg-cyber-gray border border-cyber-border">
                            <p class="text-2xl font-black text-green-400">{{ $orderStats['completed'] }}</p>
                            <p class="text-cyber-text-muted text-xs uppercase">Completed</p>
                        </div>
                        <div class="text-center p-3 bg-cyber-gray border border-cyber-border">
                            <p class="text-2xl font-black text-yellow-400">{{ $orderStats['pending'] }}</p>
                            <p class="text-cyber-text-muted text-xs uppercase">Pending</p>
                        </div>
                        <div class="text-center p-3 bg-cyber-gray border border-cyber-border">
                            <p class="text-lg font-black text-cyan-400">
                                {{ number_format($orderStats['total_spent'], 0, ',', '.') }}₫</p>
                            <p class="text-cyber-text-muted text-xs uppercase">Total Spent</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Addresses -->
                <div class="bg-cyber-black border border-cyber-border p-6">
                    <h3 class="text-lg font-bold text-cyber-white uppercase tracking-tighter mb-4">Addresses</h3>
                    @if($user->addresses->count() > 0)
                        <div class="space-y-3">
                            @foreach($user->addresses as $address)
                                <div
                                    class="p-4 bg-cyber-gray border border-cyber-border {{ $address->is_default ? 'border-green-700' : '' }}">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="text-cyber-white font-bold">{{ $address->recipient_name }}</p>
                                            <p class="text-cyber-text-muted text-sm font-mono">{{ $address->phone }}</p>
                                            <p class="text-cyber-text-muted text-sm mt-1">{{ $address->full_address }}</p>
                                        </div>
                                        @if($address->is_default)
                                            <span
                                                class="px-2 py-1 bg-green-900 text-green-200 border border-green-700 text-xs font-bold uppercase">Default</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-cyber-text-muted text-sm">No addresses found</p>
                    @endif
                </div>

                <!-- Recent Orders -->
                <div class="bg-cyber-black border border-cyber-border p-6">
                    <h3 class="text-lg font-bold text-cyber-white uppercase tracking-tighter mb-4">Recent Orders</h3>
                    @if($user->orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr
                                        class="text-cyber-text-muted text-xs uppercase tracking-wider border-b border-cyber-border">
                                        <th class="px-4 py-2 text-left font-bold">Order Code</th>
                                        <th class="px-4 py-2 text-right font-bold">Total</th>
                                        <th class="px-4 py-2 text-center font-bold">Status</th>
                                        <th class="px-4 py-2 text-left font-bold">Date</th>
                                        <th class="px-4 py-2 text-right font-bold">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-cyber-border">
                                    @foreach($user->orders as $order)
                                        <tr class="hover:bg-cyber-gray transition">
                                            <td class="px-4 py-3">
                                                <span
                                                    class="font-mono text-cyber-white font-bold text-sm">{{ $order->order_code }}</span>
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <span
                                                    class="text-cyber-white font-mono">{{ number_format($order->total, 0, ',', '.') }}₫</span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
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
                                                    class="inline-block px-2 py-1 border {{ $statusColor }} text-xs font-bold uppercase">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-cyber-text-muted text-xs font-mono">
                                                {{ $order->placed_at ? $order->placed_at->format('Y-m-d') : $order->created_at->format('Y-m-d') }}
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <a href="{{ route('admin.orders.show', $order) }}"
                                                    class="text-cyber-white hover:text-cyan-400 text-xs font-bold uppercase">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-cyber-text-muted text-sm">No orders found</p>
                    @endif
                </div>

                <!-- Recent Reviews -->
                <div class="bg-cyber-black border border-cyber-border p-6">
                    <h3 class="text-lg font-bold text-cyber-white uppercase tracking-tighter mb-4">Recent Reviews</h3>
                    @if($user->reviews->count() > 0)
                        <div class="space-y-3">
                            @foreach($user->reviews->take(5) as $review)
                                <div class="p-4 bg-cyber-gray border border-cyber-border">
                                    <div class="flex items-start justify-between mb-2">
                                        <p class="text-cyber-white font-bold text-sm">
                                            {{ $review->product->name ?? 'Product Deleted' }}</p>
                                        <div class="flex items-center gap-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-cyber-text-muted text-sm">{{ Str::limit($review->content, 100) }}</p>
                                    <p class="text-cyber-text-muted text-xs font-mono mt-2">
                                        {{ $review->created_at->format('Y-m-d') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-cyber-text-muted text-sm">No reviews found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection