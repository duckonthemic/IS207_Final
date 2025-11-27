@extends('layouts.app')

@section('title', $pageTitle ?? 'PC Gaming - Bộ PC Gaming Lắp Sẵn')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 transition-colors">
                        Trang chủ
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="mx-2 text-gray-300">/</span>
                        <span class="text-gray-900 font-bold">{{ $pageTitle ?? 'PC Gaming' }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $pageTitle ?? 'PC Gaming - Bộ PC Gaming Lắp Sẵn' }}</h1>
            <p class="text-gray-500">{{ $pageDescription ?? 'Bộ máy tính gaming được lựa chọn kỹ lưỡng, tối ưu hiệu năng và giá thành' }}</p>
        </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-bold text-gray-700 mb-2">Giá từ (VNĐ)</label>
                <input type="number" name="min_price" value="{{ request('min_price') }}" 
                    placeholder="0" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-bold text-gray-700 mb-2">Giá đến (VNĐ)</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" 
                    placeholder="100000000" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-bold text-gray-700 mb-2">Sắp xếp</label>
                <select name="sort" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm cursor-pointer">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                </select>
            </div>
            <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-500/30 text-sm h-[42px]">
                Lọc
            </button>
            <a href="{{ route('pc-gaming.index') }}" class="px-8 py-2.5 border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-all h-[42px] flex items-center text-sm">
                Xóa lọc
            </a>
        </form>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($builds as $product)
        <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 flex flex-col h-full overflow-hidden">
            <!-- Image -->
            <div class="relative h-64 bg-gray-50 p-4 flex items-center justify-center group-hover:bg-white transition-colors">
                <a href="{{ route('products.show', $product) }}" class="block w-full h-full">
                    <img src="{{ $product->image ?? asset('images/no-image.png') }}" alt="{{ $product->name }}" 
                        class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">
                </a>
                @if($product->sale_price && $product->sale_price < $product->price)
                    <div class="absolute top-3 right-3 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">
                        -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                    </div>
                @endif
            </div>

            <!-- Content -->
            <div class="p-5 flex-1 flex flex-col">
                <!-- Name -->
                <h3 class="font-bold text-gray-900 text-lg mb-4 line-clamp-2 min-h-[56px] group-hover:text-blue-600 transition-colors">
                    <a href="{{ route('products.show', $product) }}">
                        {{ $product->name }}
                    </a>
                </h3>

                <!-- Specs -->
                @php
                    $specs = $product->specs->keyBy(fn($spec) => $spec->specDefinition->code);
                    $cpu = $specs['cpu']->value ?? 'N/A';
                    $gpu = $specs['vga']->value ?? 'N/A';
                    $ram = $specs['ram']->value ?? 'N/A';
                    $storage = $specs['ssd']->value ?? 'N/A';
                @endphp
                <div class="space-y-2 mb-6 text-xs text-gray-500 flex-1">
                    <div class="flex items-center border-b border-gray-100 pb-1">
                        <span class="font-bold w-12 text-gray-700">CPU:</span>
                        <span class="truncate text-gray-600" title="{{ $cpu }}">{{ $cpu }}</span>
                    </div>
                    <div class="flex items-center border-b border-gray-100 pb-1">
                        <span class="font-bold w-12 text-gray-700">VGA:</span>
                        <span class="truncate text-gray-600" title="{{ $gpu }}">{{ $gpu }}</span>
                    </div>
                    <div class="flex items-center border-b border-gray-100 pb-1">
                        <span class="font-bold w-12 text-gray-700">RAM:</span>
                        <span class="text-gray-600" title="{{ $ram }}">{{ $ram }}</span>
                    </div>
                    <div class="flex items-center border-b border-gray-100 pb-1">
                        <span class="font-bold w-12 text-gray-700">SSD:</span>
                        <span class="text-gray-600" title="{{ $storage }}">{{ $storage }}</span>
                    </div>
                </div>

                <!-- Rating -->
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400 mr-2 text-xs">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($product->average_rating ?? 5))
                                <span>★</span>
                            @else
                                <span class="text-gray-300">★</span>
                            @endif
                        @endfor
                    </div>
                    <span class="text-xs text-gray-400">({{ $product->reviews_count ?? 0 }} đánh giá)</span>
                </div>

                <!-- Price -->
                <div class="mb-4 pt-4 border-t border-gray-100">
                    @if($product->sale_price && $product->sale_price < $product->price)
                        <div class="text-gray-400 line-through text-xs mb-1">
                            {{ number_format($product->price) }}₫
                        </div>
                        <div class="text-blue-600 font-bold text-xl">
                            {{ number_format($product->sale_price) }}₫
                        </div>
                    @else
                        <div class="text-gray-900 font-bold text-xl">
                            {{ number_format($product->price) }}₫
                        </div>
                    @endif
                </div>

                <!-- Add to Cart Button -->
                <form action="{{ route('cart.add', $product) }}" method="POST" class="w-full">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="block w-full bg-gray-900 text-white hover:bg-blue-600 transition-all text-center py-3 font-bold rounded-xl text-sm shadow-lg hover:shadow-blue-500/30 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Thêm vào giỏ
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="text-6xl mb-4 opacity-20">🔍</div>
            <p class="text-gray-500 text-lg">Không tìm thấy sản phẩm phù hợp</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $builds->links() }}
    </div>

    <!-- CTA Section -->
    <div class="mt-12 bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-3">Không tìm thấy cấu hình phù hợp?</h2>
        <p class="mb-8 text-gray-500">Tự build PC theo ý muốn với công cụ Build PC của chúng tôi</p>
        <a href="{{ route('build-pc') }}" class="inline-block px-8 py-4 bg-blue-600 text-white font-bold hover:bg-blue-700 transition-all rounded-xl shadow-lg hover:shadow-blue-500/30 text-sm">
            Build PC ngay
        </a>
    </div>
    </div>
</div>
@endsection
