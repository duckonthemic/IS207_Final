@extends('layouts.app')

@section('title', $product->name . ' - Tech Parts')

@section('content')
<div class="container mx-auto px-4 py-8">
    <nav class="text-sm text-cyber-muted mb-8">
        <a href="{{ route('products.index') }}" class="hover:text-cyber-accent">Sản phẩm</a>
        <span class="mx-2">/</span>
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-cyber-accent">{{ $product->category->name }}</a>
        <span class="mx-2">/</span>
        <span>{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        {{-- Gallery --}}
        <div>
            <div class="bg-cyber-darker rounded-lg overflow-hidden mb-4">
                <img id="mainImage" src="{{ $product->images->first()?->url ?? 'https://via.placeholder.com/500x500' }}" alt="{{ $product->name }}" class="w-full aspect-square object-cover">
            </div>
            @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-2">
                    @foreach($product->images as $image)
                        <img src="{{ $image->url }}" alt="{{ $product->name }}" class="w-full aspect-square object-cover rounded cursor-pointer border border-cyber-border hover:border-cyber-accent" onclick="document.getElementById('mainImage').src=this.src">
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div>
            <h1 class="text-3xl font-bold text-cyber-text mb-4">{{ $product->name }}</h1>

            {{-- Price --}}
            <div class="mb-6">
                @if($product->sale_price)
                    <div class="flex items-center gap-4 mb-2">
                        <span class="text-3xl font-bold text-cyber-accent">{{ number_format($product->sale_price, 0, ',', '.') }}₫</span>
                        <span class="text-lg text-cyber-muted line-through">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                    </div>
                    <div class="inline-block px-3 py-1 bg-cyber-error text-cyber-darker text-sm font-bold rounded">
                        Tiết kiệm {{ number_format($product->price - $product->sale_price, 0, ',', '.') }}₫
                    </div>
                @else
                    <span class="text-3xl font-bold text-cyber-accent">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                @endif
            </div>

            {{-- SKU & Availability --}}
            <div class="grid grid-cols-2 gap-4 mb-8 pb-8 border-b border-cyber-border">
                <div>
                    <p class="text-cyber-muted text-sm">SKU</p>
                    <p class="text-cyber-text font-semibold">{{ $product->sku }}</p>
                </div>
                <div>
                    <p class="text-cyber-muted text-sm">Tình trạng</p>
                    <p class="text-cyber-accent font-semibold">Còn hàng</p>
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-8">
                <h3 class="font-bold text-cyber-text mb-3">Mô tả sản phẩm</h3>
                <p class="text-cyber-muted leading-relaxed">{{ $product->description }}</p>
            </div>

            {{-- Specs --}}
            @if($product->specs->isNotEmpty())
                <div class="mb-8">
                    <h3 class="font-bold text-cyber-text mb-3">Thông số kỹ thuật</h3>
                    <table class="w-full text-sm">
                        @foreach($product->specs as $spec)
                            <tr class="border-b border-cyber-border">
                                <td class="py-2 text-cyber-muted w-1/3">{{ $spec->spec_key }}</td>
                                <td class="py-2 text-cyber-text">{{ $spec->spec_value }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif

            {{-- Add to Cart --}}
            <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div>
                    <label class="block text-cyber-text font-semibold mb-2">Số lượng</label>
                    <div class="flex items-center gap-4">
                        <div class="inline-flex items-center gap-2 border border-cyber-border rounded">
                            <button type="button" onclick="document.getElementById('qty').value = Math.max(1, parseInt(document.getElementById('qty').value) - 1)" class="px-3 py-2">-</button>
                            <input type="number" id="qty" name="qty" value="1" min="1" max="100" class="w-16 text-center bg-transparent outline-none">
                            <button type="button" onclick="document.getElementById('qty').value = parseInt(document.getElementById('qty').value) + 1" class="px-3 py-2">+</button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button type="submit" class="px-6 py-3 bg-cyber-accent text-cyber-darker rounded-lg font-bold hover:shadow-glow-cyan transition-all">
                        Thêm vào giỏ
                    </button>
                    <button type="button" class="px-6 py-3 border border-cyber-accent text-cyber-accent rounded-lg font-bold hover:bg-cyber-accent/10">
                        Yêu thích
                    </button>
                </div>
            </form>

            {{-- Share --}}
            <div class="mt-8 pt-8 border-t border-cyber-border">
                <p class="text-cyber-muted text-sm mb-3">Chia sẻ:</p>
                <div class="flex gap-2">
                    <a href="#" class="p-2 bg-cyber-card border border-cyber-border rounded hover:border-cyber-accent">
                        <span class="text-cyber-text">f</span>
                    </a>
                    <a href="#" class="p-2 bg-cyber-card border border-cyber-border rounded hover:border-cyber-accent">
                        <span class="text-cyber-text">𝕏</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($relatedProducts->isNotEmpty())
        <div class="mt-16 pt-16 border-t border-cyber-border">
            <h2 class="text-2xl font-bold text-cyber-text mb-8">Sản phẩm liên quan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts->take(4) as $related)
                    <a href="{{ route('products.show', $related) }}" class="group">
                        <div class="bg-cyber-card border border-cyber-border rounded-lg overflow-hidden hover:border-cyber-accent hover:shadow-glow-cyan transition-all">
                            <div class="aspect-square bg-cyber-darker overflow-hidden">
                                @if($related->images->first())
                                    <img src="{{ $related->images->first()->url }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-cyber-muted">No image</div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-cyber-text group-hover:text-cyber-accent line-clamp-2 mb-2">{{ $related->name }}</h3>
                                <p class="text-cyber-accent font-bold">{{ number_format($related->sale_price ?? $related->price, 0, ',', '.') }}₫</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
