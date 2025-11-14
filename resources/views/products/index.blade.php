@extends('layouts.app')

@section('title', 'Sản phẩm - UITech')

@section('content')
<div class="min-h-screen bg-cyber-dark">
    {{-- Hero Banner --}}
    <div class="bg-gradient-to-r from-cyber-darker via-cyber-dark to-cyber-darker border-b border-cyber-border py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-cyber-accent text-sm font-mono font-bold mb-2">// DANH SÁCH SẢN PHẨM</div>
                    <h1 class="text-4xl font-bold text-cyber-text">Khám Phá Bộ Sưu Tập</h1>
                    <p class="text-cyber-muted mt-2">{{ \App\Models\Product::count() }} sản phẩm | Nhiều thương hiệu nổi tiếng</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            {{-- Sidebar Filters --}}
            <div class="lg:col-span-1">
                <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 sticky top-24 space-y-6">
                    <div>
                        <h3 class="font-bold text-cyber-accent mb-4 font-mono text-sm">▸ BỘ LỌC</h3>
                    </div>

                    {{-- Search --}}
                    <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
                        <div>
                            <label class="text-cyber-muted text-xs uppercase font-bold block mb-2">Tìm kiếm</label>
                            <input type="text" name="q" placeholder="Nhập tên sản phẩm..." value="{{ request('q') }}" 
                                   class="w-full px-3 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-text text-sm placeholder-cyber-muted focus:border-cyber-accent focus:outline-none transition-colors">
                        </div>

                        {{-- Categories --}}
                        <div class="border-t border-cyber-border pt-4">
                            <label class="text-cyber-muted text-xs uppercase font-bold block mb-3">Danh Mục</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer hover:text-cyber-accent transition-colors">
                                    <input type="radio" name="category_id" value="" {{ !request('category_id') ? 'checked' : '' }} class="accent-cyber-accent">
                                    <span class="text-cyber-text text-sm">Tất Cả</span>
                                </label>
                                @foreach($categories as $cat)
                                <label class="flex items-center gap-2 cursor-pointer hover:text-cyber-accent transition-colors">
                                    <input type="radio" name="category_id" value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'checked' : '' }} class="accent-cyber-accent">
                                    <span class="text-cyber-text text-sm">{{ $cat->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Price Range --}}
                        <div class="border-t border-cyber-border pt-4">
                            <label class="text-cyber-muted text-xs uppercase font-bold block mb-3">Khoảng Giá</label>
                            <div class="space-y-2">
                                <input type="number" name="min_price" placeholder="Từ (VND)" value="{{ request('min_price') }}" 
                                       class="w-full px-3 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-text text-sm placeholder-cyber-muted focus:border-cyber-accent focus:outline-none">
                                <input type="number" name="max_price" placeholder="Đến (VND)" value="{{ request('max_price') }}" 
                                       class="w-full px-3 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-text text-sm placeholder-cyber-muted focus:border-cyber-accent focus:outline-none">
                            </div>
                        </div>

                        {{-- Sort --}}
                        <div class="border-t border-cyber-border pt-4">
                            <label class="text-cyber-muted text-xs uppercase font-bold block mb-3">Sắp Xếp</label>
                            <select name="sort" class="w-full px-3 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-text text-sm focus:border-cyber-accent focus:outline-none">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp → Cao</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao → Thấp</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Tên A-Z</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full px-4 py-2 bg-cyber-accent text-cyber-darker font-bold rounded-lg hover:shadow-[0_0_20px_rgba(0,255,255,0.5)] transition-all">
                            Áp Dụng Bộ Lọc
                        </button>
                    </form>

                    @if(request('q') || request('category_id') || request('min_price') || request('max_price'))
                    <a href="{{ route('products.index') }}" class="block w-full px-4 py-2 border border-cyber-border text-cyber-muted text-sm text-center rounded-lg hover:text-cyber-accent hover:border-cyber-accent transition-colors">
                        Xóa Bộ Lọc
                    </a>
                    @endif
                </div>
            </div>

            {{-- Products Grid --}}
            <div class="lg:col-span-3">
                @if ($products->count() === 0)
                    <div class="col-span-full text-center py-20">
                        <div class="text-6xl mb-4">🔍</div>
                        <h3 class="text-xl font-bold text-cyber-text mb-2">Không tìm thấy sản phẩm</h3>
                        <p class="text-cyber-muted mb-6">Hãy thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                        <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-cyber-accent text-cyber-darker font-bold rounded-lg hover:shadow-[0_0_20px_rgba(0,255,255,0.5)] transition-all">
                            Xem Tất Cả Sản Phẩm
                        </a>
                    </div>
                @else
                    {{-- Product Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($products as $product)
                        <a href="{{ route('products.show', $product->slug) }}" 
                           class="group bg-cyber-card border border-cyber-border rounded-lg overflow-hidden hover:border-cyber-accent hover:shadow-[0_0_20px_rgba(0,255,255,0.3)] transition-all">
                            {{-- Product Image --}}
                            <div class="relative h-56 bg-cyber-darker overflow-hidden">
                                @if($product->image)
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-cyber-muted text-4xl">📦</div>
                                @endif
                                
                                {{-- Badge --}}
                                <div class="absolute top-3 right-3 bg-cyber-accent/20 backdrop-blur px-3 py-1 rounded-full text-cyber-accent text-xs font-bold">
                                    {{ $product->category->name }}
                                </div>
                                
                                {{-- Stock Indicator --}}
                                @if($product->stock === 0)
                                <div class="absolute inset-0 bg-cyber-darker/50 flex items-center justify-center">
                                    <span class="text-cyber-error font-bold text-lg">HẾT HÀNG</span>
                                </div>
                                @endif
                            </div>

                            {{-- Product Info --}}
                            <div class="p-4 space-y-3">
                                @if($product->brand)
                                <p class="text-cyber-muted text-xs uppercase tracking-wider font-mono">{{ $product->brand }}</p>
                                @endif
                                
                                <h3 class="font-bold text-cyber-text line-clamp-2 group-hover:text-cyber-accent transition-colors">
                                    {{ $product->name }}
                                </h3>
                                
                                <div class="flex items-center justify-between pt-2 border-t border-cyber-border">
                                    <div>
                                        @if($product->sale_price)
                                        <p class="text-cyber-accent font-bold">{{ number_format($product->sale_price, 0, ',', '.') }}₫</p>
                                        <p class="text-cyber-muted text-xs line-through">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                                        @else
                                        <p class="text-cyber-accent font-bold">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                                        @endif
                                    </div>
                                    
                                    @if($product->stock > 0)
                                    <span class="text-cyber-success text-xs font-mono bg-cyber-success/10 px-2 py-1 rounded">✓</span>
                                    @else
                                    <span class="text-cyber-error text-xs font-mono bg-cyber-error/10 px-2 py-1 rounded">✗</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-12 flex justify-center">
                        <div class="flex gap-2 flex-wrap justify-center">
                            @if ($products->onFirstPage())
                                <span class="px-3 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-muted text-sm cursor-not-allowed">← Trước</span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" class="px-3 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text hover:border-cyber-accent transition-colors text-sm">← Trước</a>
                            @endif

                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @if ($page == $products->currentPage())
                                    <span class="px-3 py-2 bg-cyber-accent text-cyber-darker rounded font-bold text-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text hover:border-cyber-accent transition-colors text-sm">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" class="px-3 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text hover:border-cyber-accent transition-colors text-sm">Sau →</a>
                            @else
                                <span class="px-3 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-muted text-sm cursor-not-allowed">Sau →</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
