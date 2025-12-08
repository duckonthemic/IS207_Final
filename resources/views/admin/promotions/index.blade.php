@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-cyber-white uppercase tracking-tighter">Mã Giảm Giá</h1>
                <p class="text-cyber-text-muted font-mono text-sm mt-1">// PROMOTION_MANAGEMENT_SYSTEM</p>
            </div>
            <a href="{{ route('admin.promotions.create') }}"
                class="mt-4 sm:mt-0 inline-flex items-center px-6 py-3 bg-cyber-white text-cyber-black hover:bg-gray-800 transition font-bold uppercase tracking-wider text-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Thêm Mã Giảm Giá
            </a>
        </div>

        <!-- Search -->
        <div class="bg-cyber-black border border-cyber-border p-6 mb-6">
            <form action="{{ route('admin.promotions.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Tìm
                        kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="TÌM THEO MÃ HOẶC TÊN..."
                        class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm">
                </div>
                <div class="w-40">
                    <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Trạng
                        thái</label>
                    <select name="status"
                        class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm">
                        <option value="">Tất cả</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Hết hạn</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Vô hiệu</option>
                    </select>
                </div>
                <div class="flex gap-2 items-end">
                    <button type="submit"
                        class="px-6 py-2 bg-cyber-white text-cyber-black rounded-none hover:bg-gray-800 transition font-bold uppercase tracking-wider text-sm">
                        Tìm
                    </button>
                    <a href="{{ route('admin.promotions.index') }}"
                        class="px-6 py-2 bg-transparent border border-cyber-white text-cyber-white rounded-none hover:bg-cyber-white hover:text-cyber-black transition font-bold uppercase tracking-wider text-sm">
                        Xóa
                    </a>
                </div>
            </form>
        </div>

        <!-- Promotions Table -->
        <div class="bg-cyber-black border border-cyber-border overflow-hidden">
            @if ($promotions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr
                                class="bg-cyber-gray text-cyber-text-muted text-xs uppercase tracking-wider border-b border-cyber-border">
                                <th class="px-6 py-4 text-left font-bold">Mã</th>
                                <th class="px-6 py-4 text-left font-bold">Tên</th>
                                <th class="px-6 py-4 text-center font-bold">Giá trị</th>
                                <th class="px-6 py-4 text-center font-bold">Đã dùng</th>
                                <th class="px-6 py-4 text-center font-bold">Hiệu lực</th>
                                <th class="px-6 py-4 text-center font-bold">Trạng thái</th>
                                <th class="px-6 py-4 text-right font-bold">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cyber-border">
                            @foreach ($promotions as $promotion)
                                <tr class="hover:bg-cyber-gray transition group">
                                    <td class="px-6 py-4">
                                        <span
                                            class="font-mono text-cyber-white font-bold bg-cyber-gray px-2 py-1 border border-cyber-border">{{ $promotion->code }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-cyber-white font-bold text-sm">{{ $promotion->name }}</p>
                                        @if($promotion->description)
                                            <p class="text-cyber-text-muted text-xs font-mono line-clamp-1">
                                                {{ Str::limit($promotion->description, 50) }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-green-400 font-bold font-mono">
                                            {{ $promotion->formatted_value }}
                                        </span>
                                        @if($promotion->min_order_value)
                                            <p class="text-cyber-text-muted text-xs mt-1">Min:
                                                {{ number_format($promotion->min_order_value, 0, ',', '.') }}₫</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="font-mono text-cyber-white">
                                            {{ $promotion->usage_count }}
                                            @if($promotion->usage_limit)
                                                / {{ $promotion->usage_limit }}
                                            @else
                                                / ∞
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-xs font-mono">
                                        @if($promotion->starts_at || $promotion->expires_at)
                                            <p class="text-cyber-text-muted">
                                                {{ $promotion->starts_at ? $promotion->starts_at->format('d/m/Y') : '—' }}
                                            </p>
                                            <p class="text-cyber-white">
                                                → {{ $promotion->expires_at ? $promotion->expires_at->format('d/m/Y') : '∞' }}
                                            </p>
                                        @else
                                            <span class="text-cyber-text-muted">Vĩnh viễn</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $status = $promotion->status;
                                            $statusColors = [
                                                'active' => 'bg-green-900 text-green-200 border-green-700',
                                                'scheduled' => 'bg-blue-900 text-blue-200 border-blue-700',
                                                'expired' => 'bg-red-900 text-red-200 border-red-700',
                                                'exhausted' => 'bg-yellow-900 text-yellow-200 border-yellow-700',
                                                'inactive' => 'bg-gray-800 text-gray-300 border-gray-600',
                                            ];
                                            $statusLabels = [
                                                'active' => 'Hoạt động',
                                                'scheduled' => 'Chờ',
                                                'expired' => 'Hết hạn',
                                                'exhausted' => 'Hết lượt',
                                                'inactive' => 'Vô hiệu',
                                            ];
                                        @endphp
                                        <span
                                            class="inline-block px-2 py-1 border {{ $statusColors[$status] ?? '' }} text-xs font-bold uppercase tracking-wider">
                                            {{ $statusLabels[$status] ?? $status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex gap-2 justify-end">
                                            <a href="{{ route('admin.promotions.edit', $promotion) }}"
                                                class="inline-flex items-center px-3 py-1 border border-cyber-white text-cyber-white hover:bg-cyber-white hover:text-cyber-black transition text-xs font-bold uppercase tracking-wider">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.promotions.toggle-status', $promotion) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 border {{ $promotion->is_active ? 'border-yellow-500 text-yellow-500 hover:bg-yellow-500' : 'border-green-500 text-green-500 hover:bg-green-500' }} hover:text-white transition text-xs font-bold uppercase tracking-wider"
                                                    title="{{ $promotion->is_active ? 'Vô hiệu hóa' : 'Kích hoạt' }}">
                                                    @if($promotion->is_active)
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    @endif
                                                </button>
                                            </form>
                                            @if($promotion->usage_count == 0)
                                                <form action="{{ route('admin.promotions.destroy', $promotion) }}" method="POST"
                                                    class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa mã giảm giá này?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1 border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition text-xs font-bold uppercase tracking-wider">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-cyber-border bg-cyber-gray">
                    {{ $promotions->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center border-t border-cyber-border">
                    <div class="text-4xl mb-4 opacity-50">🏷️</div>
                    <p class="text-cyber-text-muted uppercase tracking-widest text-sm">Chưa có mã giảm giá nào</p>
                    <a href="{{ route('admin.promotions.create') }}"
                        class="mt-4 inline-flex items-center px-6 py-3 bg-cyber-white text-cyber-black hover:bg-gray-800 transition font-bold uppercase tracking-wider text-sm">
                        Tạo mã đầu tiên
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection