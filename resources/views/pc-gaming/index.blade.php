@extends('layouts.app')

@section('title', $pageTitle ?? 'PC Gaming - Bộ PC Gaming Lắp Sẵn')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">
                        Trang chủ
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-gray-500">{{ $pageTitle ?? 'PC Gaming' }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">{{ $pageTitle ?? 'PC Gaming - Bộ PC Gaming Lắp Sẵn' }}</h1>
            <p class="text-gray-600">{{ $pageDescription ?? 'Bộ máy tính gaming được lựa chọn kỹ lưỡng, tối ưu hiệu năng và giá thành' }}</p>
        </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Giá từ (VNĐ)</label>
                <input type="number" name="min_price" value="{{ request('min_price') }}" 
                    placeholder="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Giá đến (VNĐ)</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" 
                    placeholder="100000000" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Sắp xếp</label>
                <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Lọc
            </button>
            <a href="{{ route('pc-gaming.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Xóa lọc
            </a>
        </form>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($builds as $build)
        <div class="bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow">
            <!-- Image -->
            <div class="relative">
                <img src="{{ $build['image'] }}" alt="{{ $build['name'] }}" 
                    class="w-full h-64 object-cover rounded-t-lg">
                @if($build['sale_price'])
                    <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-sm font-bold">
                        -{{ number_format((($build['price'] - $build['sale_price']) / $build['price']) * 100, 0) }}%
                    </div>
                @endif
            </div>

            <!-- Content -->
            <div class="p-4">
                <!-- Name -->
                <h3 class="font-semibold text-lg mb-2 line-clamp-2">{{ $build['name'] }}</h3>

                <!-- Specs -->
                <div class="space-y-1 mb-3 text-sm text-gray-600">
                    <div class="flex items-center">
                        <span class="font-medium w-16">CPU:</span>
                        <span class="truncate">{{ $build['cpu'] }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-medium w-16">VGA:</span>
                        <span class="truncate">{{ $build['gpu'] }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-medium w-16">RAM:</span>
                        <span>{{ $build['ram'] }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-medium w-16">SSD:</span>
                        <span>{{ $build['storage'] }}</span>
                    </div>
                </div>

                <!-- Rating -->
                <div class="flex items-center mb-3">
                    <div class="flex text-yellow-400 mr-1">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($build['rating']))
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm text-gray-600">({{ $build['reviews'] }})</span>
                </div>

                <!-- Price -->
                <div class="mb-3">
                    @if($build['sale_price'])
                        <div class="text-gray-400 line-through text-sm">
                            {{ number_format($build['price']) }}₫
                        </div>
                        <div class="text-red-600 font-bold text-xl">
                            {{ number_format($build['sale_price']) }}₫
                        </div>
                    @else
                        <div class="text-red-600 font-bold text-xl">
                            {{ number_format($build['price']) }}₫
                        </div>
                    @endif
                </div>

                <!-- Contact Button -->
                <a href="tel:0901234567" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded-lg font-medium">
                    Liên hệ: 0901.234.567
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500 text-lg">Không tìm thấy sản phẩm phù hợp</p>
        </div>
        @endforelse
    </div>

    <!-- CTA Section -->
    <div class="mt-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-8 text-white text-center">
        <h2 class="text-2xl font-bold mb-3">Không tìm thấy cấu hình phù hợp?</h2>
        <p class="mb-6">Tự build PC theo ý muốn với công cụ Build PC của chúng tôi</p>
        <a href="{{ route('build-pc') }}" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
            Build PC ngay
        </a>
    </div>
    </div>
</div>
@endsection
