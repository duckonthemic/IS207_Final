@extends('layouts.app')

@section('title', 'Thanh toán - UITech')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        <form action="{{ route('checkout.place-order') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @csrf
            
            {{-- Left Column: Shipping & Payment --}}
            <div class="lg:col-span-7 space-y-8">
                
                {{-- Shipping Info --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Thông tin giao hàng</h2>
                        @guest
                            <div class="text-sm text-gray-600">
                                Bạn đã có tài khoản? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Đăng nhập</a>
                            </div>
                        @endguest
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 gap-4">
                            <input type="text" name="fullname" placeholder="Họ và tên" 
                                   value="{{ old('fullname', $defaultAddress->recipient_name ?? Auth::user()->name ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="email" name="email" placeholder="Email" 
                                       value="{{ old('email', Auth::user()->email ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                                
                                <input type="tel" name="phone" placeholder="Số điện thoại" 
                                       value="{{ old('phone', $defaultAddress->phone ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <input type="text" name="address" placeholder="Địa chỉ chi tiết (số nhà, tên đường)" 
                                   value="{{ old('address', '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <select name="city" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Chọn tỉnh / thành</option>
                                    <option value="Hồ Chí Minh" {{ old('city') == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                                    <option value="Hà Nội" {{ old('city') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                                    <option value="Đà Nẵng" {{ old('city') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                                </select>

                                <select name="district" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Chọn quận / huyện</option>
                                    <option value="Quận 1" {{ old('district') == 'Quận 1' ? 'selected' : '' }}>Quận 1</option>
                                    <option value="Thủ Đức" {{ old('district') == 'Thủ Đức' ? 'selected' : '' }}>Thủ Đức</option>
                                </select>

                                <select name="ward" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Chọn phường / xã</option>
                                    <option value="Linh Trung" {{ (old('ward', $defaultAddress->ward ?? '') == 'Linh Trung') ? 'selected' : '' }}>Linh Trung</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Shipping Method --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Phương thức vận chuyển</h2>
                    
                    <div class="border border-gray-200 rounded-lg p-8 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 text-gray-300">
                            <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <p class="text-gray-500">Vui lòng chọn tỉnh / thành để có danh sách phương thức vận chuyển.</p>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Phương thức thanh toán</h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="payment_method" value="cod" class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500" checked>
                            <div class="ml-4 flex items-center gap-3">
                                <div class="w-8 h-8 flex items-center justify-center bg-yellow-100 rounded">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <span class="font-medium text-gray-900">Thanh toán khi giao hàng (COD)</span>
                            </div>
                        </label>
                        
                        <div class="p-4 bg-gray-50 rounded-lg text-sm text-gray-600 ml-9 mb-4">
                            Lưu ý: Vui lòng liên hệ nhân viên hỗ trợ kiểm tra tồn kho sản phẩm trước khi thanh toán!
                        </div>

                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="payment_method" value="bank_transfer" class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <div class="ml-4 flex items-center gap-3">
                                <div class="w-8 h-8 flex items-center justify-center bg-blue-100 rounded">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                </div>
                                <span class="font-medium text-gray-900">Chuyển khoản qua ngân hàng</span>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="payment_method" value="atm" class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <div class="ml-4 flex items-center gap-3">
                                <span class="font-medium text-gray-900">Thanh toán bằng thẻ ATM/Visa/Master/JCB/Amex/QR Code</span>
                                <div class="flex gap-1">
                                    <span class="px-1 py-0.5 bg-blue-800 text-white text-xs rounded">Payoo</span>
                                    <span class="px-1 py-0.5 bg-blue-600 text-white text-xs rounded">VISA</span>
                                </div>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="payment_method" value="fundiin" class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <div class="ml-4 flex items-center gap-3">
                                <span class="font-medium text-gray-900">Fundiin - Mua trả sau 0% lãi</span>
                                <span class="px-2 py-0.5 bg-orange-500 text-white text-xs font-bold rounded">Giảm đến 50K</span>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" name="payment_method" value="payoo" class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <div class="ml-4 flex items-center gap-3">
                                <span class="px-1 py-0.5 bg-blue-800 text-white text-xs rounded">Payoo</span>
                                <span class="font-medium text-gray-900">Trả góp qua ví Payoo</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Right Column: Order Summary --}}
            <div class="lg:col-span-5">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                    {{-- Product List --}}
                    <div class="space-y-4 mb-6 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cart->items as $item)
                            <div class="flex gap-4">
                                <div class="w-16 h-16 bg-gray-50 rounded border border-gray-200 shrink-0 relative">
                                    @if($item->product->images->first())
                                        <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain p-1">
                                    @endif
                                    <span class="absolute -top-2 -right-2 w-5 h-5 bg-gray-500 text-white text-xs rounded-full flex items-center justify-center">{{ $item->qty }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-gray-900 text-sm font-medium line-clamp-2">{{ $item->product->name }}</h4>
                                    <p class="text-gray-500 text-xs mt-1">{{ $item->product->specs->where('spec_definition.code', 'color')->first()?->value ?? '' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-900 text-sm font-medium">{{ number_format($item->subtotal, 0, ',', '.') }}₫</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Discount Code --}}
                    <div class="flex gap-2 mb-6">
                        <input type="text" placeholder="Mã giảm giá" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" class="px-4 py-2 bg-gray-200 text-gray-500 rounded-md font-medium cursor-not-allowed" disabled>Sử dụng</button>
                    </div>

                    {{-- Loyalty Program --}}
                    <div class="flex justify-between items-center py-4 border-t border-gray-100 mb-4">
                        <span class="text-gray-600">Chương trình khách hàng thân thiết</span>
                        @guest
                            <a href="{{ route('login') }}" class="px-4 py-1.5 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">Đăng nhập</a>
                        @else
                            <span class="text-blue-600 font-medium">{{ Auth::user()->name }}</span>
                        @endguest
                    </div>

                    {{-- Totals --}}
                    <div class="space-y-3 border-t border-gray-100 pt-4">
                        <div class="flex justify-between text-gray-600">
                            <span>Tạm tính</span>
                            <span class="font-medium text-gray-900">{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Giao hàng tận nơi (Báo phí sau)</span>
                            <span class="font-medium text-gray-900">—</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center border-t border-gray-100 pt-4 mt-4 mb-6">
                        <span class="text-lg font-medium text-gray-900">Tổng cộng</span>
                        <div class="text-right">
                            <span class="text-xs text-gray-500 mr-1">VND</span>
                            <span class="text-2xl font-bold text-gray-900">{{ number_format($total, 0, ',', '.') }}₫</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('cart.index') }}" class="text-blue-600 hover:underline text-sm">Giỏ hàng</a>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded hover:bg-blue-700 transition-colors">
                            Hoàn tất đơn hàng
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
