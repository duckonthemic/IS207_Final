@extends('layouts.app')

@section('title', 'So sánh sản phẩm - UITech Store')

@section('content')
<div class="bg-gradient-to-b from-gray-50 to-white min-h-screen py-8" x-data="comparePage()">
    <div class="container mx-auto px-4">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">So sánh sản phẩm</h1>
                <p class="text-gray-500 mt-1">So sánh tối đa 4 sản phẩm cùng danh mục để tìm sản phẩm phù hợp nhất</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('products.index') }}" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Thêm sản phẩm
                </a>
                @if($products->count() > 0)
                    <button onclick="window.print()" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        In bảng so sánh
                    </button>
                    <button @click="clearAll()" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 border border-red-200 text-red-600 rounded-xl hover:bg-red-100 transition-colors font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Xóa tất cả
                    </button>
                @endif
            </div>
        </div>

        @if($products->isEmpty())
            {{-- Empty State --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Chưa có sản phẩm để so sánh</h2>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">Thêm sản phẩm vào danh sách so sánh bằng cách click vào biểu tượng so sánh trên các sản phẩm bạn quan tâm.</p>
                <a href="{{ route('products.index') }}" 
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-xl font-bold hover:bg-gray-800 transition-colors shadow-lg hover:shadow-gray-900/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Khám phá sản phẩm
                </a>
            </div>
        @else
            {{-- Comparison Table --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full" style="min-width: {{ 250 + ($products->count() * 280) }}px;">
                        {{-- Product Header --}}
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="p-6 text-left bg-gray-50 border-r border-gray-100 sticky left-0 z-10" style="width: 250px;">
                                    <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">Sản phẩm</span>
                                </th>
                                @foreach($products as $product)
                                    <td class="p-6 text-center border-r border-gray-100 last:border-r-0 align-top" style="width: 280px;">
                                        <div class="relative group">
                                            {{-- Remove Button --}}
                                            <button @click="removeProduct({{ $product->id }})" 
                                                class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg hover:bg-red-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                            
                                            {{-- Product Image --}}
                                            <a href="{{ route('products.show', $product) }}" class="block">
                                                <div class="w-40 h-40 mx-auto mb-4 bg-gray-50 rounded-xl p-4 group-hover:bg-gray-100 transition-colors">
                                                    <img src="{{ $product->image_url ?? asset('images/no-image.png') }}" 
                                                        alt="{{ $product->name }}" 
                                                        class="w-full h-full object-contain">
                                                </div>
                                            </a>
                                            
                                            {{-- Product Info --}}
                                            <a href="{{ route('products.show', $product) }}" 
                                                class="block font-bold text-gray-900 text-lg mb-1 hover:text-blue-600 transition-colors line-clamp-2 min-h-[3.5rem]">
                                                {{ $product->name }}
                                            </a>
                                            
                                            {{-- Category --}}
                                            <span class="text-xs text-gray-500 uppercase tracking-wider">{{ $product->category->name }}</span>
                                            
                                            {{-- Price --}}
                                            <div class="mt-3">
                                                @if($product->sale_price)
                                                    <div class="text-sm text-gray-400 line-through">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                                                    <div class="text-2xl font-bold text-red-600">{{ number_format($product->sale_price, 0, ',', '.') }}₫</div>
                                                @else
                                                    <div class="text-2xl font-bold text-gray-900">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                                                @endif
                                            </div>
                                            
                                            {{-- Stock Status --}}
                                            <div class="mt-2">
                                                @if($product->stock > 0)
                                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                                                        Còn hàng ({{ $product->stock }})
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-red-600 bg-red-50 px-2 py-1 rounded-full">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                                                        Hết hàng
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            {{-- Add to Cart --}}
                                            <div class="mt-4">
                                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" 
                                                        class="w-full bg-gray-900 text-white font-bold py-3 rounded-xl hover:bg-gray-800 transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2"
                                                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                        </svg>
                                                        Thêm vào giỏ
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                @endforeach
                                
                                {{-- Empty Slots --}}
                                @for($i = $products->count(); $i < 4; $i++)
                                    <td class="p-6 text-center border-r border-gray-100 last:border-r-0 bg-gray-50/50" style="width: 280px;">
                                        <div class="flex flex-col items-center justify-center h-full py-8">
                                            <div class="w-20 h-20 border-2 border-dashed border-gray-300 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-gray-400 mb-3">Thêm sản phẩm</p>
                                            <a href="{{ route('products.index') }}" 
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium hover:underline">
                                                Chọn sản phẩm
                                            </a>
                                        </div>
                                    </td>
                                @endfor
                            </tr>
                        </thead>
                        
                        {{-- Specs Comparison --}}
                        <tbody>
                            {{-- Basic Info Section --}}
                            <tr class="bg-gray-900 text-white">
                                <td colspan="{{ 1 + max($products->count(), 4) }}" class="px-6 py-3 font-bold uppercase tracking-wider text-sm">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Thông tin cơ bản
                                    </div>
                                </td>
                            </tr>
                            
                            {{-- Brand --}}
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 font-medium text-gray-700 border-b border-r border-gray-100 bg-gray-50/50 sticky left-0">
                                    Thương hiệu
                                </td>
                                @foreach($products as $product)
                                    <td class="p-4 text-gray-900 border-b border-r border-gray-100 last:border-r-0 text-center font-medium">
                                        {{ $product->brand ?? '-' }}
                                    </td>
                                @endforeach
                                @for($i = $products->count(); $i < 4; $i++)
                                    <td class="p-4 border-b border-r border-gray-100 last:border-r-0 bg-gray-50/50"></td>
                                @endfor
                            </tr>
                            
                            {{-- Warranty --}}
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 font-medium text-gray-700 border-b border-r border-gray-100 bg-gray-50/50 sticky left-0">
                                    Bảo hành
                                </td>
                                @foreach($products as $product)
                                    <td class="p-4 text-gray-900 border-b border-r border-gray-100 last:border-r-0 text-center">
                                        {{ $product->warranty ?? '12 tháng' }}
                                    </td>
                                @endforeach
                                @for($i = $products->count(); $i < 4; $i++)
                                    <td class="p-4 border-b border-r border-gray-100 last:border-r-0 bg-gray-50/50"></td>
                                @endfor
                            </tr>
                            
                            {{-- Technical Specs Section --}}
                            @if($specDefinitions->count() > 0)
                                <tr class="bg-gray-900 text-white">
                                    <td colspan="{{ 1 + max($products->count(), 4) }}" class="px-6 py-3 font-bold uppercase tracking-wider text-sm">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                            </svg>
                                            Thông số kỹ thuật
                                        </div>
                                    </td>
                                </tr>
                                
                                @foreach($specDefinitions as $specDef)
                                    @php
                                        // Get all values for this spec to check for differences
                                        $specValues = $products->map(function($p) use ($specDef) {
                                            $spec = $p->specs->firstWhere('spec_definition_id', $specDef->id);
                                            return $spec ? $spec->value : null;
                                        })->filter()->unique();
                                        $hasDifference = $specValues->count() > 1;
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors {{ $hasDifference ? 'bg-yellow-50/50' : '' }}">
                                        <td class="p-4 font-medium text-gray-700 border-b border-r border-gray-100 bg-gray-50/50 sticky left-0">
                                            <div class="flex items-center gap-2">
                                                {{ $specDef->name }}
                                                @if($specDef->unit)
                                                    <span class="text-xs text-gray-400">({{ $specDef->unit }})</span>
                                                @endif
                                                @if($hasDifference)
                                                    <span class="w-2 h-2 rounded-full bg-yellow-500" title="Có sự khác biệt"></span>
                                                @endif
                                            </div>
                                        </td>
                                        @foreach($products as $product)
                                            @php
                                                $spec = $product->specs->firstWhere('spec_definition_id', $specDef->id);
                                                $value = $spec ? $spec->value : null;
                                            @endphp
                                            <td class="p-4 text-gray-900 border-b border-r border-gray-100 last:border-r-0 text-center {{ $hasDifference ? 'font-medium' : '' }}">
                                                @if($value)
                                                    {{ $value }}{{ $specDef->unit ? ' ' . $specDef->unit : '' }}
                                                @else
                                                    <span class="text-gray-300">-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                        @for($i = $products->count(); $i < 4; $i++)
                                            <td class="p-4 border-b border-r border-gray-100 last:border-r-0 bg-gray-50/50"></td>
                                        @endfor
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Legend --}}
            <div class="mt-6 flex items-center gap-6 text-sm text-gray-500">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                    Thông số có sự khác biệt
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-gray-300">-</span>
                    Không có thông tin
                </div>
            </div>
            
            {{-- Recommendation --}}
            @if($products->count() >= 2)
                <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg mb-1">Gợi ý từ UITech</h3>
                            <p class="text-gray-600">
                                @php
                                    $cheapest = $products->sortBy(function($p) { return $p->sale_price ?? $p->price; })->first();
                                @endphp
                                <strong>{{ $cheapest->name }}</strong> có giá tốt nhất trong nhóm so sánh này với giá chỉ 
                                <strong class="text-blue-600">{{ number_format($cheapest->sale_price ?? $cheapest->price, 0, ',', '.') }}₫</strong>.
                                Hãy xem xét các thông số kỹ thuật để chọn sản phẩm phù hợp nhất với nhu cầu của bạn!
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>

<script>
function comparePage() {
    return {
        removeProduct(id) {
            const saved = localStorage.getItem('compareList');
            if (saved) {
                let compareList = JSON.parse(saved);
                compareList = compareList.filter(p => p.id !== id);
                localStorage.setItem('compareList', JSON.stringify(compareList));
                
                // Reload with updated IDs
                if (compareList.length > 0) {
                    window.location.href = '{{ route("products.compare") }}?ids=' + compareList.map(p => p.id).join(',');
                } else {
                    window.location.href = '{{ route("products.compare") }}';
                }
            }
        },
        clearAll() {
            if (confirm('Bạn có chắc muốn xóa tất cả sản phẩm khỏi danh sách so sánh?')) {
                localStorage.removeItem('compareList');
                window.location.href = '{{ route("products.compare") }}';
            }
        }
    }
}
</script>

@push('styles')
<style>
@media print {
    header, footer, nav, .no-print { display: none !important; }
    .bg-gray-900 { background-color: #1a1a1a !important; -webkit-print-color-adjust: exact; }
    .text-white { color: white !important; }
}
</style>
@endpush
@endsection
