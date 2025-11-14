@extends('layouts.app')

@section('title', 'UITech Store - Cửa hàng linh kiện máy tính chính hãng')

@section('content')
<!-- Hero Section -->
<div class="relative h-[500px] bg-black overflow-hidden">
    <!-- Animated Grid Background -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.05)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.05)_1px,transparent_1px)] bg-[size:50px_50px]"></div>
    </div>
    
    <!-- Content -->
    <div class="relative h-full max-w-7xl mx-auto px-4 flex items-center">
        <div class="w-full md:w-2/3 space-y-6">
            <div class="space-y-3">
                <div class="text-gray-400 text-sm font-bold uppercase tracking-wider">Chào mừng đến với UITech Store</div>
                <h1 class="text-5xl md:text-6xl font-black text-white leading-tight">
                    Linh Kiện Máy Tính<br/>
                    <span class="text-gray-400">Chính Hãng</span>
                </h1>
            </div>
            <p class="text-gray-300 text-lg max-w-xl">
                Khám phá bộ sưu tập hoàn chỉnh CPU, GPU, RAM, SSD từ các thương hiệu hàng đầu thế giới với giá cạnh tranh nhất.
            </p>
            <div class="flex gap-4 pt-4">
                <a href="{{ route('products.index') }}" class="px-8 py-4 bg-white text-black font-bold rounded hover:bg-gray-100 transition-all">
                    Khám Phá Ngay
                </a>
                <a href="{{ route('pc-gaming.index') }}" class="px-8 py-4 border-2 border-white text-white rounded hover:bg-white hover:text-black transition-all font-bold">
                    PC Gaming
                </a>
            </div>
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="absolute right-0 top-0 w-1/3 h-full opacity-10">
        <div class="absolute inset-0 flex items-center justify-center text-[300px]">💻</div>
    </div>
</div>

<!-- Featured Categories Section -->
@php
    $featuredCategories = [
        ['name' => 'CPU', 'slug' => 'cpu-processor', 'icon' => '🖥️', 'count' => \App\Models\Product::whereHas('category', function($q) { $q->where('slug', 'cpu-processor'); })->count()],
        ['name' => 'VGA', 'slug' => 'vga-card-man-hinh', 'icon' => '🎮', 'count' => \App\Models\Product::whereHas('category', function($q) { $q->where('slug', 'vga-card-man-hinh'); })->count()],
        ['name' => 'RAM', 'slug' => 'ram-bo-nho', 'icon' => '💾', 'count' => \App\Models\Product::whereHas('category', function($q) { $q->where('slug', 'ram-bo-nho'); })->count()],
        ['name' => 'SSD', 'slug' => 'ssd-o-cung', 'icon' => '💿', 'count' => \App\Models\Product::whereHas('category', function($q) { $q->where('slug', 'ssd-o-cung'); })->count()],
        ['name' => 'Mainboard', 'slug' => 'mainboard-mainboard', 'icon' => '⚡', 'count' => \App\Models\Product::whereHas('category', function($q) { $q->where('slug', 'mainboard-mainboard'); })->count()],
        ['name' => 'Monitor', 'slug' => 'monitor-man-hinh', 'icon' => '🖥️', 'count' => \App\Models\Product::whereHas('category', function($q) { $q->where('slug', 'monitor-man-hinh'); })->count()],
    ];
