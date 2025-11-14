@extends('layouts.app')

@section('title', 'UITech - Cửa hàng linh kiện máy tính')

@section('content')
<!-- Hero Section -->
<div class="relative h-96 md:h-[500px] bg-gradient-to-r from-cyber-darker via-cyber-dark to-cyber-darker overflow-hidden">
    <!-- Animated Grid Background -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0 bg-[linear-gradient(0deg,transparent_24%,rgba(0,255,255,.05)_25%,rgba(0,255,255,.05)_26%,transparent_55%)] bg-[length:60px_60px]"></div>
    </div>
    
    <!-- Content -->
    <div class="relative h-full max-w-7xl mx-auto px-4 flex items-center">
        <div class="w-full md:w-1/2 space-y-6">
            <div class="space-y-2">
                <div class="text-cyber-accent text-sm font-mono font-bold">// Welcome to UITech</div>
                <h1 class="text-4xl md:text-5xl font-bold text-cyber-text">
                    Linh Kiện Máy Tính <span class="text-cyber-accent">Premium</span>
                </h1>
            </div>
            <p class="text-cyber-muted text-lg max-w-md">
                Khám phá bộ sưu tập hoàn chỉnh CPU, GPU, RAM, SSD từ các thương hiệu hàng đầu thế giới.
            </p>
            <div class="flex gap-4 pt-4">
                <a href="{{ route('products.index') }}" class="px-6 py-3 bg-cyber-accent text-cyber-darker font-bold rounded-lg hover:shadow-[0_0_20px_rgba(0,255,255,0.5)] transition-all">
                    Khám Phá Ngay
                </a>
                <a href="{{ route('products.index') }}" class="px-6 py-3 border border-cyber-accent text-cyber-accent rounded-lg hover:bg-cyber-accent/10 transition-all">
                    Xem Danh Mục
                </a>
            </div>
        </div>
        
        <!-- Hero Visual -->
        <div class="hidden md:block w-1/2">
            <div class="relative h-80 flex items-center justify-center">
                <div class="absolute w-64 h-64 bg-cyber-accent/20 rounded-full blur-3xl"></div>
                <div class="relative text-8xl">💻</div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Categories -->
