@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-6">
    {{-- Sidebar lọc --}}
    <aside class="col-span-12 md:col-span-3">
        <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Tìm kiếm</label>
                <input type="text" name="q" value="{{ request('q') }}" class="w-full border rounded-lg px-3 py-2" placeholder="Tên sản phẩm..." />
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Phân loại</label>
                <select name="category" class="w-full border rounded-lg px-3 py-2">
                    <option value="">Tất cả</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->slug }}" @selected(request('category')===$cat->slug)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <input type="number" min="0" step="10000" name="min_price" value="{{ request('min_price') }}" placeholder="Giá từ" class="border rounded-lg px-3 py-2" />
                <input type="number" min="0" step="10000" name="max_price" value="{{ request('max_price') }}" placeholder="Đến" class="border rounded-lg px-3 py-2" />
            </div>
            <div class="flex items-center gap-2">
                <button class="px-4 py-2 bg-black text-white rounded-lg">Lọc</button>
                <a href="{{ route('products.index') }}" class="px-4 py-2 border rounded-lg">Reset</a>
            </div>
        </form>
    </aside>

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
