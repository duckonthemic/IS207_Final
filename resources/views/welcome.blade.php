@extends('layouts.app')

@section('title', 'UITech Store - Cửa hàng linh kiện máy tính chính hãng')

@section('content')
<!-- Hero Section -->
<div class="relative bg-black overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&w=1920&q=80" alt="Background" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/50 to-transparent"></div>
    </div>
    <div class="container mx-auto px-4 py-24 sm:py-32 lg:py-40 relative z-10">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 mb-8">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                <span class="text-sm font-medium text-white">Công nghệ mới nhất 2025</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-bold text-white leading-tight tracking-tight mb-6">
                Build PC <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-500">Đỉnh Cao Hiệu Năng</span>
            </h1>
            <p class="text-gray-300 text-xl max-w-xl leading-relaxed mb-10">
                Trải nghiệm sức mạnh tuyệt đối với linh kiện máy tính chính hãng. Bảo hành 36 tháng, hỗ trợ kỹ thuật trọn đời.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('products.index') }}" class="px-8 py-4 bg-blue-600 text-white font-bold rounded-full hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-500/30 transform hover:-translate-y-1">
                    Mua sắm ngay
                </a>
                <a href="{{ route('build-pc') }}" class="px-8 py-4 bg-white/10 text-white border border-white/20 font-bold rounded-full hover:bg-white/20 transition-all backdrop-blur-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    Build PC
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Featured Categories Section -->
@php
    $featuredCategories = [
        ['name' => 'CPU', 'slug' => 'cpu-processor', 'image' => 'https://www.intel.com/content/dam/www/central-libraries/us/en/images/2022-08/core-i9-13900k-front-angle-transparent-background.png.rendition.intel.web.576.324.png', 'count' => \App\Models\Product::whereHas('category', function($q) { $q->where('slug', 'cpu-processor'); })->count()],
        ['name' => 'VGA', 'slug' => 'vga-card-man-hinh', 'image' => 'https://dlcdnwebimgs.asus.com/gain/4d6e6567-8643-49c9-9e72-9c257464c6d8/', 'count' => \App\Models\Product::whereHas('category', function($q) { $q->where('slug', 'vga-card-man-hinh'); })->count()],
        ['name' => 'RAM', 'slug' => 'ram-bo-nho', 'image' => 'https://www.corsair.com/medias/sys_master/images/images/h80/h90/9659502493726/CMH32GX5M2B5200C40/Gallery/CMH32GX5M2B5200C40_-01/-CMH32GX5M2B5200C40-01.png', 'count' => \App\Models\Product::whereHas('category', function($q) { $q->where('slug', 'ram-bo-nho'); })->count()],
        ['name' => 'SSD', 'slug' => 'ssd-o-cung', 'image' => 'https://images.samsung.com/is/image/samsung/p6pim/vn/mz-v9p1t0bw/gallery/vn-990-pro-nvme-m2-ssd-mz-v9p1t0bw-534436483?$684_547_PNG$', 'count' => \App\Models\Product::whereHas('category', function($q) { $q->where('slug', 'ssd-o-cung'); })->count()],
        ['name' => 'Mainboard', 'slug' => 'mainboard-mainboard', 'image' => 'https://dlcdnwebimgs.asus.com/gain/07b04a2b-5a8c-4580-b7d9-539e22d7b885/', 'count' => \App\Models\Product::whereHas('category', function($q) { $q->where('slug', 'mainboard-mainboard'); })->count()],
        ['name' => 'Monitor', 'slug' => 'monitor-man-hinh', 'image' => 'https://dlcdnwebimgs.asus.com/gain/9233c983-f5a0-45b2-9670-040065e1e980/', 'count' => \App\Models\Product::whereHas('category', function($q) { $q->where('slug', 'monitor-man-hinh'); })->count()],
    ];