<section class="py-16 bg-cyber-dark">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <div class="text-cyber-accent text-sm font-mono font-bold mb-2">// DANH MỤC SẢN PHẨM</div>
            <h2 class="text-3xl font-bold text-cyber-text">Các Hạng Mục Chính</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach(['CPU' => '⚡', 'GPU' => '🎮', 'RAM' => '📊', 'SSD' => '💾'] as $cat => $icon)
            <a href="{{ route('products.index', ['category_id' => \App\Models\Category::where('name', $cat)->first()?->id]) }}" 
               class="group p-8 bg-cyber-card border border-cyber-border rounded-lg hover:border-cyber-accent hover:shadow-[0_0_20px_rgba(0,255,255,0.3)] transition-all text-center">
                <div class="text-5xl mb-4 group-hover:scale-110 transition-transform">{{ $icon }}</div>
                <h3 class="text-lg font-bold text-cyber-text group-hover:text-cyber-accent transition-colors">{{ $cat }}</h3>
                <p class="text-cyber-muted text-sm mt-2">Bộ sưu tập đầy đủ</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-16 bg-cyber-darker">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <div class="text-cyber-accent text-sm font-mono font-bold mb-2">// SẢN PHẨM NỔI BẬT</div>
            <h2 class="text-3xl font-bold text-cyber-text">Sản Phẩm Được Ưa Chuộng</h2>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse(\App\Models\Product::with('category', 'images')->limit(4)->get() as $product)
            <a href="{{ route('products.show', $product->slug) }}" 
               class="group bg-cyber-card border border-cyber-border rounded-lg overflow-hidden hover:border-cyber-accent hover:shadow-[0_0_20px_rgba(0,255,255,0.3)] transition-all">
                <div class="relative h-48 bg-cyber-darker overflow-hidden">
                    @if($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-cyber-muted text-3xl">📦</div>
                    @endif
                    <div class="absolute top-3 right-3 bg-cyber-accent/20 backdrop-blur px-3 py-1 rounded text-cyber-accent text-xs font-bold">{{ $product->category->name }}</div>
                </div>
                
                <div class="p-4 space-y-3">
                    <h3 class="font-bold text-cyber-text line-clamp-2 group-hover:text-cyber-accent transition-colors">{{ $product->name }}</h3>
                    
                    @if($product->brand)
                    <p class="text-cyber-muted text-xs uppercase tracking-wider">{{ $product->brand }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between pt-2 border-t border-cyber-border">
                        <div class="text-cyber-accent font-bold">
                            {{ number_format($product->sale_price ?? $product->price, 0, ',', '.') }}₫
                        </div>
                        @if($product->stock > 0)
                        <span class="text-cyber-success text-xs font-mono">✓ Còn hàng</span>
                        @else
                        <span class="text-cyber-error text-xs font-mono">✗ Hết hàng</span>
                        @endif
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-12 text-cyber-muted">
                <p>Chưa có sản phẩm nào</p>
            </div>
            @endforelse
        </div>
        
        <div class="text-center mt-10">
            <a href="{{ route('products.index') }}" class="inline-block px-8 py-3 border border-cyber-accent text-cyber-accent rounded-lg hover:bg-cyber-accent/10 transition-all font-bold">
                Xem Tất Cả Sản Phẩm →
            </a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-cyber-dark border-y border-cyber-border">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-3xl font-bold text-cyber-accent font-mono">{{ \App\Models\Product::count() }}+</div>
                <p class="text-cyber-muted mt-2">Sản Phẩm</p>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-cyber-accent font-mono">{{ \App\Models\Category::count() }}</div>
                <p class="text-cyber-muted mt-2">Danh Mục</p>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-cyber-accent font-mono">100%</div>
                <p class="text-cyber-muted mt-2">Chính Hãng</p>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-cyber-accent font-mono">24/7</div>
                <p class="text-cyber-muted mt-2">Hỗ Trợ</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-cyber-darker">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-6 bg-cyber-card border border-cyber-border rounded-lg hover:border-cyber-accent/50 transition-colors">
                <div class="text-3xl mb-4">🚚</div>
                <h3 class="text-lg font-bold text-cyber-text mb-2">Giao Hàng Nhanh</h3>
                <p class="text-cyber-muted text-sm">Miễn phí ship cho đơn hàng trên 500K, giao hàng 1-2 ngày</p>
            </div>
            
            <div class="p-6 bg-cyber-card border border-cyber-border rounded-lg hover:border-cyber-accent/50 transition-colors">
                <div class="text-3xl mb-4">🔒</div>
                <h3 class="text-lg font-bold text-cyber-text mb-2">Thanh Toán An Toàn</h3>
                <p class="text-cyber-muted text-sm">Hỗ trợ nhiều phương thức thanh toán, bảo mật 100%</p>
            </div>
            
            <div class="p-6 bg-cyber-card border border-cyber-border rounded-lg hover:border-cyber-accent/50 transition-colors">
                <div class="text-3xl mb-4">⭐</div>
                <h3 class="text-lg font-bold text-cyber-text mb-2">Bảo Hành Chính Hãng</h3>
                <p class="text-cyber-muted text-sm">Tất cả sản phẩm đều có bảo hành chính hãng từ nhà sản xuất</p>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-16 bg-gradient-to-r from-cyber-accent/10 via-transparent to-cyber-accent/10 border-y border-cyber-border">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <h2 class="text-2xl font-bold text-cyber-text mb-4">Đăng Ký Nhận Tin Tức</h2>
        <p class="text-cyber-muted mb-6">Nhận cập nhật sản phẩm mới và khuyến mãi độc quyền</p>
        
        <form class="flex gap-2">
            <input type="email" placeholder="Nhập email của bạn..." 
                   class="flex-1 px-4 py-3 bg-cyber-card border border-cyber-border rounded-lg text-cyber-text placeholder-cyber-muted focus:outline-none focus:border-cyber-accent transition-colors">
            <button type="submit" class="px-6 py-3 bg-cyber-accent text-cyber-darker font-bold rounded-lg hover:shadow-[0_0_20px_rgba(0,255,255,0.5)] transition-all">
                Đăng Ký
            </button>
        </form>
    </div>
</section>

@endsection
