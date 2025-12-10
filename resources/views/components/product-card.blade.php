@props(['product'])

<div
    class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col h-full relative">
    {{-- Compare Button --}}
    <button
        @click.prevent="$dispatch('toggle-compare', { id: {{ $product->id }}, name: '{{ addslashes($product->name) }}', image: '{{ $product->image_url ?? asset('images/no-image.png') }}', category: '{{ $product->category->slug }}' })"
        class="absolute top-3 right-3 z-10 bg-white/80 backdrop-blur-sm p-2 rounded-full shadow-sm hover:bg-gray-900 hover:text-white transition-all text-gray-400 opacity-0 group-hover:opacity-100"
        title="So sánh">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
            </path>
        </svg>
    </button>

    {{-- Badges --}}
    <div class="absolute top-3 left-3 z-10 flex flex-col gap-2">
        @if($product->is_new)
            <span
                class="bg-gray-900 text-white text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider">Mới</span>
        @endif
        @if($product->discount_percent > 0)
            <span
                class="bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider">-{{ $product->discount_percent }}%</span>
        @endif
    </div>

    {{-- Product Image --}}
    <div class="relative pt-[100%] overflow-hidden bg-gray-50 group-hover:bg-gray-100 transition-colors">
        <a href="{{ route('products.show', $product) }}" class="absolute inset-0">
            <img src="{{ $product->image_url ?? asset('images/no-image.png') }}" alt="{{ $product->name }}"
                class="w-full h-full object-contain p-6 transition-transform duration-500 group-hover:scale-110">
        </a>

        {{-- Quick Action Overlay --}}
        <div
            class="absolute inset-x-0 bottom-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex justify-center z-10">
            @if(request('mode') == 'build')
                <a href="{{ route('build-pc', ['add' => 1, 'type' => $product->category->slug, 'id' => $product->id]) }}"
                    class="w-full bg-gray-900 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-gray-800 hover:scale-105 transition-all transform flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Chọn linh kiện
                </a>
            @else
                <form action="{{ route('cart.add', $product) }}" method="POST" class="w-full">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit"
                        class="w-full bg-black text-white font-bold py-3 rounded-xl shadow-lg hover:bg-gray-800 hover:scale-105 transition-all transform flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Thêm vào giỏ
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Product Info --}}
    <div class="p-5 flex flex-col flex-1">
        {{-- Category & Brand --}}
        <div class="flex items-center justify-between mb-2">
            <span
                class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $product->category->name ?? 'Linh kiện' }}</span>
            @if($product->brand)
                <span class="text-xs font-bold text-gray-900 bg-gray-100 px-2 py-0.5 rounded">{{ $product->brand }}</span>
            @endif
        </div>

        {{-- Name --}}
        <h3
            class="font-bold text-gray-900 text-base leading-snug mb-2 line-clamp-2 flex-1 group-hover:text-gray-700 transition-colors">
            <a href="{{ route('products.show', $product) }}">
                {{ $product->name }}
            </a>
        </h3>

        {{-- Specs Preview (Optional) --}}
        {{-- <div class="text-xs text-gray-500 mb-4 line-clamp-2">
            {{ $product->short_description }}
        </div> --}}

        {{-- Price & Stock --}}
        <div class="mt-auto pt-4 border-t border-gray-50 flex items-end justify-between">
            <div>
                <div class="text-lg font-bold text-gray-900 group-hover:text-gray-700 transition-colors">
                    {{ number_format($product->price, 0, ',', '.') }}₫
                </div>
                @if($product->old_price)
                    <div class="text-xs text-gray-400 line-through">
                        {{ number_format($product->old_price, 0, ',', '.') }}₫
                    </div>
                @endif
            </div>

            @if($product->stock > 0)
                <div class="flex items-center gap-1 text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                    Còn hàng
                </div>
            @else
                <div class="flex items-center gap-1 text-xs font-medium text-red-600 bg-red-50 px-2 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                    Hết hàng
                </div>
            @endif
        </div>
    </div>
</div>