@endphp
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Danh mục nổi bật</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">Lựa chọn linh kiện phù hợp nhất cho bộ PC mơ ước của bạn từ các danh mục hàng đầu.</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($featuredCategories as $cat)
            <a href="{{ route('products.index', ['category' => $cat['slug']]) }}" 
               class="group bg-gray-50 rounded-2xl p-6 text-center hover:bg-white hover:shadow-xl transition-all duration-300 border border-transparent hover:border-gray-100">
                <div class="h-24 mb-4 flex items-center justify-center">
                    <img src="{{ $cat['image'] }}" alt="{{ $cat['name'] }}" class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-500">
                </div>
                <h3 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $cat['name'] }}</h3>
                <p class="text-xs text-gray-500 mt-1">{{ $cat['count'] }} sản phẩm</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Flash Deals Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex items-center justify-between mb-12">
            <div class="flex items-center gap-4">
                <h2 class="text-3xl font-bold text-gray-900">Deal Giờ Vàng</h2>
                <div class="flex items-center gap-1 text-white font-bold text-sm">
                    <span class="bg-gray-900 rounded px-2 py-1">08</span>
                    <span class="text-gray-900">:</span>
                    <span class="bg-gray-900 rounded px-2 py-1">53</span>
                    <span class="text-gray-900">:</span>
                    <span class="bg-gray-900 rounded px-2 py-1">47</span>
                </div>
            </div>
            <a href="{{ route('products.index') }}" class="text-blue-600 font-medium hover:text-blue-700 flex items-center gap-1">
                Xem tất cả
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
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
                <x-product-card :product="$product" />
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    <p>Chưa có deal nào đang diễn ra.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Sản phẩm được ưa chuộng</h2>
            <p class="text-gray-500">Những sản phẩm bán chạy nhất tuần qua</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse(\App\Models\Product::with('category', 'images')->limit(8)->get() as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="col-span-full text-center py-12 text-gray-400">
                    <p>Chưa có sản phẩm nào</p>
                </div>
            @endforelse
        </div>
        
        <div class="text-center mt-16">
            <a href="{{ route('products.index') }}" class="inline-block px-10 py-4 bg-white border border-gray-200 text-gray-900 font-bold rounded-full hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm hover:shadow-md">
                Xem Tất Cả Sản Phẩm
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gray-50 border-t border-gray-100">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="flex gap-6 p-6 bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-2xl shrink-0">🚚</div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Giao Hàng Nhanh</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Miễn phí vận chuyển cho đơn hàng trên 500K. Giao hàng hỏa tốc trong 2h tại nội thành.</p>
                </div>
            </div>
            
            <div class="flex gap-6 p-6 bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center text-2xl shrink-0">🛡️</div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Bảo Hành Chính Hãng</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Cam kết hàng chính hãng 100%. Bảo hành đổi mới trong 30 ngày đầu nếu lỗi.</p>
                </div>
            </div>
            
            <div class="flex gap-6 p-6 bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-purple-50 rounded-full flex items-center justify-center text-2xl shrink-0">💳</div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Thanh Toán Linh Hoạt</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Hỗ trợ trả góp 0%. Thanh toán qua thẻ, ví điện tử hoặc COD.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-20 bg-gray-900 text-white overflow-hidden relative">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-purple-500 rounded-full filter blur-3xl"></div>
    </div>
    
    <div class="container mx-auto px-4 max-w-2xl text-center relative z-10">
        <h2 class="text-3xl font-bold mb-4">Đăng ký nhận tin tức</h2>
        <p class="text-gray-400 mb-8">Nhận thông tin về sản phẩm mới, khuyến mãi và voucher độc quyền.</p>
        
        <form class="flex gap-2 max-w-lg mx-auto">
            <input type="email" placeholder="Nhập email của bạn..." 
                   class="flex-1 px-6 py-4 bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:bg-white/20 focus:border-white/40 transition-all rounded-full backdrop-blur-sm">
            <button type="submit" class="px-8 py-4 bg-white text-gray-900 font-bold hover:bg-gray-100 transition-all rounded-full shadow-lg">
                Đăng Ký
            </button>
        </form>
    </div>
</section>

@endsection

