@extends('layouts.admin')

@section('title', 'Quản lý đánh giá - PC Parts Store')

@section('content')
<div class="min-h-screen bg-cyber-black p-8">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="mb-8 border-b border-cyber-border pb-6 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-black text-cyber-white uppercase tracking-tighter mb-2">Quản lý đánh giá</h1>
                <p class="text-cyber-text-muted font-mono text-sm">// REVIEWS_MANAGEMENT</p>
            </div>
        </div>

        {{-- Reviews Table --}}
        <div class="bg-cyber-black border border-cyber-border p-6">
            @if($reviews->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-cyber-border">
                                <th class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider py-3 w-16">ID</th>
                                <th class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider py-3 w-48">Sản phẩm</th>
                                <th class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider py-3 w-32">Khách hàng</th>
                                <th class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider py-3 w-24">Rating</th>
                                <th class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider py-3">Nội dung</th>
                                <th class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider py-3 w-32">Trạng thái</th>
                                <th class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider py-3 w-32">Ngày tạo</th>
                                <th class="text-right text-cyber-text-muted text-xs font-bold uppercase tracking-wider py-3 w-32">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cyber-border">
                            @foreach($reviews as $review)
                                <tr class="hover:bg-cyber-gray transition-colors group">
                                    <td class="py-4 text-cyber-text-muted font-mono text-sm">#{{ $review->id }}</td>
                                    <td class="py-4">
                                        <a href="{{ route('products.show', $review->product) }}" target="_blank" class="text-cyber-white hover:text-blue-400 font-bold text-sm line-clamp-2 transition-colors">
                                            {{ $review->product->name }}
                                        </a>
                                    </td>
                                    <td class="py-4">
                                        <div class="text-cyber-text text-sm font-bold">{{ $review->user->name }}</div>
                                        <div class="text-cyber-text-muted text-xs">{{ $review->user->email }}</div>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex text-yellow-400 text-xs">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <p class="text-cyber-text-muted text-sm line-clamp-3 italic">"{{ $review->comment }}"</p>
                                    </td>
                                    <td class="py-4">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'text-yellow-500 border-yellow-500',
                                                'approved' => 'text-green-400 border-green-400',
                                                'rejected' => 'text-red-500 border-red-500',
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Chờ duyệt',
                                                'approved' => 'Đã duyệt',
                                                'rejected' => 'Từ chối',
                                            ];
                                        @endphp
                                        <span class="inline-block px-2 py-1 border text-[10px] font-bold uppercase tracking-wider {{ $statusClasses[$review->status] ?? 'text-gray-400 border-gray-400' }}">
                                            {{ $statusLabels[$review->status] ?? $review->status }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-cyber-text-muted text-xs font-mono">
                                        {{ $review->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($review->status === 'pending')
                                                <form action="{{ route('admin.reviews.update-status', $review) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="p-1 text-green-500 hover:bg-green-500/10 rounded transition-colors" title="Duyệt">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.reviews.update-status', $review) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="p-1 text-red-500 hover:bg-red-500/10 rounded transition-colors" title="Từ chối">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 text-cyber-text-muted hover:text-red-500 hover:bg-red-500/10 rounded transition-colors" title="Xóa">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $reviews->links() }}
                </div>
            @else
                <div class="text-center py-12 text-cyber-text-muted border border-cyber-border border-dashed">
                    <div class="text-4xl mb-4 opacity-20">💬</div>
                    <p class="uppercase tracking-widest text-sm">Chưa có đánh giá nào</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
