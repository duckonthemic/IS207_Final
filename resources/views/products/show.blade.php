@extends('layouts.app')
@section('content')
<article class="bg-white shadow rounded-lg p-6">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <img src="{{ $product->image ?? 'https://placehold.co/800x600' }}" alt="{{ $product->name }}" class="w-full rounded" />
    <div>
      <h1 class="text-2xl font-semibold">{{ $product->name }}</h1>
      <div class="mt-2 text-gray-700">{{ number_format($product->price, 0, ',', '.') }} đ</div>
      <p class="mt-4 text-gray-600">{{ $product->description }}</p>
      <form method="POST" action="{{ route('cart.add') }}" class="mt-6">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="flex items-center gap-2">
          <input type="number" name="quantity" min="1" value="1" class="w-20 border rounded-lg px-2 py-1" />
          <button class="px-4 py-2 bg-black text-white rounded-lg">Thêm vào giỏ</button>
        </div>
      </form>
    </div>
  </div>
</article>
@endsection
