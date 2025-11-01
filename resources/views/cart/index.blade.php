@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Giỏ hàng</h1>
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
