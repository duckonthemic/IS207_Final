@extends('layouts.app')

@section('title', $product->name . ' - UITech')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        {{-- Breadcrumb --}}
        <nav class="text-xs text-gray-600 mb-6 flex items-center gap-1">
            <a href="{{ route('home') }}" class="hover:text-blue-600">Trang chủ</a>
            <span>›</span>
            <a href="{{ route('products.index') }}" class="hover:text-blue-600">{{ explode(' - ', $product->category->name)[0] ?? 'Sản phẩm' }}</a>
            <span>›</span>
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-blue-600">{{ $product->category->name }}</a>
            <span>›</span>
            <span class="text-gray-900">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- LEFT: Image Gallery --}}
            <div class="lg:col-span-2">
                {{-- Main Image --}}
                <div class="bg-white rounded-lg overflow-hidden mb-4 border border-gray-200 sticky top-24" x-data="{ showLightbox: false }">
                    <div @click="showLightbox = true" class="cursor-zoom-in">
                        <img id="mainImage" 
                            src="{{ $product->images->first()?->url ?? 'https://via.placeholder.com/600x600?text=' . urlencode($product->name) }}" 
                            alt="{{ $product->name }}" 
                            class="w-full aspect-square object-cover">
                    </div>

                    {{-- Lightbox --}}
                    <div x-show="showLightbox" 
                        @click="showLightbox = false"
                        class="fixed inset-0 bg-black bg-opacity-95 z-50 flex items-center justify-center p-4"
                        x-transition>
                        <div class="relative">
                            <button @click="showLightbox = false" 
                                class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full w-10 h-10 flex items-center justify-center hover:bg-opacity-70 z-10">
                                ✕
                            </button>
                            <img :src="document.getElementById('mainImage').src" 
                                alt="{{ $product->name }}" 
                                class="max-w-4xl max-h-[90vh] object-contain">
                        </div>
                    </div>
                </div>

                {{-- Thumbnails --}}
                @if($product->images->count() > 1)
                    <div class="grid grid-cols-5 gap-2">
                        @foreach($product->images as $image)
                            <img src="{{ $image->url }}" 
                                alt="{{ $product->name }}" 
                                class="w-full aspect-square object-cover rounded cursor-pointer border-2 border-transparent hover:border-blue-500 transition"
                                onclick="document.getElementById('mainImage').src=this.src">
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- RIGHT COLUMN: Product Info + Specs --}}
            <div class="lg:col-span-1">
                {{-- Product Title & Rating --}}
                <div class="bg-white rounded-lg p-6 mb-4 border border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-900 mb-3">{{ $product->name }}</h1>
                    
                    {{-- Rating --}}
                    @if($product->reviews_count > 0)
                        <div class="flex items-center gap-2 mb-4">
                            <div class="flex gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-lg {{ $i <= round($product->average_rating) ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-600">{{ number_format($product->average_rating, 1) }} ({{ $product->reviews_count }} đánh giá)</span>
                        </div>
                    @endif

                    {{-- SKU --}}
                    <div class="text-sm text-gray-600 mb-4">
                        <span class="text-gray-500">MSP:</span> 
                        <span class="font-mono text-gray-900">{{ $product->sku }}</span>
                    </div>

                    {{-- Pricing Section --}}
                    <div class="border-t pt-4">
                        @if($product->sale_price)
                            <div class="flex items-baseline gap-2 mb-2">
                                <span class="text-4xl font-bold text-blue-600">{{ number_format($product->sale_price, 0, ',', '.') }}₫</span>
                                <span class="text-xl text-gray-400 line-through">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                <span class="inline-block px-2 py-1 bg-red-500 text-white text-sm font-bold rounded">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</span>
                            </div>
                            <div class="text-sm text-red-600 mb-4">
                                Tiết kiệm {{ number_format($product->price - $product->sale_price, 0, ',', '.') }}₫
                            </div>
                        @else
                            <div class="text-4xl font-bold text-blue-600 mb-4">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                        @endif

                        {{-- Warranty & Benefits --}}
                        <div class="bg-blue-50 rounded p-3 mb-4 text-xs">
                            <div class="flex items-start gap-2 mb-2">
                                <span class="text-green-600 font-bold">✓</span>
                                <span class="text-gray-700">Bảo hành chính hãng 36 tháng</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="text-green-600 font-bold">✓</span>
                                <span class="text-gray-700">Hỗ trợ 0% trả trước, 0 đ chứ góp</span>
                            </div>
                        </div>

                        {{-- Stock Status --}}
                        <div class="mb-4">
                            <div class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded text-sm font-semibold">
                                ✓ Còn hàng
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Add to Cart Section --}}
                <div class="bg-white rounded-lg p-6 mb-4 border border-gray-200">
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4">
                            @csrf
                            
                            {{-- Quantity --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Số lượng</label>
                                <div class="flex items-center border border-gray-300 rounded-lg w-fit">
                                    <button type="button" onclick="decrementQty()" class="px-3 py-2 text-gray-600 hover:bg-gray-100">−</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                        class="w-12 text-center border-x border-gray-300 focus:outline-none">
                                    <button type="button" onclick="incrementQty()" class="px-3 py-2 text-gray-600 hover:bg-gray-100">+</button>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">Tối đa: {{ $product->stock }} sản phẩm</div>
                            </div>

                            {{-- Buttons --}}
                            <div class="space-y-2">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition">
                                    Thêm Vào Giỏ Hàng
                                </button>
                                <button type="button" class="w-full border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-bold py-2 rounded-lg transition">
                                    Mua Ngay
                                </button>
                            </div>
                        </form>

                        {{-- Build PC Button --}}
                        <button class="w-full mt-4 border-2 border-purple-600 text-purple-600 hover:bg-purple-50 font-bold py-2 rounded-lg transition flex items-center justify-center gap-2">
                            <span>🛠️</span>
                            Build PC với sản phẩm này
                        </button>
                    @else
                        <div class="bg-red-100 text-red-800 p-4 rounded text-center">
                            Hết hàng
                        </div>
                    @endif
                </div>

                {{-- Seller Info --}}
                <div class="bg-white rounded-lg p-6 border border-gray-200">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                            U
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">UITech Store</div>
                            <div class="text-sm text-gray-500">Gửi 1 dình kèm</div>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between text-gray-700">
                            <span>Hỗ trợ trả góp 0%</span>
                            <span class="text-green-600">✓</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Hoàn tiền 200% nếu có hàng giả</span>
                            <span class="text-green-600">✓</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Giao hàng miễn phí toàn quốc</span>
                            <span class="text-green-600">✓</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Hỗ trợ kĩ thuật online 24/7</span>
                            <span class="text-green-600">✓</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom: Specs, Reviews, Related --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-12">
            {{-- Specs Section --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg p-6 border border-gray-200 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 border-b pb-3">THÔNG SỐ KỸ THUẬT</h2>
                    
                    @php
                        // Parse specs from description or attributes
                        $specs = [];
                        
                        // Try to parse description text for specs
                        if ($product->description) {
                            $desc = $product->description;
                            
                            // Common patterns for PC components
                            if (preg_match('/(\d+)\s*(cores?|nhân)/i', $desc, $m)) {
                                $specs['Số nhân'] = $m[1] . ' cores';
                            }
                            if (preg_match('/(\d+)\s*(threads?|luồng)/i', $desc, $m)) {
                                $specs['Số luồng'] = $m[1] . ' threads';
                            }
                            if (preg_match('/(\d+\.?\d*)\s*GHz/i', $desc, $m)) {
                                $specs['Xung nhịp'] = $m[1] . ' GHz';
                            }
                            if (preg_match('/(\d+)\s*GB\s*(DDR\d+|GDDR\d+)?/i', $desc, $m)) {
                                $specs['Bộ nhớ'] = $m[1] . ' GB' . (isset($m[2]) ? ' ' . $m[2] : '');
                            }
                            if (preg_match('/(\d+)\s*MB\s*Cache/i', $desc, $m)) {
                                $specs['Cache'] = $m[1] . ' MB';
                            }
                            if (preg_match('/PCIe?\s*(\d+\.?\d*)/i', $desc, $m)) {
                                $specs['Chuẩn kết nối'] = 'PCIe ' . $m[1];
                            }
                            if (preg_match('/(\d+)W\s*TDP/i', $desc, $m)) {
                                $specs['TDP'] = $m[1] . 'W';
                            }
                            if (preg_match('/Socket\s*([A-Z0-9]+)/i', $desc, $m)) {
                                $specs['Socket'] = $m[1];
                            }
                        }
                        
                        // Add category and brand
                        $specs['Danh mục'] = $product->category->name;
                        if ($product->brand_id) {
                            $specs['Thương hiệu'] = 'Brand #' . $product->brand_id;
                        }
                        
                        // If no specs found, show generic info
                        if (count($specs) <= 2) {
                            $specs = [
                                'Danh mục' => $product->category->name,
                                'SKU' => $product->sku,
                                'Tình trạng' => $product->is_active ? 'Còn hàng' : 'Hết hàng',
                                'Tồn kho' => $product->stock . ' sản phẩm',
                                'Giá gốc' => number_format($product->price) . '₫',
                            ];
                            if ($product->sale_price) {
                                $specs['Giá khuyến mãi'] = number_format($product->sale_price) . '₫';
                            }
                        }
                    @endphp
                    
                    @if(count($specs) > 0)
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($specs as $label => $value)
                                <div class="border-b pb-3">
                                    <div class="text-sm text-gray-600">{{ $label }}</div>
                                    <div class="font-semibold text-gray-900">{{ $value }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Thông số kỹ thuật đang được cập nhật</p>
                    @endif
                </div>

                {{-- Description Section --}}
                <div class="bg-white rounded-lg p-6 border border-gray-200 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-3">MÔ TẢ SẢN PHẨM</h2>
                    <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                        {{ $product->description }}
                    </div>
                </div>

                {{-- Reviews Section --}}
                <div class="bg-white rounded-lg p-6 border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 border-b pb-3">ĐÁNH GIÁ SẢN PHẨM</h2>

                    {{-- Rating Summary --}}
                    @if($product->reviews_count > 0)
                        <div class="grid grid-cols-2 gap-8 mb-8 pb-8 border-b">
                            <div class="text-center">
                                <div class="text-5xl font-bold text-yellow-500">{{ number_format($product->average_rating, 1) }}</div>
                                <div class="flex justify-center gap-0.5 my-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-2xl {{ $i <= round($product->average_rating) ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                    @endfor
                                </div>
                                <div class="text-sm text-gray-600">{{ $product->reviews_count }} đánh giá</div>
                            </div>
                            <div class="space-y-2">
                                @php
                                    $ratingCounts = [5 => 1, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                                    $totalReviews = max($product->reviews_count, 1);
                                @endphp
                                @for($rating = 5; $rating >= 1; $rating--)
                                    @php
                                        $count = $product->approvedReviews->where('rating', $rating)->count();
                                        $percentage = ($count / $totalReviews) * 100;
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-gray-600 w-8">{{ $rating }}★</span>
                                        <div class="h-2 bg-gray-200 rounded flex-1">
                                            <div class="h-full bg-yellow-400 rounded" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-sm text-gray-600 w-8">{{ $count }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    @endif

                    {{-- Review Form --}}
                    @auth
                        @if($canReview)
                            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                                <h3 class="font-bold text-gray-900 mb-4">Viết đánh giá của bạn</h3>
                                <form action="{{ route('reviews.store', $product) }}" method="POST">
                                    @csrf
                                    
                                    {{-- Rating --}}
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Đánh giá <span class="text-red-500">*</span></label>
                                        <div class="flex gap-1" x-data="{ rating: 5, hover: 0 }">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button" 
                                                    @click="rating = {{ $i }}" 
                                                    @mouseenter="hover = {{ $i }}"
                                                    @mouseleave="hover = 0"
                                                    class="text-3xl transition-colors"
                                                    :class="(hover >= {{ $i }} || rating >= {{ $i }}) ? 'text-yellow-400' : 'text-gray-300'">
                                                    ★
                                                </button>
                                            @endfor
                                            <input type="hidden" name="rating" :value="rating">
                                        </div>
                                    </div>

                                    {{-- Comment --}}
                                    <div class="mb-4">
                                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Nhận xét (tùy chọn)</label>
                                        <textarea name="comment" id="comment" rows="3" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Chia sẻ trải nghiệm của bạn...">{{ old('comment') }}</textarea>
                                    </div>

                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                                        Gửi đánh giá
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth

                    {{-- Reviews List --}}
                    <div class="space-y-6">
                        @if($product->approvedReviews->isNotEmpty())
                            @foreach($product->approvedReviews->take(5) as $review)
                                <div class="border-b pb-6">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $review->user->name }}</h4>
                                            <div class="flex items-center gap-2 mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="text-sm {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                                @endfor
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $review->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    @if($review->comment)
                                        <p class="text-gray-700 text-sm mt-2">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-12 text-gray-500">
                                <p>Chưa có đánh giá nào</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Sidebar: Related Products / News --}}
            <div>
                {{-- News/Blog Section --}}
                <div class="bg-white rounded-lg p-6 border border-gray-200 mb-8">
                    <h3 class="text-sm font-bold text-gray-900 mb-4 border-b pb-2">TIN TỨC LIÊN QUAN</h3>
                    <div class="space-y-4 text-xs">
                        <a href="#" class="block hover:text-blue-600 group">
                            <div class="text-gray-600 group-hover:text-gray-900 font-semibold line-clamp-2">RX 9060 XT vs RTX 5060 Ti: Cuộc Đối Đầu VGA Tầm Trung 2025</div>
                            <div class="text-gray-500 mt-1">07-06-2025, 10:19 am</div>
                        </a>
                        <a href="#" class="block hover:text-blue-600 group">
                            <div class="text-gray-600 group-hover:text-gray-900 font-semibold line-clamp-2">NVIDIA Computex 2025: Bước Phát Với Kỷ Nguyên AI Mới</div>
                            <div class="text-gray-500 mt-1">21-05-2025, 4:29 pm</div>
                        </a>
                        <a href="#" class="block hover:text-blue-600 group">
                            <div class="text-gray-600 group-hover:text-gray-900 font-semibold line-clamp-2">RTX 5080 VS RTX 4090: So Sánh Hiệu Năng Thực Tế</div>
                            <div class="text-gray-500 mt-1">03-05-2025, 3:13 pm</div>
                        </a>
                    </div>
                    <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-semibold mt-4 inline-block">
                        Xem tất cả →
                    </a>
                </div>

                {{-- Build PC Section --}}
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-6 text-white">
                    <h3 class="font-bold mb-3">Build PC Với Sản Phẩm Này</h3>
                    <p class="text-sm text-purple-100 mb-4">Xây dựng cấu hình PC gaming hoàn chỉnh với sản phẩm này</p>
                    <button class="w-full bg-white text-purple-600 hover:bg-purple-50 font-bold py-2 rounded-lg transition">
                        Bắt Đầu Build
                    </button>
                </div>
            </div>
        </div>

        {{-- Related Products Section --}}
        @if($relatedProducts->isNotEmpty())
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">SẢN PHẨM TƯƠNG TỰ</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts->take(4) as $related)
                        <a href="{{ route('products.show', $related) }}" class="group">
                            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:border-blue-400 hover:shadow-lg transition-all">
                                <div class="aspect-square bg-gray-100 overflow-hidden relative">
                                    @if($related->images->first())
                                        <img src="{{ $related->images->first()->url }}" 
                                            alt="{{ $related->name }}" 
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">No image</div>
                                    @endif
                                    @if($related->sale_price)
                                        <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-bold">
                                            -{{ round((($related->price - $related->sale_price) / $related->price) * 100) }}%
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 line-clamp-2 text-sm mb-2">{{ $related->name }}</h3>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-lg font-bold text-blue-600">{{ number_format($related->sale_price ?? $related->price, 0, ',', '.') }}₫</span>
                                        @if($related->sale_price)
                                            <span class="text-sm text-gray-400 line-through">{{ number_format($related->price, 0, ',', '.') }}₫</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function incrementQty() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

function decrementQty() {
    const input = document.getElementById('quantity');
    const min = parseInt(input.min);
    const current = parseInt(input.value);
    if (current > min) {
        input.value = current - 1;
    }
}
</script>
@endsection
