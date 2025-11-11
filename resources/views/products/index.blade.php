@extends('layouts.app')

@section('title', 'Sản phẩm - Tech Parts')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Hero --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-cyber-text mb-4">Danh sách sản phẩm</h1>
        <p class="text-cyber-muted">Tìm kiếm linh kiện máy tính chất lượng cao</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Filters (Sidebar) --}}
        <div class="lg:col-span-1">
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 sticky top-20">
                <h3 class="font-bold text-cyber-text mb-4">Bộ lọc</h3>

                {{-- Search --}}
                <div class="mb-6">
                    <label class="text-cyber-muted text-sm block mb-2">Tìm kiếm</label>
                    <form method="GET" action="{{ route('products.index') }}" class="space-y-2">
                        <input type="text" name="q" placeholder="Tên sản phẩm..." value="{{ request('q') }}" class="w-full px-3 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none">
                        <button type="submit" class="w-full px-3 py-2 bg-cyber-accent text-cyber-darker rounded font-semibold hover:shadow-glow-cyan">Tìm</button>
                    </form>
                </div>

                {{-- Categories --}}
                <div class="mb-6 border-t border-cyber-border pt-4">
                    <label class="text-cyber-muted text-sm block mb-2">Danh mục</label>
                    <div class="space-y-2">
                        @foreach($categories as $cat)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} class="rounded">
                                <span class="text-cyber-text text-sm">{{ $cat->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Price Range --}}
                <div class="border-t border-cyber-border pt-4">
                    <label class="text-cyber-muted text-sm block mb-2">Giá</label>
                    <div class="space-y-2">
                        <input type="number" name="min_price" placeholder="Từ" value="{{ request('min_price') }}" class="w-full px-3 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-text text-sm">
                        <input type="number" name="max_price" placeholder="Đến" value="{{ request('max_price') }}" class="w-full px-3 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-text text-sm">
                    </div>
                </div>
            </div>
        </div>

        {{-- Products Grid --}}
        <div class="lg:col-span-3">
            {{-- Sort Options --}}
            <div class="flex justify-between items-center mb-6">
                <p class="text-cyber-muted">{{ $products->total() }} sản phẩm</p>
                <select name="sort" onchange="window.location.href='{{ route('products.index') }}?sort=' + this.value + '&{{ http_build_query(request()->except('sort')) }}'" class="px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến cao</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến thấp</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Tên: A-Z</option>
                </select>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product) }}" class="group">
                        <div class="bg-cyber-card border border-cyber-border rounded-lg overflow-hidden hover:border-cyber-accent hover:shadow-glow-cyan transition-all h-full flex flex-col">
                            {{-- Image --}}
                            <div class="aspect-square bg-cyber-darker overflow-hidden relative">
                                @if($product->images->first())
                                    <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-cyber-muted">No image</div>
                                @endif
                                @if($product->sale_price)
                                    <div class="absolute top-2 right-2 bg-cyber-error text-cyber-darker px-2 py-1 rounded text-xs font-bold">Sale</div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-4 flex-1 flex flex-col">
                                <h3 class="font-bold text-cyber-text group-hover:text-cyber-accent transition-colors line-clamp-2 mb-2">{{ $product->name }}</h3>
                                <p class="text-cyber-muted text-sm mb-4 line-clamp-2">{{ Str::limit($product->description, 60) }}</p>
                                
                                <div class="mt-auto">
                                    <div class="flex items-baseline gap-2 mb-4">
                                        @if($product->sale_price)
                                            <span class="text-cyber-accent font-bold">{{ number_format($product->sale_price, 0, ',', '.') }}₫</span>
                                            <span class="text-cyber-muted line-through text-sm">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                        @else
                                            <span class="text-cyber-accent font-bold">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                        @endif
                                    </div>

                                    <button onclick="event.preventDefault(); document.getElementById('add-to-cart-{{ $product->id }}').submit()" class="w-full px-3 py-2 bg-cyber-accent text-cyber-darker rounded font-semibold hover:shadow-glow-cyan transition-all">
                                        Thêm vào giỏ
                                    </button>

                                    <form id="add-to-cart-{{ $product->id }}" action="{{ route('cart.add') }}" method="POST" class="hidden">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="qty" value="1">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex justify-center">
                {{ $products->links('pagination::tailwind') }}
            </div>
        </div>

    {{-- Grid sản phẩm --}}
    <section class="col-span-12 md:col-span-9">
        @if ($products->count() === 0)
            <div class="text-gray-600">Không tìm thấy sản phẩm phù hợp.</div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($products as $product)
                    <div class="bg-white rounded-lg shadow-lg p-4 flex flex-col">
                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                            <img src="{{ $product->image ?? 'https://placehold.co/600x400' }}" alt="{{ $product->name }}" class="w-full h-40 object-cover rounded" />
                            <h3 class="mt-3 font-semibold text-lg">{{ $product->name }}</h3>
                        </a>
                        <div class="mt-1 text-gray-700">{{ number_format($product->price, 0, ',', '.') }} đ</div>
                        <form method="POST" action="{{ route('cart.add') }}" class="mt-auto pt-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="flex items-center gap-2">
                                <input type="number" name="quantity" min="1" value="1" class="w-20 border rounded-lg px-2 py-1" />
                                <button class="px-4 py-2 bg-black text-white rounded-lg">Thêm vào giỏ</button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $products->links() }}</div>
        @endif
    </section>
</div>
@endsection
