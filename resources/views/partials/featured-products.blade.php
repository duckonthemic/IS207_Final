{{-- Featured Products Section --}}
<section class="py-12 bg-cyber-black border-t border-cyber-border">
    <div class="container mx-auto px-4">
        {{-- Section Title --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-black text-cyber-white uppercase tracking-tighter">Sản Phẩm Nổi Bật</h2>
                <p class="text-cyber-text-muted font-mono text-sm mt-1">// TOP_RATED_ITEMS</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-cyber-white font-bold hover:text-cyber-text-muted flex items-center gap-2 uppercase tracking-wider text-sm transition-colors">
                Xem tất cả <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        {{-- Products Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse(\App\Models\Product::orderBy('created_at', 'desc')->limit(8)->get() as $product)
                <div class="group bg-cyber-gray border border-cyber-border hover:border-cyber-white transition-all duration-300 flex flex-col h-full">
                    {{-- Image Container --}}
                    <div class="relative overflow-hidden bg-white h-64 p-4">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" 
                             class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300">
                        
                        {{-- Category Badge --}}
                        <div class="absolute top-3 right-3 bg-cyber-black text-cyber-white border border-cyber-border px-2 py-1 text-xs font-bold uppercase tracking-wider">
                            {{ $product->category->name }}
                        </div>
                        
                        {{-- Stock Badge --}}
                        <div class="absolute bottom-3 left-3">
                            @if($product->stock > 0)
                                <span class="bg-cyber-white text-cyber-black px-2 py-1 text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                    In Stock
                                </span>
                            @else
                                <span class="bg-cyber-gray text-cyber-text-muted border border-cyber-border px-2 py-1 text-xs font-bold uppercase tracking-wider">Out of Stock</span>
                            @endif
                        </div>
                    </div>

                    {{-- Product Info --}}
                    <div class="p-4 flex flex-col flex-1">
                        {{-- Brand --}}
                        <p class="text-xs text-cyber-text-muted uppercase font-bold tracking-wide mb-1">
                            {{ $product->brand }}
                        </p>
                        
                        {{-- Product Name --}}
                        <h3 class="text-sm font-bold text-cyber-text mb-2 line-clamp-2 group-hover:text-cyber-white transition-colors uppercase tracking-wide min-h-[40px]">
                            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                        </h3>

                        {{-- Price Section --}}
                        <div class="flex flex-col gap-1 mb-4 mt-auto">
                            <span class="text-lg font-black text-cyber-white font-mono">
                                {{ number_format($product->sale_price, 0, ',', '.') }}₫
                            </span>
                            @if($product->price > $product->sale_price)
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-cyber-text-muted line-through font-mono">
                                        {{ number_format($product->price, 0, ',', '.') }}₫
                                    </span>
                                    <span class="text-xs bg-cyber-white text-cyber-black px-1 font-bold uppercase">
                                        -{{ round((1 - $product->sale_price / $product->price) * 100) }}%
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Add to Cart Button --}}
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full bg-cyber-white text-cyber-black font-bold py-2 hover:bg-gray-800 transition-all uppercase tracking-widest text-xs flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Thêm Vào Giỏ
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-12 text-cyber-text-muted border border-cyber-border border-dashed">
                    <p class="uppercase tracking-widest text-sm">Chưa có sản phẩm</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
