@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-black text-cyber-white uppercase tracking-tighter">Manage Users</h1>
            <p class="text-cyber-text-muted font-mono text-sm mt-1">// USER_MANAGEMENT_SYSTEM</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-cyber-black border border-cyber-border p-4">
                <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">Total Users</p>
                <p class="text-2xl font-black text-cyber-white">{{ number_format($stats['total']) }}</p>
            </div>
            <div class="bg-cyber-black border border-cyber-border p-4">
                <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">Admins</p>
                <p class="text-2xl font-black text-red-400">{{ number_format($stats['admins']) }}</p>
            </div>
            <div class="bg-cyber-black border border-cyber-border p-4">
                <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">Moderators</p>
                <p class="text-2xl font-black text-yellow-400">{{ number_format($stats['moderators']) }}</p>
            </div>
            <div class="bg-cyber-black border border-cyber-border p-4">
                <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">Customers</p>
                <p class="text-2xl font-black text-green-400">{{ number_format($stats['users']) }}</p>
            </div>
            <div class="bg-cyber-black border border-cyber-border p-4">
                <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-1">New Today</p>
                <p class="text-2xl font-black text-cyan-400">{{ number_format($stats['today']) }}</p>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="bg-cyber-black border border-cyber-border p-6 mb-6">
            <form action="{{ route('admin.users.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <label
                            class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="SEARCH BY NAME, EMAIL, PHONE..."
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm">
                    </div>

                    <!-- Role Filter -->
                    <div>
                        <label
                            class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Role</label>
                        <select name="role"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm uppercase">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="moderator" {{ request('role') == 'moderator' ? 'selected' : '' }}>Moderator
                            </option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="px-6 py-2 bg-cyber-white text-cyber-black rounded-none hover:bg-gray-300 transition font-bold uppercase tracking-wider text-sm">
                        Search
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="px-6 py-2 bg-transparent border border-cyber-white text-cyber-white rounded-none hover:bg-cyber-white hover:text-cyber-black transition font-bold uppercase tracking-wider text-sm">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-900 border border-green-700 text-green-200 px-4 py-3 mb-6 font-mono text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-900 border border-red-700 text-red-200 px-4 py-3 mb-6 font-mono text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Users Table -->
        <div class="bg-cyber-black border border-cyber-border overflow-hidden">
            @if ($users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr
                                class="bg-cyber-gray text-cyber-text-muted text-xs uppercase tracking-wider border-b border-cyber-border">
                                <th class="px-6 py-4 text-left font-bold">ID</th>
                                <th class="px-6 py-4 text-left font-bold">User</th>
                                <th class="px-6 py-4 text-center font-bold">Role</th>
                                <th class="px-6 py-4 text-center font-bold">Orders</th>
                                <th class="px-6 py-4 text-center font-bold">Reviews</th>
                                <th class="px-6 py-4 text-left font-bold">Joined</th>
                                <th class="px-6 py-4 text-right font-bold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cyber-border">
                            @foreach ($users as $user)
                                <tr class="hover:bg-cyber-gray transition group">
                                    <td class="px-6 py-4">
                                        <span class="font-mono text-cyber-text-muted">#{{ $user->id }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-cyber-gray border border-cyber-border flex items-center justify-center text-cyber-white font-bold uppercase">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-cyber-white font-bold text-sm">{{ $user->name }}</p>
                                                <p class="text-cyber-text-muted text-xs font-mono">{{ $user->email }}</p>
                                                @if($user->phone)
                                                    <p class="text-cyber-text-muted text-xs font-mono">{{ $user->phone }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $roleColors = [
                                                'admin' => 'bg-red-900 text-red-200 border-red-700',
                                                'moderator' => 'bg-yellow-900 text-yellow-200 border-yellow-700',
                                                'user' => 'bg-green-900 text-green-200 border-green-700',
                                            ];
                                            $roleColor = $roleColors[$user->role] ?? 'bg-gray-800 text-gray-300 border-gray-600';
                                        @endphp
                                        <span
                                            class="inline-block px-2 py-1 border {{ $roleColor }} text-xs font-bold uppercase tracking-wider">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="font-mono text-cyber-white">{{ $user->orders_count }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="font-mono text-cyber-white">{{ $user->reviews_count }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-left text-cyber-text-muted text-xs font-mono">
                                        {{ $user->created_at->format('Y-m-d') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.users.show', $user) }}"
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
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="inline-flex items-center px-3 py-1 border border-yellow-600 text-yellow-400 hover:bg-yellow-600 hover:text-cyber-black transition text-xs font-bold uppercase tracking-wider">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-cyber-border bg-cyber-gray">
                    {{ $users->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center border-t border-cyber-border">
                    <div class="text-4xl mb-4 opacity-50">👥</div>
                    <p class="text-cyber-text-muted uppercase tracking-widest text-sm">No users found</p>
                </div>
            @endif
        </div>
    </div>
@endsection