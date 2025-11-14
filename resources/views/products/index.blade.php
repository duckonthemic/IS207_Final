@extends('layouts.app')

@section('title', isset($category) ? $category->name : 'Danh Mục Sản Phẩm')

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
                {{ isset($category) ? $category->name : 'Danh Mục Sản Phẩm' }}
            </span>
        </nav>

        {{-- Page Title --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                {{ isset($category) ? $category->name : 'Danh Mục Sản Phẩm' }}
            </h1>
            <p class="text-gray-600">{{ $products->total() }} sản phẩm</p>
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
                                'CPU' => ['cpu-processor'],
                                'VGA' => ['vga-card-man-hinh'],
                                'RAM' => ['ram-bo-nho'],
                                'SSD' => ['ssd-o-cung'],
                                'Mainboard' => ['mainboard-mainboard'],
                                'Case' => ['case-vo-may'],
                                'PSU' => ['psu-nguon'],
                                'Cooler' => ['fan-cooler-quat-tan-nhiet'],
                                'Monitor' => ['monitor-man-hinh'],
                            ];
                        @endphp

                        {{-- Main Categories (No duplicates) --}}
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

                        {{-- Dynamic Filters Based on Category --}}
                        @if($currentCategory && in_array($currentCategory->slug, ['cpu-processor']))
                            {{-- CPU Filters --}}
                            <div class="mb-6">
                                <h3 class="font-semibold text-gray-900 mb-3">Hãng sản xuất</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="brand[]" value="Intel" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">Intel</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="brand[]" value="AMD" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">AMD</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h3 class="font-semibold text-gray-900 mb-3">Socket</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="socket[]" value="LGA1700" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">LGA 1700</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="socket[]" value="AM5" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">AM5</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="socket[]" value="AM4" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">AM4</span>
                                    </label>
                                </div>
                            </div>
                        @elseif($currentCategory && in_array($currentCategory->slug, ['vga-card-man-hinh']))
                            {{-- VGA Filters --}}
                            <div class="mb-6">
                                <h3 class="font-semibold text-gray-900 mb-3">Hãng sản xuất</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="brand[]" value="ASUS" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">ASUS</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="brand[]" value="MSI" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">MSI</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="brand[]" value="Gigabyte" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">Gigabyte</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h3 class="font-semibold text-gray-900 mb-3">Series GPU</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="series[]" value="RTX 5090" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">RTX 5090</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="series[]" value="RTX 5080" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">RTX 5080</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="series[]" value="RTX 5070" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">RTX 5070</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h3 class="font-semibold text-gray-900 mb-3">Dung lượng VRAM</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="vram[]" value="8GB" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">8GB</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="vram[]" value="12GB" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">12GB</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="vram[]" value="16GB" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">16GB</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="vram[]" value="24GB" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">24GB</span>
                                    </label>
                                </div>
                            </div>
                        @elseif($currentCategory && in_array($currentCategory->slug, ['monitor-man-hinh']))
                            {{-- Monitor Filters --}}
                            <div class="mb-6">
                                <h3 class="font-semibold text-gray-900 mb-3">Hãng sản xuất</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="brand[]" value="LG" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">LG</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="brand[]" value="Samsung" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">Samsung</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="brand[]" value="ASUS" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">ASUS</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h3 class="font-semibold text-gray-900 mb-3">Kích thước</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="size[]" value='24"' class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">24"</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="size[]" value='27"' class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">27"</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="size[]" value='32"' class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">32"</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h3 class="font-semibold text-gray-900 mb-3">Độ phân giải</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="resolution[]" value="Full HD" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">Full HD 1080p</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="resolution[]" value="2K" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">2K 1440p</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="resolution[]" value="4K" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">4K UHD</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h3 class="font-semibold text-gray-900 mb-3">Tần số quét</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="refresh[]" value="60Hz" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">60Hz</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="refresh[]" value="144Hz" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">144Hz</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="refresh[]" value="240Hz" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">240Hz</span>
                                    </label>
                                </div>
                            </div>
                        @elseif($currentCategory && in_array($currentCategory->slug, ['ram-bo-nho']))
                            {{-- RAM Filters --}}
                            <div class="mb-6">
                                <h3 class="font-semibold text-gray-900 mb-3">Kiểu bộ nhớ</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="type[]" value="DDR4" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">DDR4</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="type[]" value="DDR5" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">DDR5</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h3 class="font-semibold text-gray-900 mb-3">Dung lượng</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="capacity[]" value="8GB" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">8GB</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="capacity[]" value="16GB" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">16GB</span>
                                    </label>
                                    <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                        <input type="checkbox" name="capacity[]" value="32GB" class="w-4 h-4 text-blue-600">
                                        <span class="ml-2 text-sm">32GB</span>
                                    </label>
                                </div>
                            </div>
                        @endif

                        {{-- Price Range (Common for all) --}}
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-3">Khoảng Giá (VNĐ)</h3>
                            <div class="space-y-2">
                                <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                    <input type="radio" name="price_range" value="" 
                                        {{ !request('price_range') ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm">Tất cả</span>
                                </label>
                                <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                    <input type="radio" name="price_range" value="0-3000000" 
                                        {{ request('price_range') == '0-3000000' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm">Dưới 3 triệu</span>
                                </label>
                                <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                    <input type="radio" name="price_range" value="3000000-8000000" 
                                        {{ request('price_range') == '3000000-8000000' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm">3 triệu - 8 triệu</span>
                                </label>
                                <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                    <input type="radio" name="price_range" value="8000000-20000000" 
                                        {{ request('price_range') == '8000000-20000000' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm">8 triệu - 20 triệu</span>
                                </label>
                                <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                                    <input type="radio" name="price_range" value="20000000-999999999" 
                                        {{ request('price_range') == '20000000-999999999' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm">Trên 20 triệu</span>
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
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
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
                @endif
            </main>
        </div>
    </div>
</div>
@endsection
