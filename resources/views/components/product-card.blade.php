@props(['product'])

<div class="bg-white rounded-lg shadow hover:shadow-xl transition-shadow p-4">
    {{-- Product Image --}}
    <a href="{{ route('products.show', $product->slug) }}" class="block mb-4">
        <img 
            src="{{ $product->image ?? 'https://via.placeholder.com/300?text=' . urlencode($product->name) }}" 
            alt="{{ $product->name }}" 
            class="w-full h-48 object-cover rounded"
        >
    </a>

    {{-- Product Info --}}
    <div class="space-y-2">
        {{-- Brand --}}
        @if($product->brand)
            <p class="text-xs text-gray-500 uppercase">{{ $product->brand }}</p>
        @endif

        {{-- Name --}}
        <h3 class="font-semibold text-lg line-clamp-2">
            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-blue-600">
                {{ $product->name }}
            </a>
        </h3>

        {{-- Category --}}
        @if($product->category)
            <p class="text-sm text-gray-600">{{ $product->category->name }}</p>
        @endif

        {{-- Price --}}
        <div class="flex items-baseline gap-2">
            <p class="text-xl font-bold text-blue-600">
                {{ number_format($product->price, 0, ',', '.') }} đ
            </p>
            @if($product->sale_price && $product->sale_price < $product->price)
                <p class="text-sm text-gray-400 line-through">
                    {{ number_format($product->sale_price, 0, ',', '.') }} đ
                </p>
            @endif
        </div>

        {{-- Stock Status --}}
        <div class="flex items-center justify-between">
            @if($product->stock > 0)
                <span class="text-xs text-green-600">✓ Còn hàng ({{ $product->stock }})</span>
            @else
                <span class="text-xs text-red-600">✗ Hết hàng</span>
            @endif
        </div>

        {{-- Add to Cart Button --}}
        <button 
            type="button"
            class="w-full mt-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded transition-colors"
            @if($product->stock <= 0) disabled @endif
        >
            Thêm vào giỏ
        </button>
    </div>
</div>
