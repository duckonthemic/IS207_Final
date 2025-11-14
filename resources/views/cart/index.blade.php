@extends('layouts.app')
@section('content')
@extends('layouts.app')

@section('title', 'Giỏ hàng - UITech')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-cyber-text mb-2">Giỏ hàng</h1>
        <p class="text-cyber-muted">{{ $cart->items->count() }} sản phẩm</p>
    </div>

    @if($cart->items->isEmpty())
        <div class="bg-cyber-card border border-cyber-border rounded-lg p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-cyber-muted opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <p class="text-cyber-muted mb-6">Giỏ hàng của bạn trống</p>
            <a href="{{ route('products.index') }}" class="inline-block px-6 py-2 bg-cyber-accent text-cyber-darker rounded-lg hover:shadow-glow-cyan transition-all font-semibold">
                Tiếp tục mua sắm
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart->items as $item)
                    <div class="bg-cyber-card border border-cyber-border rounded-lg p-4 flex gap-4 hover:border-cyber-accent transition-colors">
                        {{-- Product Image --}}
                        <div class="w-24 h-24 bg-cyber-darker rounded-lg flex-shrink-0 overflow-hidden">
                            @if($item->product->images->first())
                                <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-cyber-muted">No image</div>
                            @endif
                        </div>

                        {{-- Product Info --}}
                        <div class="flex-1">
                            <h3 class="font-bold text-cyber-text hover:text-cyber-accent">{{ $item->product->name }}</h3>
                            <p class="text-cyber-muted text-sm mb-2">SKU: {{ $item->product->sku }}</p>
                            <p class="text-cyber-accent font-bold">{{ number_format($item->price, 0, ',', '.') }}₫</p>
                        </div>

                        {{-- Quantity & Subtotal --}}
                        <div class="text-right">
                            <div class="inline-flex items-center gap-2 mb-2">
                                <form method="POST" action="{{ route('cart.update') }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                    <input type="hidden" name="qty" value="{{ max(1, $item->qty - 1) }}">
                                    <button type="submit" class="px-2 py-1 bg-cyber-darker border border-cyber-border rounded hover:border-cyber-accent">-</button>
                                </form>
                                <span class="w-8 text-center">{{ $item->qty }}</span>
                                <form method="POST" action="{{ route('cart.update') }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                    <input type="hidden" name="qty" value="{{ $item->qty + 1 }}">
                                    <button type="submit" class="px-2 py-1 bg-cyber-darker border border-cyber-border rounded hover:border-cyber-accent">+</button>
                                </form>
                            </div>
                            <p class="text-cyber-accent font-bold">{{ number_format($item->subtotal, 0, ',', '.') }}₫</p>
                            <form method="POST" action="{{ route('cart.remove') }}" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                <button type="submit" class="text-cyber-error hover:text-cyber-error/80 text-sm">Xóa</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Cart Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 sticky top-20">
                    <h3 class="font-bold text-cyber-text mb-4">Tóm tắt đơn hàng</h3>
                    
                    <div class="space-y-3 mb-6 border-t border-cyber-border pt-4">
                        <div class="flex justify-between text-cyber-text">
                            <span>Tạm tính:</span>
                            <span>{{ number_format($cart->getTotal(), 0, ',', '.') }}₫</span>
                        </div>
                        <div class="flex justify-between text-cyber-text">
                            <span>Phí vận chuyển:</span>
                            <span>0₫</span>
                        </div>
                    </div>

                    <div class="flex justify-between font-bold text-cyber-accent text-lg mb-6 border-t border-cyber-border pt-4">
                        <span>Tổng cộng:</span>
                        <span>{{ number_format($cart->getTotal(), 0, ',', '.') }}₫</span>
                    </div>

                    <a href="{{ route('checkout.show') }}" class="w-full block text-center px-4 py-3 bg-cyber-accent text-cyber-darker rounded-lg hover:shadow-glow-cyan transition-all font-bold">
                        Tiến hành thanh toán
                    </a>

                    <a href="{{ route('products.index') }}" class="w-full block text-center px-4 py-3 mt-2 border border-cyber-accent text-cyber-accent rounded-lg hover:bg-cyber-accent/10 transition-all">
                        Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
@if (empty($items))
  <p>Giỏ hàng trống.</p>
@else
  <div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
          <th class="px-4 py-3">SL</th>
          <th class="px-4 py-3">Đơn giá</th>
          <th class="px-4 py-3">Thành tiền</th>
          <th class="px-4 py-3"></th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach ($items as $item)
          <tr>
            <td class="px-4 py-3">{{ $item['name'] }}</td>
            <td class="px-4 py-3">
              <form method="POST" action="{{ route('cart.update') }}" class="flex items-center gap-2">
                @csrf @method('PATCH')
                <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                <input type="number" name="quantity" min="0" value="{{ $item['quantity'] }}" class="w-20 border rounded-lg px-2 py-1" />
                <button class="px-3 py-1 border rounded-lg">Cập nhật</button>
              </form>
            </td>
            <td class="px-4 py-3">{{ number_format($item['price'], 0, ',', '.') }} đ</td>
            <td class="px-4 py-3">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ</td>
            <td class="px-4 py-3 text-right">
              <form method="POST" action="{{ route('cart.remove') }}" onsubmit="return confirm('Xoá sản phẩm này?');">
                @csrf @method('DELETE')
                <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                <button class="px-3 py-1 bg-red-600 text-white rounded-lg">Xoá</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="mt-4 text-right text-lg">Tổng: <strong>{{ number_format($total, 0, ',', '.') }} đ</strong></div>
@endif
@endsection
