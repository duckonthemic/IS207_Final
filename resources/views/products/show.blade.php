@extends('layouts.app')

@section('title', $product->name . ' - UITech')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        {{-- Breadcrumb --}}
        <nav class="text-sm text-gray-500 mb-8 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Trang chủ</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('products.index') }}" class="hover:text-blue-600 transition-colors">{{ explode(' - ', $product->category->name)[0] ?? 'Sản phẩm' }}</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-blue-600 transition-colors">{{ $product->category->name }}</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-medium truncate max-w-[200px]">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- LEFT: Image Gallery --}}
            <div class="lg:col-span-7">
                <div class="sticky top-24 space-y-4">
                    {{-- Main Image --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 relative group overflow-hidden" x-data="{ showLightbox: false }">
                        <div @click="showLightbox = true" class="cursor-zoom-in flex items-center justify-center aspect-square">
                            <img id="mainImage" 
                                src="{{ $product->images->first()?->url ?? 'https://via.placeholder.com/600x600?text=' . urlencode($product->name) }}" 
                                alt="{{ $product->name }}" 
                                class="max-w-full max-h-full object-contain transition-transform duration-500 group-hover:scale-105">
                        </div>
                        
                        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="showLightbox = true" class="bg-white text-gray-700 p-2 rounded-full shadow-md hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                </svg>
                            </button>
                        </div>

                        {{-- Lightbox --}}
                        <div x-show="showLightbox" 
                            @click="showLightbox = false"
                            class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4 backdrop-blur-sm"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            style="display: none;">
                            <div class="relative w-full max-w-5xl h-full flex items-center justify-center">
                                <button @click="showLightbox = false" 
                                    class="absolute top-4 right-4 text-white/70 hover:text-white transition-colors">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                                <img :src="document.getElementById('mainImage').src" 
                                    alt="{{ $product->name }}" 
                                    class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
                            </div>
                        </div>
                    </div>

                    {{-- Thumbnails --}}
                    @if($product->images->count() > 1)
                        <div class="grid grid-cols-5 gap-4">
                            @foreach($product->images as $image)
                                <div class="bg-white rounded-xl border border-gray-100 p-2 cursor-pointer hover:border-blue-500 hover:shadow-md transition-all aspect-square flex items-center justify-center"
                                     onclick="document.getElementById('mainImage').src='{{ $image->url }}'">
                                    <img src="{{ $image->url }}" 
                                        alt="{{ $product->name }}" 
                                        class="max-w-full max-h-full object-contain">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- RIGHT COLUMN: Product Info --}}
            <div class="lg:col-span-5">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 sticky top-24">
                    {{-- Brand & Category --}}
                    <div class="flex items-center gap-2 mb-4">
                        <span class="bg-blue-50 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">
                            {{ $product->category->name }}
                        </span>
                        @if($product->brand)
                            <span class="text-gray-500 text-sm font-medium">
                                {{ $product->brand }}
                            </span>
                        @endif
                    </div>

                    {{-- Title --}}
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 leading-tight">
                        {{ $product->name }}
                    </h1>

                    {{-- Rating & SKU --}}
                    <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="flex text-yellow-400 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($product->average_rating))
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    @else
                                        <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500">({{ $product->reviews_count }} đánh giá)</span>
                        </div>
                        <div class="text-sm text-gray-500 font-mono">
                            SKU: <span class="text-gray-900">{{ $product->sku }}</span>
                        </div>
                    </div>

                    {{-- Price --}}
                    <div class="mb-8">
                        @if($product->sale_price)
                            <div class="flex items-end gap-3 mb-2">
                                <span class="text-4xl font-bold text-blue-600">{{ number_format($product->sale_price, 0, ',', '.') }}₫</span>
                                <span class="text-lg text-gray-400 line-through mb-1">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded-full mb-2">
                                    -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                </span>
                            </div>
                            <p class="text-sm text-green-600 font-medium">Tiết kiệm: {{ number_format($product->price - $product->sale_price, 0, ',', '.') }}₫</p>
                        @else
                            <span class="text-4xl font-bold text-gray-900">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                        @endif
                    </div>

                    {{-- Short Specs / Benefits --}}
                    <div class="bg-gray-50 rounded-xl p-4 mb-8 space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm text-gray-700">Bảo hành chính hãng 36 tháng</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm text-gray-700">Miễn phí vận chuyển toàn quốc</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm text-gray-700">Hỗ trợ trả góp 0% lãi suất</span>
                        </div>
                    </div>

                    {{-- Actions --}}
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <div class="flex items-center gap-4">
                                <div class="flex items-center border border-gray-200 rounded-xl bg-white">
                                    <button type="button" onclick="decrementQty()" class="px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-l-xl transition-colors font-bold">-</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                        class="w-16 text-center border-x border-gray-200 py-3 focus:outline-none text-gray-900 font-medium">
                                    <button type="button" onclick="incrementQty()" class="px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-r-xl transition-colors font-bold">+</button>
                                </div>
                                <div class="text-sm text-gray-500">
                                    Còn <span class="font-bold text-gray-900">{{ $product->stock }}</span> sản phẩm
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <button type="submit" class="col-span-1 bg-black text-white font-bold py-4 rounded-xl hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    Thêm vào giỏ
                                </button>
                                <button type="button" class="col-span-1 bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    Mua ngay
                                </button>
                            </div>
                        </form>

                        <a href="{{ route('build-pc') }}" class="block w-full mt-4 border-2 border-gray-200 text-gray-700 font-bold py-3 rounded-xl hover:border-gray-900 hover:text-gray-900 transition-all text-center flex items-center justify-center gap-2 group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-900 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                            Build PC với linh kiện này
                        </a>
                    @else
                        <div class="bg-gray-100 rounded-xl p-4 text-center text-gray-500 font-medium">
                            Sản phẩm hiện đang hết hàng
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Bottom Section: Specs & Reviews --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-12">
            <div class="lg:col-span-8 space-y-8">
                {{-- Specs --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900">Thông Số Kỹ Thuật</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @if($product->specs->count() > 0)
                            @foreach($product->specs as $spec)
                                <div class="grid grid-cols-3 px-8 py-4 hover:bg-gray-50 transition-colors">
                                    <div class="col-span-1 text-sm font-medium text-gray-500">
                                        {{ $spec->specDefinition->name }}
                                    </div>
                                    <div class="col-span-2 text-sm text-gray-900 font-medium">
                                        @if($spec->specDefinition->code == 'gpu_output' || $spec->specDefinition->code == 'gpu_accessories')
                                            <div class="whitespace-pre-line">{{ $spec->value }}</div>
                                        @else
                                            {{ $spec->value }}{{ $spec->specDefinition->unit ? ' ' . $spec->specDefinition->unit : '' }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="grid grid-cols-3 px-8 py-4 hover:bg-gray-50 transition-colors">
                                <div class="col-span-1 text-sm font-medium text-gray-500">Danh mục</div>
                                <div class="col-span-2 text-sm text-gray-900">{{ $product->category->name }}</div>
                            </div>
                            <div class="grid grid-cols-3 px-8 py-4 hover:bg-gray-50 transition-colors">
                                <div class="col-span-1 text-sm font-medium text-gray-500">SKU</div>
                                <div class="col-span-2 text-sm text-gray-900 font-mono">{{ $product->sku }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Description --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Mô Tả Sản Phẩm</h2>
                    <div class="prose prose-blue max-w-none text-gray-600 leading-relaxed">
                        {{ $product->description }}
                    </div>
                </div>

                {{-- Reviews --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-xl font-bold text-gray-900">Đánh Giá & Nhận Xét</h2>
                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm font-medium">{{ $product->reviews_count }} đánh giá</span>
                    </div>

                    @if($product->reviews_count > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 pb-10 border-b border-gray-100">
                            <div class="text-center flex flex-col justify-center items-center">
                                <div class="text-6xl font-bold text-gray-900 mb-2">{{ number_format($product->average_rating, 1) }}</div>
                                <div class="flex text-yellow-400 text-xl mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span>{{ $i <= round($product->average_rating) ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                                <p class="text-gray-500 text-sm">Dựa trên {{ $product->reviews_count }} đánh giá</p>
                            </div>
                            <div class="space-y-2">
                                @php
                                    $totalReviews = max($product->reviews_count, 1);
                                @endphp
                                @for($rating = 5; $rating >= 1; $rating--)
                                    @php
                                        $count = $product->approvedReviews->where('rating', $rating)->count();
                                        $percentage = ($count / $totalReviews) * 100;
                                    @endphp
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-medium text-gray-600 w-6">{{ $rating }} ★</span>
                                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-sm text-gray-400 w-8 text-right">{{ $count }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    @endif

                    {{-- Review Form --}}
                    @auth
                        @if($canReview)
                            <div class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-100">
                                <h3 class="font-bold text-gray-900 mb-4">Viết đánh giá của bạn</h3>
                                <form action="{{ route('reviews.store', $product) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Đánh giá của bạn</label>
                                        <div class="flex gap-2" x-data="{ rating: 5, hover: 0 }">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button" 
                                                    @click="rating = {{ $i }}" 
                                                    @mouseenter="hover = {{ $i }}"
                                                    @mouseleave="hover = 0"
                                                    class="text-2xl transition-colors focus:outline-none"
                                                    :class="(hover >= {{ $i }} || rating >= {{ $i }}) ? 'text-yellow-400' : 'text-gray-300'">
                                                    ★
                                                </button>
                                            @endfor
                                            <input type="hidden" name="rating" :value="rating">
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nhận xét</label>
                                        <textarea name="comment" rows="3" 
                                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                            placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này...">{{ old('comment') }}</textarea>
                                    </div>
                                    <button type="submit" class="bg-blue-600 text-white font-bold py-2.5 px-6 rounded-lg hover:bg-blue-700 transition-colors shadow-md">
                                        Gửi đánh giá
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth

                    {{-- Reviews List --}}
                    <div class="space-y-6">
                        @forelse($product->approvedReviews->take(5) as $review)
                            <div class="border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-sm">{{ $review->user->name }}</h4>
                                            <div class="flex text-yellow-400 text-xs mt-0.5">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ $review->created_at->format('d/m/Y') }}</span>
                                </div>
                                @if($review->comment)
                                    <p class="text-gray-600 text-sm mt-3 ml-13 pl-13">{{ $review->comment }}</p>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300 text-2xl">💬</div>
                                <p class="text-gray-500">Chưa có đánh giá nào cho sản phẩm này.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Right Sidebar --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- Related News --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Tin Tức Công Nghệ</h3>
                    <div class="space-y-4">
                        <a href="#" class="block group">
                            <h4 class="text-sm font-medium text-gray-800 group-hover:text-blue-600 transition-colors line-clamp-2 mb-1">
                                Đánh giá hiệu năng RTX 4090: Quái vật đồ họa mới
                            </h4>
                            <span class="text-xs text-gray-400">12/05/2025</span>
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <a href="#" class="block group">
                            <h4 class="text-sm font-medium text-gray-800 group-hover:text-blue-600 transition-colors line-clamp-2 mb-1">
                                Top 5 CPU chơi game tốt nhất năm 2025
                            </h4>
                            <span class="text-xs text-gray-400">10/05/2025</span>
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <a href="#" class="block group">
                            <h4 class="text-sm font-medium text-gray-800 group-hover:text-blue-600 transition-colors line-clamp-2 mb-1">
                                Hướng dẫn build PC Gaming 20 triệu chiến mọi game
                            </h4>
                            <span class="text-xs text-gray-400">05/05/2025</span>
                        </a>
                    </div>
                </div>

                {{-- Banner --}}
                <div class="rounded-2xl overflow-hidden relative group h-64">
                    <img src="https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=800&q=80" alt="Banner" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-6">
                        <h3 class="text-white font-bold text-xl mb-2">Build PC Chuyên Nghiệp</h3>
                        <p class="text-gray-300 text-sm mb-4">Tự xây dựng cấu hình máy tính mơ ước của bạn ngay hôm nay.</p>
                        <a href="{{ route('build-pc') }}" class="inline-block bg-white text-black font-bold py-2 px-4 rounded-lg text-sm hover:bg-gray-100 transition-colors text-center">
                            Bắt đầu ngay
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->isNotEmpty())
            <div class="mt-16 pt-12 border-t border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Sản Phẩm Tương Tự</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts->take(4) as $related)
                        <x-product-card :product="$related" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function incrementQty() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

function decrementQty() {
    const input = document.getElementById('quantity');
    const min = parseInt(input.min);
    const current = parseInt(input.value);
    if (current > min) {
        input.value = current - 1;
    }
}
</script>
@endsection

