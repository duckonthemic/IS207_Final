{{-- Featured Products Section --}}
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        {{-- Section Title --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-heading font-bold text-gray-900">Sản Phẩm Nổi Bật</h2>
                <p class="text-gray-600 mt-1">Những sản phẩm được yêu thích nhất</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-blue-600 font-semibold hover:text-blue-700 flex items-center gap-2">
                Xem tất cả <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        {{-- Products Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse(\App\Models\Product::orderBy('created_at', 'desc')->limit(8)->get() as $product)
                <div class="group bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100">
                    {{-- Image Container --}}
                    <div class="relative overflow-hidden bg-gray-100 h-64">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        
                        {{-- Category Badge --}}
                        <div class="absolute top-3 right-3 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $product->category->name }}
                        </div>
                        
                        {{-- Stock Badge --}}
                        <div class="absolute bottom-3 left-3">
                            @if($product->stock > 0)
                                <span class="bg-green-500 text-white px-3 py-1 rounded text-xs font-semibold flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    Còn hàng
                                </span>
                            @else
                                <span class="bg-red-500 text-white px-3 py-1 rounded text-xs font-semibold">Hết hàng</span>
                            @endif
                        </div>
                    </div>

                    {{-- Product Info --}}
                    <div class="p-4 flex flex-col">
                        {{-- Brand --}}
                        <p class="text-xs text-gray-500 uppercase font-semibold tracking-wide mb-1">
                            {{ $product->brand }}
                        </p>
                        
                        {{-- Product Name --}}
                        <h3 class="text-sm font-heading font-bold text-gray-900 mb-2 line-clamp-2 hover:text-blue-600">
                            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                        </h3>

                        {{-- Price Section --}}
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-lg font-heading font-bold text-red-600">
                                {{ number_format($product->sale_price, 0) }}đ
                            </span>
                            @if($product->price > $product->sale_price)
                                <span class="text-sm text-gray-500 line-through">
                                    {{ number_format($product->price, 0) }}đ
                                </span>
                                <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded font-semibold">
                                    -{{ round((1 - $product->sale_price / $product->price) * 100) }}%
                                </span>
                            @endif
                        </div>

                        {{-- Add to Cart Button --}}
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-2 rounded-lg hover:shadow-lg transition-all duration-300 text-sm">
                                Thêm Vào Giỏ
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-12 text-gray-500">
                    Chưa có sản phẩm
                </div>
            @endforelse
        </div>
    </div>
</section>