@endphp
<section class="py-16 bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Danh Mục Nổi Bật</h2>
            <p class="text-gray-600">Lựa chọn linh kiện phù hợp cho build PC của bạn</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($featuredCategories as $cat)
            <a href="{{ route('products.index', ['category' => $cat['slug']]) }}" 
               class="group p-6 bg-gray-50 border-2 border-gray-200 rounded-lg hover:border-black hover:bg-black transition-all text-center">
                <div class="text-5xl mb-3 group-hover:scale-110 transition-transform">{{ $cat['icon'] }}</div>
                <h3 class="font-bold text-gray-900 group-hover:text-white mb-1">{{ $cat['name'] }}</h3>
                <p class="text-xs text-gray-500 group-hover:text-gray-300">{{ $cat['count'] }} sản phẩm</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Flash Deals Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <div class="flex items-center gap-4 mb-2">
                    <div class="text-black text-sm font-bold uppercase tracking-wider">🔥 Deal Giờ Vàng</div>
                    <div class="flex items-center gap-2 text-gray-900 font-mono font-bold text-lg">
                        <span class="bg-black text-white px-3 py-1 rounded">08</span>
                        <span>:</span>
                        <span class="bg-black text-white px-3 py-1 rounded">53</span>
                        <span>:</span>
                        <span class="bg-black text-white px-3 py-1 rounded">47</span>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Ưu Đãi Có Hạn</h2>
            </div>
            <a href="{{ route('products.index') }}" class="px-6 py-2 border-2 border-black text-black rounded hover:bg-black hover:text-white transition-all font-bold">
                Xem tất cả →
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $flashDeals = \App\Models\Product::with('category', 'images')
                    ->where('sale_price', '>', 0)
                    ->limit(4)
                    ->get();
            @endphp
            @forelse($flashDeals as $product)
            <a href="{{ route('products.show', $product->slug) }}" 
               class="group relative bg-white border-2 border-gray-200 rounded-lg overflow-hidden hover:border-black hover:shadow-xl transition-all">
                {{-- Badge --}}
                <div class="absolute top-3 left-3 z-10 bg-black px-3 py-1 rounded text-white text-xs font-bold">
                    Best choice
                </div>
                
                <div class="relative h-48 bg-gray-100 overflow-hidden">
                    @if($product->images->first())
                        <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300 text-6xl">📦</div>
                    @endif
                </div>
                
                <div class="p-4 space-y-3">
                    <h3 class="font-semibold text-gray-900 text-sm line-clamp-2 group-hover:text-black transition-colors min-h-[40px]">{{ $product->name }}</h3>
                    
                    <div class="flex items-center gap-1">
                        @for($i = 0; $i < 5; $i++)
                            <span class="text-gray-900 text-xs">★</span>
                        @endfor
                        <span class="text-gray-500 text-xs ml-1">{{ rand(8, 20) }} đánh giá</span>
                    </div>
                    
                    <div class="space-y-1">
                        @if($product->sale_price)
                            <div class="text-gray-400 text-sm line-through">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                            <div class="flex items-center justify-between">
                                <div class="text-black font-bold text-xl">{{ number_format($product->sale_price, 0, ',', '.') }}₫</div>
                                <span class="bg-black text-white text-xs font-bold px-2 py-1 rounded">
                                    -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                </span>
                            </div>
                        @else
                            <div class="text-black font-bold text-xl">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                        @endif
                    </div>
                    
                    <div class="pt-2 border-t border-gray-200">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-600">Còn lại:</span>
                            <span class="text-black font-bold">{{ $product->stock }}</span>
                        </div>
                        <div class="mt-2 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-black" style="width: {{ min(($product->stock / 100) * 100, 100) }}%"></div>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <p>Chưa có deal nào</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-16 bg-white border-y border-gray-200">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <div class="text-gray-600 text-sm font-bold uppercase tracking-wider mb-2">Sản Phẩm Nổi Bật</div>
            <h2 class="text-3xl font-bold text-gray-900">Sản Phẩm Được Ưa Chuộng</h2>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse(\App\Models\Product::with('category', 'images')->limit(4)->get() as $product)
            <a href="{{ route('products.show', $product->slug) }}" 
               class="group bg-white border-2 border-gray-200 rounded-lg overflow-hidden hover:border-black hover:shadow-lg transition-all">
                <div class="relative h-48 bg-gray-100 overflow-hidden">
                    @if($product->images->first())
                        <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300 text-6xl">📦</div>
                    @endif
                    <div class="absolute top-3 right-3 bg-gray-100 text-gray-800 px-3 py-1 rounded text-xs font-semibold border border-gray-200">{{ $product->category->name }}</div>
                </div>
                
                <div class="p-4 space-y-3">
                    <h3 class="font-semibold text-gray-900 text-sm line-clamp-2 group-hover:text-black transition-colors min-h-[40px]">{{ $product->name }}</h3>
                    
                    @if($product->brand)
                    <p class="text-gray-500 text-xs uppercase tracking-wider font-semibold">{{ $product->brand }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between pt-2 border-t border-gray-200">
                        <div class="text-black font-bold text-lg">
                            {{ number_format($product->sale_price ?? $product->price, 0, ',', '.') }}₫
                        </div>
                        @if($product->stock > 0)
                        <span class="text-gray-900 text-xs font-semibold bg-gray-100 px-2 py-1 rounded border border-gray-200">Còn hàng</span>
                        @else
                        <span class="text-gray-500 text-xs font-semibold bg-gray-100 px-2 py-1 rounded border border-gray-200">Hết hàng</span>
                        @endif
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <p>Chưa có sản phẩm nào</p>
            </div>
            @endforelse
        </div>
        
        <div class="text-center mt-10">
            <a href="{{ route('products.index') }}" class="inline-block px-8 py-3 border-2 border-black text-black rounded hover:bg-black hover:text-white transition-all font-bold">
                Xem Tất Cả Sản Phẩm →
            </a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-5xl font-black text-black">{{ \App\Models\Product::count() }}+</div>
                <p class="text-gray-600 mt-2 font-semibold">Sản Phẩm</p>
            </div>
            <div class="text-center">
                <div class="text-5xl font-black text-black">{{ \App\Models\Category::count() }}</div>
                <p class="text-gray-600 mt-2 font-semibold">Danh Mục</p>
            </div>
            <div class="text-center">
                <div class="text-5xl font-black text-black">100%</div>
                <p class="text-gray-600 mt-2 font-semibold">Chính Hãng</p>
            </div>
            <div class="text-center">
                <div class="text-5xl font-black text-black">24/7</div>
                <p class="text-gray-600 mt-2 font-semibold">Hỗ Trợ</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white border-y border-gray-200">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-8 bg-gray-50 border-2 border-gray-200 rounded-lg hover:border-black hover:bg-white transition-all">
                <div class="text-5xl mb-4">🚚</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Giao Hàng Nhanh</h3>
                <p class="text-gray-600">Miễn phí ship cho đơn hàng trên 500K, giao hàng 1-2 ngày</p>
            </div>
            
            <div class="p-8 bg-gray-50 border-2 border-gray-200 rounded-lg hover:border-black hover:bg-white transition-all">
                <div class="text-5xl mb-4">🔒</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Thanh Toán An Toàn</h3>
                <p class="text-gray-600">Hỗ trợ nhiều phương thức thanh toán, bảo mật 100%</p>
            </div>
            
            <div class="p-8 bg-gray-50 border-2 border-gray-200 rounded-lg hover:border-black hover:bg-white transition-all">
                <div class="text-5xl mb-4">⭐</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Bảo Hành Chính Hãng</h3>
                <p class="text-gray-600">Tất cả sản phẩm đều có bảo hành chính hãng từ nhà sản xuất</p>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-16 bg-black">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Đăng Ký Nhận Tin Tức</h2>
        <p class="text-gray-400 mb-8">Nhận cập nhật sản phẩm mới và khuyến mãi độc quyền</p>
        
        <form class="flex gap-2 max-w-lg mx-auto">
            <input type="email" placeholder="Nhập email của bạn..." 
                   class="flex-1 px-4 py-3 bg-white border-2 border-gray-300 rounded text-gray-900 placeholder-gray-400 focus:outline-none focus:border-black transition-all">
            <button type="submit" class="px-8 py-3 bg-white text-black font-bold rounded hover:bg-gray-100 transition-all">
                Đăng Ký
            </button>
        </form>
    </div>
</section>

@endsection
