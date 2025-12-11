@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-cyber-white uppercase tracking-tighter">Audit Logs</h1>
                <p class="text-cyber-text-muted font-mono text-sm mt-1">// SYSTEM_ACTIVITY_MONITOR</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
            <div class="bg-cyber-black border border-cyber-border p-4">
                <p class="text-cyber-text-muted text-xs uppercase tracking-wider">Total</p>
                <p class="text-2xl font-black text-cyber-white">{{ number_format($stats['total']) }}</p>
            </div>
            <div class="bg-cyber-black border border-cyber-border p-4">
                <p class="text-cyber-text-muted text-xs uppercase tracking-wider">Today</p>
                <p class="text-2xl font-black text-green-400">{{ number_format($stats['today']) }}</p>
            </div>
            <div class="bg-cyber-black border border-cyber-border p-4">
                <p class="text-cyber-text-muted text-xs uppercase tracking-wider">This Week</p>
                <p class="text-2xl font-black text-blue-400">{{ number_format($stats['this_week']) }}</p>
            </div>
            <div class="bg-cyber-black border border-cyber-border p-4">
                <p class="text-cyber-text-muted text-xs uppercase tracking-wider">Creates</p>
                <p class="text-2xl font-black text-green-400">{{ number_format($stats['creates']) }}</p>
            </div>
            <div class="bg-cyber-black border border-cyber-border p-4">
                <p class="text-cyber-text-muted text-xs uppercase tracking-wider">Updates</p>
                <p class="text-2xl font-black text-blue-400">{{ number_format($stats['updates']) }}</p>
            </div>
            <div class="bg-cyber-black border border-cyber-border p-4">
                <p class="text-cyber-text-muted text-xs uppercase tracking-wider">Deletes</p>
                <p class="text-2xl font-black text-red-400">{{ number_format($stats['deletes']) }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-cyber-black border border-cyber-border p-6 mb-6">
            <form action="{{ route('admin.audit-logs.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Search -->
                    <div>
                        <label
                            class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="SEARCH..."
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm">
                    </div>

                    <!-- Action Filter -->
                    <div>
                        <label
                            class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Action</label>
                        <select name="action"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm uppercase">
                            <option value="">All Actions</option>
                            @foreach ($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ $action }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">From
                            Date</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">To
                            Date</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm">
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-cyber-white text-cyber-black rounded-none hover:bg-gray-800 transition font-bold uppercase tracking-wider text-sm">
                            Filter
                        </button>
                        <a href="{{ route('admin.audit-logs.index') }}"
                            class="px-4 py-2 bg-transparent border border-cyber-white text-cyber-white rounded-none hover:bg-cyber-white hover:text-cyber-black transition font-bold uppercase tracking-wider text-sm">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Logs Table -->
        <div class="bg-cyber-black border border-cyber-border overflow-hidden">
            @if ($logs->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr
                                class="bg-cyber-gray text-cyber-text-muted text-xs uppercase tracking-wider border-b border-cyber-border">
                                <th class="px-4 py-3 text-left font-bold w-40">Time</th>
                                <th class="px-4 py-3 text-left font-bold">User</th>
                                <th class="px-4 py-3 text-left font-bold w-32">Action</th>
                                <th class="px-4 py-3 text-left font-bold">Model</th>
                                <th class="px-4 py-3 text-left font-bold">Description</th>
                                <th class="px-4 py-3 text-left font-bold w-32">IP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cyber-border">
                            @foreach ($logs as $log)
                                <tr class="hover:bg-cyber-gray transition">
                                    <td class="px-4 py-3">
                                        <p class="text-cyber-white text-xs font-mono">{{ $log->created_at->format('d/m/Y') }}</p>
                                        <p class="text-cyber-text-muted text-xs font-mono">{{ $log->created_at->format('H:i:s') }}
                                        </p>
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="text-cyber-white text-sm font-bold">{{ $log->user_name ?? 'System' }}</p>
                                        @if($log->user)
                                            <p class="text-cyber-text-muted text-xs">{{ $log->user->email }}</p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $actionColors = [
                                                'create' => 'bg-green-900 text-green-200 border-green-700',
                                                'update' => 'bg-blue-900 text-blue-200 border-blue-700',
                                                'delete' => 'bg-red-900 text-red-200 border-red-700',
                                                'login' => 'bg-purple-900 text-purple-200 border-purple-700',
                                                'logout' => 'bg-gray-800 text-gray-300 border-gray-600',
                                                'order_placed' => 'bg-green-900 text-green-200 border-green-700',
                                                'order_status_changed' => 'bg-yellow-900 text-yellow-200 border-yellow-700',
                                                'payment_status_changed' => 'bg-cyan-900 text-cyan-200 border-cyan-700',
                                            ];
                                            $color = $actionColors[$log->action] ?? 'bg-gray-800 text-gray-300 border-gray-600';
                                        @endphp
                                        <span
                                            class="inline-block {{ $color }} border px-2 py-1 text-xs font-bold uppercase tracking-wider">
                                            {{ $log->action }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($log->model_type)
                                            <p class="text-cyber-text-muted text-xs uppercase">{{ $log->model_display_name }}</p>
                                            <p class="text-cyber-white text-sm font-mono">{{ Str::limit($log->model_name, 30) }}</p>
                                        @else
                                            <span class="text-cyber-text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="text-cyber-text text-sm line-clamp-2">{{ Str::limit($log->description, 80) }}</p>
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="text-cyber-text-muted text-xs font-mono">{{ $log->ip_address ?? '-' }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-cyber-border bg-cyber-gray">
                    {{ $logs->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <div class="text-4xl mb-4 opacity-50">📋</div>
                    <p class="text-cyber-text-muted uppercase tracking-widest text-sm">No audit logs found</p>
                </div>
            @endif
        </div>
    </div>
@endsection