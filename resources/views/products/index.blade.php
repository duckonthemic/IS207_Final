@extends('layouts.app')

@section('title', isset($currentCategory) ? $currentCategory->name : 'Danh Mục Sản Phẩm')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm mb-8 text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Trang chủ</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-medium">
                {{ isset($currentCategory) ? $currentCategory->name : 'Danh Mục Sản Phẩm' }}
            </span>
        </nav>

        {{-- Page Title --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    {{ isset($currentCategory) ? $currentCategory->name : 'Tất Cả Sản Phẩm' }}
                </h1>
                <p class="text-gray-500">
                    Tìm thấy <span class="font-bold text-gray-900">{{ $products->total() }}</span> sản phẩm chất lượng
                </p>
            </div>
            
            {{-- Sort Dropdown (Mobile optimized) --}}
            <div class="flex items-center gap-3 bg-white p-1 rounded-xl border border-gray-200 shadow-sm">
                <span class="text-sm font-medium text-gray-500 pl-3">Sắp xếp:</span>
                <div class="flex">
                    <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}#product-list"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('sort', 'latest') == 'latest' ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                        Mới nhất
                    </a>
                    <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_asc'])) }}#product-list"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('sort') == 'price_asc' ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                        Giá tăng
                    </a>
                    <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_desc'])) }}#product-list"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('sort') == 'price_desc' ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                        Giá giảm
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8" id="product-list">
            {{-- Sidebar Filters --}}
            <aside class="col-span-12 lg:col-span-3 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                        <h2 class="font-bold text-lg text-gray-900">Bộ Lọc</h2>
                        <a href="{{ route('products.index') }}" class="text-xs font-medium text-blue-600 hover:text-blue-700">
                            Xóa tất cả
                        </a>
                    </div>
                    
                    <form method="GET" action="{{ route('products.index') }}#product-list" id="filterForm">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif

                        {{-- Search --}}
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-900 mb-3">Tìm kiếm</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Tên sản phẩm..."
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        @php
                            $mainCategories = [
                                'CPU' => ['cpu'],
                                'VGA' => ['vga'],
                                'RAM' => ['ram'],
                                'SSD' => ['ssd'],
                                'Mainboard' => ['mainboard'],
                                'HDD' => ['hdd'],
                                'Case' => ['case'],
                                'PSU' => ['psu'],
                                'Monitor' => ['monitor'],
                            ];
                        @endphp

                        {{-- Main Categories --}}
                        <div class="mb-8">
                            <h3 class="font-bold text-gray-900 mb-4 text-sm">Danh Mục</h3>
                            <div class="space-y-2">
                                <label class="flex items-center group cursor-pointer">
                                    <input type="radio" name="category" value="" 
                                        {{ !request('category') ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="ml-3 text-sm text-gray-600 group-hover:text-blue-600 transition-colors">Tất cả</span>
                                </label>
                                @foreach($mainCategories as $name => $slugs)
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="radio" name="category" value="{{ $slugs[0] }}" 
                                            {{ in_array(request('category'), $slugs) ? 'checked' : '' }}
                                            onchange="this.form.submit()"
                                            class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <span class="ml-3 text-sm text-gray-600 group-hover:text-blue-600 transition-colors">{{ $name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Subcategories --}}
                        @if(!empty($subcategories) && count($subcategories) > 0)
                            <div class="mb-8 pb-6 border-b border-gray-100">
                                <h3 class="font-bold text-gray-900 mb-4 text-sm">Phân Loại</h3>
                                <div class="space-y-1">
                                    @foreach($subcategories as $sub)
                                        <a href="{{ route('products.index', array_merge(request()->except('category'), ['category' => $sub['slug']])) }}" 
                                           class="flex items-center justify-between px-3 py-2 rounded-lg transition-colors {{ request('category') == $sub['slug'] ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                            <span class="text-sm">{{ $sub['name'] }}</span>
                                            <span class="text-xs bg-white px-2 py-0.5 rounded-full border border-gray-100 text-gray-400">{{ $sub['count'] }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Dynamic Filters --}}
                        @if(!empty($filterOptions) && count($filterOptions) > 0)
                            @foreach($filterOptions as $code => $option)
                                <div class="mb-8 pb-6 border-b border-gray-100 last:border-0 last:pb-0 last:mb-0" x-data="{ expanded: true }">
                                    <button type="button" @click="expanded = !expanded" class="flex items-center justify-between w-full mb-4 group">
                                        <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                                            {{ $option['name'] }}
                                            @if($option['unit'])
                                                <span class="text-xs text-gray-400 font-normal">({{ $option['unit'] }})</span>
                                            @endif
                                        </h3>
                                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform duration-200" :class="{'rotate-180': !expanded}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    
                                    <div x-show="expanded" x-collapse class="space-y-2 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                                        @foreach($option['values'] as $item)
                                            @if(!empty(trim($item['value'])))
                                                <label class="flex items-center justify-between group cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition-colors -mx-2">
                                                    <div class="flex items-center">
                                                        <div class="relative flex items-center">
                                                            <input type="checkbox" 
                                                                   name="{{ $code }}[]" 
                                                                   value="{{ $item['value'] }}"
                                                                   {{ in_array($item['value'], (array)request($code, [])) ? 'checked' : '' }}
                                                                   class="peer w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 transition-all">
                                                        </div>
                                                        <span class="ml-3 text-sm text-gray-600 group-hover:text-gray-900 transition-colors font-medium">{{ $item['value'] }}</span>
                                                    </div>
                                                    <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full group-hover:bg-white group-hover:shadow-sm transition-all">{{ $item['count'] }}</span>
                                                </label>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        {{-- Price Range --}}
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <h3 class="font-bold text-gray-900 mb-4 text-sm">Khoảng Giá</h3>
                            
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <div>
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white font-bold py-3 rounded-xl transition-all shadow-lg hover:shadow-xl text-sm">
                                Áp Dụng Bộ Lọc
                            </button>
                        </div>
                    </form>
                </div>
            </aside>

            {{-- Main Content --}}
            <main class="col-span-12 lg:col-span-9">
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-12 flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Không tìm thấy sản phẩm</h3>
                        <p class="text-gray-500 mb-8 max-w-md mx-auto">Rất tiếc, chúng tôi không tìm thấy sản phẩm nào phù hợp với bộ lọc của bạn.</p>
                        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10 shadow-lg hover:shadow-xl transition-all">
                            Xóa bộ lọc & Xem tất cả
                        </a>
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection

