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

        <div class="grid grid-cols-12 gap-8">
            {{-- Sidebar Filters --}}
            <aside class="col-span-12 lg:col-span-3 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                        <h2 class="font-bold text-lg text-gray-900">Bộ Lọc</h2>
                        <a href="{{ url()->current() }}" class="text-xs font-medium text-blue-600 hover:text-blue-700">
                            Xóa tất cả
                        </a>
                    </div>
                    
                    <form method="GET">
                        {{-- Dynamic Filters --}}
                        @if(isset($filterOptions) && count($filterOptions) > 0)
                            @foreach($filterOptions as $code => $option)
                                <div class="mb-4 pb-4 border-b border-gray-100 last:border-0 last:pb-0 last:mb-0" x-data="{ expanded: true }">
                                    <button type="button" @click="expanded = !expanded" class="flex items-center justify-between w-full mb-2 group">
                                        <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                                            {{ $option['name'] }}
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
                        <div class="mt-6 pt-6 border-t border-gray-100">
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
                                Áp Dụng
                            </button>
                        </div>
                    </form>
                </div>
            </aside>

            {{-- Main Content --}}
            <main class="col-span-12 lg:col-span-9">
                {{-- Sort --}}
                <div class="flex justify-end mb-6">
                    <div class="flex items-center gap-3 bg-white p-1 rounded-xl border border-gray-200 shadow-sm">
                        <span class="text-sm font-medium text-gray-500 pl-3">Sắp xếp:</span>
                        <div class="flex">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}"
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('sort', 'latest') == 'latest' ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                                Mới nhất
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}"
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('sort') == 'price_asc' ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                                Giá tăng
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}"
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request('sort') == 'price_desc' ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                                Giá giảm
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Product Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
            </main>
        </div>
    </div>
</div>
@endsection
