@extends('layouts.app')

@section('title', 'Giao hàng - UITech')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-6xl">
        {{-- Progress Steps --}}
        <div class="mb-12">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <div class="flex items-center text-blue-600">
                        <div class="h-10 w-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg shadow-blue-500/30">1</div>
                        <span class="ml-3 font-bold text-gray-900">Giao hàng</span>
                    </div>
                    <div class="w-24 h-1 bg-gray-200 mx-4 rounded-full"></div>
                    <div class="flex items-center text-gray-400">
                        <div class="h-10 w-10 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center font-medium">2</div>
                        <span class="ml-3 font-medium">Thanh toán</span>
                    </div>
                    <div class="w-24 h-1 bg-gray-200 mx-4 rounded-full"></div>
                    <div class="flex items-center text-gray-400">
                        <div class="h-10 w-10 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center font-medium">3</div>
                        <span class="ml-3 font-medium">Xác nhận</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Shipping Address Selection --}}
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Chọn địa chỉ giao hàng</h2>

                    @if($addresses->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <p class="text-gray-500 mb-6 font-medium">Bạn chưa có địa chỉ giao hàng nào</p>
                            <a href="{{ route('addresses.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all font-bold shadow-lg hover:shadow-blue-500/30 transform hover:-translate-y-0.5">
                                Thêm địa chỉ mới
                            </a>
                        </div>
                    @else
                        <form method="POST" action="{{ route('checkout.store-shipping') }}" id="shipping-form">
                            @csrf
                            
                            <div class="space-y-4 mb-8">
                                @foreach($addresses as $address)
                                    <label class="block cursor-pointer group relative">
                                        <input type="radio" name="address_id" value="{{ $address->id }}" 
                                               class="hidden peer" 
                                               {{ ($defaultAddress && $defaultAddress->id === $address->id) || old('address_id') == $address->id ? 'checked' : '' }}
                                               required>
                                        <div class="border-2 border-gray-100 rounded-xl p-6 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50/50 hover:border-blue-200">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-3 mb-2">
                                                        <span class="font-bold text-gray-900 text-lg">{{ $address->fullname }}</span>
                                                        @if($address->is_default)
                                                            <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Mặc định</span>
                                                        @endif
                                                    </div>
                                                    <p class="text-gray-500 text-sm mb-1 font-medium">{{ $address->phone }}</p>
                                                    <p class="text-gray-600 text-sm leading-relaxed">
                                                        {{ $address->address }}
                                                        @if($address->ward), {{ $address->ward }}@endif
                                                        @if($address->district), {{ $address->district }}@endif
                                                        @if($address->city), {{ $address->city }}@endif
                                                        @if($address->postal_code) - {{ $address->postal_code }}@endif
                                                    </p>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-blue-600 peer-checked:bg-blue-600 flex items-center justify-center transition-colors">
                                                        <div class="w-2.5 h-2.5 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="absolute inset-0 border-2 border-blue-500 rounded-xl opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity"></div>
                                    </label>
                                @endforeach
                            </div>

                            @error('address_id')
                                <p class="text-red-500 text-sm mb-4 bg-red-50 p-3 rounded-lg flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror

                            <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-100">
                                <a href="{{ route('addresses.create') }}" class="px-6 py-3.5 border-2 border-gray-200 text-gray-700 rounded-xl hover:border-gray-900 hover:text-gray-900 transition-all font-bold text-center">
                                    + Thêm địa chỉ mới
                                </a>
                                <button type="submit" class="flex-1 px-6 py-3.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all font-bold shadow-lg hover:shadow-blue-500/30 transform hover:-translate-y-0.5">
                                    Tiếp tục đến thanh toán
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h3 class="font-bold text-gray-900 text-lg mb-6">Đơn hàng ({{ $cart->items->count() }} sản phẩm)</h3>
                    
                    <div class="space-y-4 mb-6 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cart->items as $item)
                            <div class="flex gap-4 group">
                                <div class="w-16 h-16 bg-gray-50 rounded-lg overflow-hidden border border-gray-100 shrink-0">
                                    @if($item->product->images->first())
                                        <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain p-1 group-hover:scale-110 transition-transform duration-500">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-gray-900 text-sm font-medium truncate mb-1">{{ $item->product->name }}</h4>
                                    <div class="flex justify-between items-center">
                                        <p class="text-gray-500 text-xs">SL: {{ $item->qty }}</p>
                                        <p class="text-blue-600 text-sm font-bold">{{ number_format($item->subtotal, 0, ',', '.') }}₫</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 pt-4 space-y-3">
                        <div class="flex justify-between text-gray-600">
                            <span>Tạm tính</span>
                            <span class="font-medium text-gray-900">{{ number_format($cart->getTotal(), 0, ',', '.') }}₫</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Phí vận chuyển</span>
                            <span class="text-green-600 text-sm font-medium bg-green-50 px-2 py-0.5 rounded">Miễn phí</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <div class="flex justify-between items-end">
                            <span class="font-bold text-gray-900">Tổng cộng</span>
                            <span class="text-2xl font-bold text-blue-600">{{ number_format($cart->getTotal(), 0, ',', '.') }}₫</span>
                        </div>
                        <p class="text-right text-xs text-gray-400 mt-1">(Đã bao gồm VAT)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
