@extends('layouts.app')

@section('title', isset($currentCategory) ? $currentCategory->name : 'Danh Mục Sản Phẩm')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-6">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm mb-6">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600">Trang chủ</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-medium">
                {{ isset($currentCategory) ? $currentCategory->name : 'Danh Mục Sản Phẩm' }}
            </span>
        </nav>

        {{-- Page Title --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                {{ isset($currentCategory) ? $currentCategory->name : 'Danh Mục Sản Phẩm' }}
            </h1>
            <p class="text-gray-600" data-product-count>
                Tìm thấy <span class="font-semibold">{{ $products->total() }}</span> sản phẩm
            </p>
        </div>

        <div class="grid grid-cols-12 gap-6">
            {{-- Sidebar Filters --}}
            <aside class="col-span-12 lg:col-span-3">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                    <h2 class="font-bold text-lg mb-4 pb-3 border-b">Bộ Lọc Sản Phẩm</h2>
                    
                    <form method="GET" action="{{ route('products.index') }}" id="filterForm">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif

                        {{-- Search --}}
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tìm kiếm</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Nhập tên sản phẩm..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        @php
                            $currentCategory = null;
                            if(request('category')) {
                                $currentCategory = \App\Models\Category::where('slug', request('category'))->first();
                            }
                            
                            // Group categories by main type
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
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-3">Danh Mục</h3>
                            <div class="space-y-2">
                                <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                    <input type="radio" name="category" value="" 
                                        {{ !request('category') ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm text-gray-700">Tất cả</span>
                                </label>
                                @foreach($mainCategories as $name => $slugs)
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="radio" name="category" value="{{ $slugs[0] }}" 
                                            {{ in_array(request('category'), $slugs) ? 'checked' : '' }}
                                            onchange="this.form.submit()"
                                            class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm text-gray-700">{{ $name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Subcategories (Danh mục con) --}}
                        @if(!empty($subcategories) && count($subcategories) > 0)
                            <div class="mb-6 pb-6 border-b border-gray-200">
                                <h3 class="font-semibold text-gray-900 mb-3">Danh mục con</h3>
                                <div class="space-y-1">
                                    @foreach($subcategories as $sub)
                                        <a href="{{ route('products.index', array_merge(request()->except('category'), ['category' => $sub['slug']])) }}" 
                                           class="flex items-center justify-between px-2 py-1.5 rounded hover:bg-gray-50 {{ request('category') == $sub['slug'] ? 'bg-gray-100 font-medium' : '' }}">
                                            <span class="text-sm text-gray-700 flex items-center">
                                                <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                                {{ $sub['name'] }}
                                            </span>
                                            <span class="text-xs text-gray-500 font-medium">{{ $sub['count'] }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Dynamic Filters Based on Spec Definitions with Product Counts --}}
                        @if(!empty($filterOptions) && count($filterOptions) > 0)
                            @foreach($filterOptions as $code => $option)
                                <div class="mb-6 pb-6 border-b border-gray-200">
                                    <h3 class="font-semibold text-gray-900 mb-3">
                                        {{ $option['name'] }}
                                        @if($option['unit'])
                                            <span class="text-xs text-gray-500 font-normal">({{ $option['unit'] }})</span>
                                        @endif
                                    </h3>
                                    <div class="space-y-1 max-h-60 overflow-y-auto">
                                        @foreach($option['values'] as $item)
                                            @if(!empty(trim($item['value'])))
                                                <label class="flex items-center justify-between px-2 py-1.5 rounded hover:bg-gray-50 cursor-pointer">
                                                    <div class="flex items-center flex-1">
                                                        <input type="checkbox" 
                                                               name="{{ $code }}[]" 
                                                               value="{{ $item['value'] }}"
                                                               {{ in_array($item['value'], (array)request($code, [])) ? 'checked' : '' }}
                                                               class="w-4 h-4 text-blue-600">
                                                        <span class="ml-2 text-sm text-gray-700">{{ $item['value'] }}</span>
                                                    </div>
                                                    <span class="text-xs text-gray-500 font-medium ml-2">{{ $item['count'] }}</span>
                                                </label>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        {{-- Price Range (Common for all) --}}
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <h3 class="font-semibold text-gray-900 mb-3">Khoảng Giá (VNĐ)</h3>
                            
                            {{-- Price inputs --}}
                            <div class="grid grid-cols-2 gap-2 mb-3">
                                <div>
                                    <label class="text-xs text-gray-600 mb-1 block">Từ</label>
                                    <input type="number" 
                                           name="min_price" 
                                           value="{{ request('min_price') }}"
                                           placeholder="0"
                                           class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600 mb-1 block">Đến</label>
                                    <input type="number" 
                                           name="max_price" 
                                           value="{{ request('max_price') }}"
                                           placeholder="100,000,000"
                                           class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            {{-- Quick price range options --}}
                            <div class="space-y-1">
                                <label class="flex items-center px-2 py-1.5 rounded hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="price_range" value="" 
                                        {{ !request('price_range') && !request('min_price') && !request('max_price') ? 'checked' : '' }}
                                        onchange="document.querySelector('input[name=min_price]').value=''; document.querySelector('input[name=max_price]').value=''; this.form.submit();"
                                        class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm text-gray-700">Tất cả</span>
                                </label>
                                <label class="flex items-center px-2 py-1.5 rounded hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="price_range" value="0-3000000" 
                                        {{ request('price_range') == '0-3000000' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm text-gray-700">Dưới 3 triệu</span>
                                </label>
                                <label class="flex items-center px-2 py-1.5 rounded hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="price_range" value="3000000-8000000" 
                                        {{ request('price_range') == '3000000-8000000' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm text-gray-700">3 - 8 triệu</span>
                                </label>
                                <label class="flex items-center px-2 py-1.5 rounded hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="price_range" value="8000000-20000000" 
                                        {{ request('price_range') == '8000000-20000000' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm text-gray-700">8 - 20 triệu</span>
                                </label>
                                <label class="flex items-center px-2 py-1.5 rounded hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="price_range" value="20000000-50000000" 
                                        {{ request('price_range') == '20000000-50000000' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm text-gray-700">20 - 50 triệu</span>
                                </label>
                                <label class="flex items-center px-2 py-1.5 rounded hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="price_range" value="50000000-999999999" 
                                        {{ request('price_range') == '50000000-999999999' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm text-gray-700">Trên 50 triệu</span>
                                </label>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 bg-black hover:bg-gray-800 text-white font-semibold py-2 px-4 rounded-lg">
                                Áp dụng
                            </button>
                            <a href="{{ route('products.index') }}" 
                               class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg">
                                Xóa lọc
                            </a>
                        </div>
                    </form>
                </div>
            </aside>

            {{-- Main Content --}}
            <main class="col-span-12 lg:col-span-9">
                {{-- Sort Bar --}}
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6 flex items-center justify-between">
                    <span class="text-gray-700 font-medium">Sắp xếp theo:</span>
                    <div class="flex gap-2">
                        <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}"
                           class="px-4 py-2 rounded-lg {{ request('sort', 'latest') == 'latest' ? 'bg-black text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Mới nhất
                        </a>
                        <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_asc'])) }}"
                           class="px-4 py-2 rounded-lg {{ request('sort') == 'price_asc' ? 'bg-black text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Giá tăng dần
                        </a>
                        <a href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_desc'])) }}"
                           class="px-4 py-2 rounded-lg {{ request('sort') == 'price_desc' ? 'bg-black text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Giá giảm dần
                        </a>
                    </div>
                </div>

                {{-- Product Grid --}}
                <div data-product-grid>
                @if($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($products as $product)
                            <div class="bg-white rounded-lg shadow-sm hover:shadow-lg transition-all duration-300 group overflow-hidden">
                                <a href="{{ route('products.show', $product) }}" class="block">
                                    {{-- Image --}}
                                    <div class="relative overflow-hidden bg-gray-100">
                                        <div class="aspect-square relative">
                                            <img src="{{ $product->images->first()?->url ?? 'https://via.placeholder.com/300' }}" 
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-full object-contain p-4 group-hover:scale-110 transition-transform duration-300">
                                        </div>
                                        
                                        {{-- Badges --}}
                                        <div class="absolute top-2 left-2 flex flex-col gap-1">
                                            @if($product->sale_price)
                                                <span class="bg-black text-white text-xs font-bold px-2 py-1 rounded">
                                                    -{{ number_format((($product->price - $product->sale_price) / $product->price) * 100, 0) }}%
                                                </span>
                                            @endif
                                            @if($product->is_featured)
                                                <span class="bg-gray-800 text-white text-xs font-bold px-2 py-1 rounded">
                                                    HOT
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Quick View Overlay --}}
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all flex items-center justify-center">
                                            <span class="text-white opacity-0 group-hover:opacity-100 transition-opacity font-semibold bg-black px-4 py-2 rounded-lg">
                                                Xem chi tiết
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Content --}}
                                    <div class="p-4">
                                        {{-- Category Badge --}}
                                        <div class="mb-2">
                                            <span class="inline-block bg-gray-100 text-gray-800 text-xs font-medium px-2 py-1 rounded">
                                                {{ $product->category->name }}
                                            </span>
                                        </div>

                                        {{-- Name --}}
                                        <h3 class="font-semibold text-gray-900 text-sm line-clamp-2 mb-2 min-h-[40px]">
                                            {{ $product->name }}
                                        </h3>

                                        {{-- Rating --}}
                                        <div class="flex items-center gap-1 mb-2">
                                            @if($product->reviews_count > 0)
                                                <div class="flex text-gray-900">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= round($product->average_rating))
                                                            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                            </svg>
                                                        @else
                                                            <svg class="w-3 h-3 fill-current text-gray-300" viewBox="0 0 20 20">
                                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                            </svg>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="text-xs text-gray-500">({{ $product->reviews_count }})</span>
                                            @else
                                                <span class="text-xs text-gray-400">Chưa có đánh giá</span>
                                            @endif
                                        </div>

                                        {{-- Price --}}
                                        <div class="mb-3">
                                            @if($product->sale_price)
                                                <div class="text-gray-400 line-through text-xs">
                                                    {{ number_format($product->price) }}₫
                                                </div>
                                                <div class="text-black font-bold text-lg">
                                                    {{ number_format($product->sale_price) }}₫
                                                </div>
                                            @else
                                                <div class="text-black font-bold text-lg">
                                                    {{ number_format($product->price) }}₫
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Stock Status --}}
                                        <div class="text-xs mb-3">
                                            @if($product->stock > 0)
                                                <span class="text-gray-600 font-medium">✓ Còn hàng</span>
                                            @else
                                                <span class="text-gray-400">Hết hàng</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>

                                {{-- Add to Cart Button --}}
                                <div class="px-4 pb-4">
                                    @auth
                                        <form action="{{ route('cart.add', $product) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" 
                                                {{ $product->stock <= 0 ? 'disabled' : '' }}
                                                class="w-full bg-black hover:bg-gray-800 disabled:bg-gray-300 text-white font-semibold py-2 rounded-lg transition">
                                                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                Thêm vào giỏ
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" 
                                           class="block w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 rounded-lg text-center transition">
                                            Đăng nhập để mua
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8" data-pagination>
                        {{ $products->links() }}
                    </div>
                </div>
                @else
                <div>
                    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Không tìm thấy sản phẩm</h3>
                        <p class="text-gray-600 mb-6">Vui lòng thử lại với bộ lọc khác</p>
                        <a href="{{ route('products.index') }}" class="inline-block bg-black hover:bg-gray-800 text-white font-semibold px-6 py-3 rounded-lg">
                            Xem tất cả sản phẩm
                        </a>
                    </div>
                </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection
