@extends('layouts.app')

@section('title', 'Thanh toán - UITech')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8" x-data="checkoutPage()">
        <div class="container mx-auto px-4 max-w-6xl">
            <form action="{{ route('checkout.place-order') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8"
                @submit="handleSubmit">
                @csrf

                {{-- Left Column: Shipping & Payment --}}
                <div class="lg:col-span-7 space-y-8">

                    {{-- Shipping Info --}}
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                <span
                                    class="w-8 h-8 bg-gray-900 text-white rounded-lg flex items-center justify-center text-sm font-bold">1</span>
                                Thông tin giao hàng
                            </h2>
                            @guest
                                <div class="text-sm text-gray-600">
                                    Bạn đã có tài khoản? <a href="{{ route('login') }}"
                                        class="text-blue-600 hover:underline font-medium">Đăng nhập</a>
                                </div>
                            @endguest
                        </div>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 gap-4">
                                <input type="text" name="fullname" placeholder="Họ và tên *"
                                    value="{{ old('fullname', $defaultAddress->recipient_name ?? Auth::user()->name ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    required>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <input type="email" name="email" placeholder="Email *"
                                        value="{{ old('email', Auth::user()->email ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        required>

                                    <input type="tel" name="phone" placeholder="Số điện thoại *"
                                        value="{{ old('phone', $defaultAddress->phone ?? '') }}"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        required>
                                </div>

                                <input type="text" name="address" placeholder="Địa chỉ chi tiết (số nhà, tên đường) *"
                                    value="{{ old('address', '') }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    required>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <select name="city" x-model="selectedCity" @change="loadShippingMethods()"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-white"
                                        required>
                                        <option value="">Chọn tỉnh / thành *</option>
                                        <option value="Hồ Chí Minh">Hồ Chí Minh</option>
                                        <option value="Hà Nội">Hà Nội</option>
                                        <option value="Đà Nẵng">Đà Nẵng</option>
                                        <option value="Cần Thơ">Cần Thơ</option>
                                        <option value="Hải Phòng">Hải Phòng</option>
                                        <option value="Bình Dương">Bình Dương</option>
                                        <option value="Đồng Nai">Đồng Nai</option>
                                        <option value="Khác">Tỉnh khác</option>
                                    </select>

                                    <select name="district"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-white"
                                        required>
                                        <option value="">Chọn quận / huyện *</option>
                                        <option value="Quận 1">Quận 1</option>
                                        <option value="Quận 3">Quận 3</option>
                                        <option value="Quận 7">Quận 7</option>
                                        <option value="Thủ Đức">Thủ Đức</option>
                                        <option value="Bình Thạnh">Bình Thạnh</option>
                                        <option value="Tân Bình">Tân Bình</option>
                                        <option value="Gò Vấp">Gò Vấp</option>
                                    </select>

                                    <select name="ward"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-white">
                                        <option value="">Chọn phường / xã</option>
                                        <option value="Linh Trung">Linh Trung</option>
                                        <option value="Linh Chiểu">Linh Chiểu</option>
                                        <option value="Hiệp Bình Chánh">Hiệp Bình Chánh</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Method --}}
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <span
                                class="w-8 h-8 bg-gray-900 text-white rounded-lg flex items-center justify-center text-sm font-bold">2</span>
                            Phương thức vận chuyển
                        </h2>

                        <template x-if="!selectedCity">
                            <div class="border border-gray-200 rounded-xl p-8 text-center bg-gray-50">
                                <div class="w-16 h-16 mx-auto mb-4 text-gray-300">
                                    <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-500">Vui lòng chọn tỉnh / thành để xem phương thức vận chuyển</p>
                            </div>
                        </template>

                        <template x-if="selectedCity && shippingMethods.length > 0">
                            <div class="space-y-3">
                                {{-- Free shipping banner --}}
                                <template x-if="freeShipping">
                                    <div
                                        class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 mb-4">
                                        <div
                                            class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-green-800">Miễn phí vận chuyển!</p>
                                            <p class="text-sm text-green-600">Đơn hàng của bạn đủ điều kiện miễn phí ship
                                            </p>
                                        </div>
                                    </div>
                                </template>

                                <template x-for="method in shippingMethods" :key="method.id">
                                    <label class="flex items-center p-4 border rounded-xl cursor-pointer transition-all"
                                        :class="selectedShipping === method.id ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'">
                                        <input type="radio" name="shipping_method" :value="method.id"
                                            x-model="selectedShipping" @change="updateShipping()"
                                            class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <div class="ml-4 flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-medium text-gray-900" x-text="method.name"></span>
                                                <span class="font-bold"
                                                    :class="freeShipping ? 'text-green-600' : 'text-gray-900'"
                                                    x-text="method.formatted_fee"></span>
                                            </div>
                                            <p class="text-sm text-gray-500 mt-1" x-text="method.description"></p>
                                        </div>
                                    </label>
                                </template>
                            </div>
                        </template>

                        <template x-if="shippingLoading">
                            <div class="flex items-center justify-center py-8">
                                <svg class="animate-spin h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                            </div>
                        </template>
                    </div>

                    {{-- Payment Method --}}
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <span
                                class="w-8 h-8 bg-gray-900 text-white rounded-lg flex items-center justify-center text-sm font-bold">3</span>
                            Phương thức thanh toán
                        </h2>

                        <div class="space-y-3">
                            {{-- COD --}}
                            <label class="flex items-center p-4 border rounded-xl cursor-pointer transition-all"
                                :class="selectedPayment === 'cod' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'">
                                <input type="radio" name="payment_method" value="cod" x-model="selectedPayment"
                                    class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500" checked>
                                <div class="ml-4 flex items-center gap-3">
                                    <div class="w-10 h-10 flex items-center justify-center bg-yellow-100 rounded-lg">
                                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-900 block">Thanh toán khi nhận hàng (COD)</span>
                                        <span class="text-sm text-gray-500">Kiểm tra hàng trước khi thanh toán</span>
                                    </div>
                                </div>
                            </label>

                            {{-- Bank Transfer --}}
                            <label class="flex items-center p-4 border rounded-xl cursor-pointer transition-all"
                                :class="selectedPayment === 'bank_transfer' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'">
                                <input type="radio" name="payment_method" value="bank_transfer" x-model="selectedPayment"
                                    class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <div class="ml-4 flex items-center gap-3">
                                    <div class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-lg">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-900 block">Chuyển khoản ngân hàng</span>
                                        <span class="text-sm text-gray-500">Thanh toán qua tài khoản ngân hàng</span>
                                    </div>
                                </div>
                            </label>

                            {{-- Card/QR --}}
                            <label class="flex items-center p-4 border rounded-xl cursor-pointer transition-all"
                                :class="selectedPayment === 'atm' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'">
                                <input type="radio" name="payment_method" value="atm" x-model="selectedPayment"
                                    class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-medium text-gray-900">Thẻ ATM/Visa/Master/JCB/QR Code</span>
                                        <div class="flex gap-1">
                                            <span
                                                class="px-2 py-0.5 bg-blue-800 text-white text-xs font-bold rounded">VISA</span>
                                            <span
                                                class="px-2 py-0.5 bg-red-600 text-white text-xs font-bold rounded">MC</span>
                                            <span
                                                class="px-2 py-0.5 bg-green-600 text-white text-xs font-bold rounded">JCB</span>
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-500">Thanh toán an toàn qua cổng Payoo</span>
                                </div>
                            </label>

                            {{-- Fundiin --}}
                            <label class="flex items-center p-4 border rounded-xl cursor-pointer transition-all"
                                :class="selectedPayment === 'fundiin' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'">
                                <input type="radio" name="payment_method" value="fundiin" x-model="selectedPayment"
                                    class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-900">Trả sau 0% lãi suất</span>
                                        <span
                                            class="px-2 py-0.5 bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs font-bold rounded-full">Fundiin</span>
                                        <span class="px-2 py-0.5 bg-green-500 text-white text-xs font-bold rounded">Giảm
                                            50K</span>
                                    </div>
                                    <span class="text-sm text-gray-500">Chia nhỏ thanh toán, không lãi suất</span>
                                </div>
                            </label>

                            {{-- Payoo Installment --}}
                            <label class="flex items-center p-4 border rounded-xl cursor-pointer transition-all"
                                :class="selectedPayment === 'payoo' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'">
                                <input type="radio" name="payment_method" value="payoo" x-model="selectedPayment"
                                    class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <div class="ml-4 flex items-center gap-3">
                                    <span class="px-2 py-1 bg-blue-800 text-white text-xs font-bold rounded">Payoo</span>
                                    <div>
                                        <span class="font-medium text-gray-900 block">Trả góp qua ví Payoo</span>
                                        <span class="text-sm text-gray-500">Trả góp 0% qua thẻ tín dụng</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Order Summary --}}
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-xl shadow-sm p-6 sticky top-4 border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Đơn hàng của bạn</h2>

                        {{-- Product List --}}
                        <div class="space-y-4 mb-6 max-h-[280px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($cart->items as $item)
                                <div class="flex gap-4">
                                    <div
                                        class="w-16 h-16 bg-gray-50 rounded-lg border border-gray-200 shrink-0 relative overflow-hidden">
                                        @if($item->product->images->first())
                                            <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product->name }}"
                                                class="w-full h-full object-contain p-1">
                                        @endif
                                        <span
                                            class="absolute -top-1 -right-1 w-5 h-5 bg-gray-900 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $item->qty }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-gray-900 text-sm font-medium line-clamp-2">{{ $item->product->name }}
                                        </h4>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-gray-900 text-sm font-bold">
                                            {{ number_format($item->subtotal, 0, ',', '.') }}₫</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Coupon Section --}}
                        <div class="mb-6 pb-6 border-b border-gray-100">
                            <template x-if="!appliedCoupon">
                                <div class="flex gap-2">
                                    <input type="text" x-model="couponCode" placeholder="Nhập mã giảm giá"
                                        class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm"
                                        @keyup.enter.prevent="applyCoupon()">
                                    <button type="button" @click="applyCoupon()" :disabled="couponLoading || !couponCode"
                                        class="px-5 py-3 bg-gray-900 text-white rounded-xl font-bold text-sm hover:bg-gray-800 transition-all disabled:bg-gray-300 disabled:cursor-not-allowed flex items-center gap-2">
                                        <template x-if="couponLoading">
                                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                        </template>
                                        <span>Áp dụng</span>
                                    </button>
                                </div>
                            </template>

                            <template x-if="appliedCoupon">
                                <div
                                    class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="font-bold text-green-800" x-text="appliedCoupon.code"></span>
                                            <p class="text-sm text-green-600" x-text="'-' + formattedDiscount"></p>
                                        </div>
                                    </div>
                                    <button type="button" @click="removeCoupon()"
                                        class="text-red-500 hover:text-red-700 p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <p x-show="couponError" x-text="couponError" class="mt-2 text-sm text-red-500"></p>
                        </div>

                        {{-- Totals --}}
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Tạm tính</span>
                                <span class="font-medium text-gray-900">{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                            </div>

                            <div class="flex justify-between text-gray-600" x-show="discount > 0">
                                <span>Giảm giá</span>
                                <span class="font-medium text-green-600" x-text="'-' + formattedDiscount"></span>
                            </div>

                            <div class="flex justify-between text-gray-600">
                                <span>Phí vận chuyển</span>
                                <span class="font-medium" :class="shippingFee === 0 ? 'text-green-600' : 'text-gray-900'"
                                    x-text="shippingFee === 0 ? 'Miễn phí' : formattedShippingFee"></span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center border-t border-gray-200 pt-4 mb-6">
                            <span class="text-lg font-bold text-gray-900">Tổng cộng</span>
                            <div class="text-right">
                                <span class="text-xs text-gray-500 mr-1">VND</span>
                                <span class="text-2xl font-bold text-gray-900" x-text="formattedTotal"></span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <button type="submit" :disabled="!selectedCity || !selectedShipping"
                                class="w-full px-6 py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-500/30 disabled:bg-gray-300 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Hoàn tất đơn hàng
                            </button>
                            <a href="{{ route('cart.index') }}"
                                class="text-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                                ← Quay lại giỏ hàng
                            </a>
                        </div>

                        {{-- Security Badge --}}
                        <div
                            class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-center gap-2 text-xs text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            Thanh toán an toàn & bảo mật
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function checkoutPage() {
            return {
                // Initial values from server
                subtotal: {{ $subtotal }},
                discount: {{ $discount ?? 0 }},
                shippingFee: {{ $shippingFee ?? 0 }},
                freeShipping: {{ $freeShipping ? 'true' : 'false' }},

                // State
                selectedCity: '{{ session("shipping_city", "") }}',
                selectedShipping: '{{ $selectedShipping ?? "standard" }}',
                selectedPayment: 'cod',
                shippingMethods: @json($shippingMethods ?? []),
                shippingLoading: false,

                // Coupon
                couponCode: '',
                appliedCoupon: @json($coupon ? ['code' => $coupon->code, 'name' => $coupon->name] : null),
                couponLoading: false,
                couponError: '',

                // Computed
                get total() {
                    return Math.max(0, this.subtotal - this.discount + this.shippingFee);
                },
                get formattedTotal() {
                    return new Intl.NumberFormat('vi-VN').format(this.total) + '₫';
                },
                get formattedDiscount() {
                    return new Intl.NumberFormat('vi-VN').format(this.discount) + '₫';
                },
                get formattedShippingFee() {
                    return new Intl.NumberFormat('vi-VN').format(this.shippingFee) + '₫';
                },

                // Methods
                async loadShippingMethods() {
                    if (!this.selectedCity) return;

                    this.shippingLoading = true;
                    try {
                        const response = await fetch(`{{ route('checkout.shipping-methods') }}?city=${encodeURIComponent(this.selectedCity)}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.shippingMethods = data.methods;
                            this.freeShipping = data.free_shipping;
                            if (this.shippingMethods.length > 0) {
                                this.selectedShipping = this.shippingMethods[0].id;
                                this.updateShipping();
                            }
                        }
                    } catch (error) {
                        console.error('Failed to load shipping methods:', error);
                    } finally {
                        this.shippingLoading = false;
                    }
                },

                async updateShipping() {
                    try {
                        const response = await fetch('{{ route('checkout.update-shipping') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ shipping_method: this.selectedShipping })
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.shippingFee = data.shipping_fee;
                        }
                    } catch (error) {
                        console.error('Failed to update shipping:', error);
                    }
                },

                async applyCoupon() {
                    if (!this.couponCode.trim()) return;

                    this.couponLoading = true;
                    this.couponError = '';

                    try {
                        const response = await fetch('{{ route('checkout.apply-coupon') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ coupon_code: this.couponCode })
                        });
                        const data = await response.json();

                        if (data.success) {
                            this.appliedCoupon = data.coupon;
                            this.discount = data.discount;
                            this.couponCode = '';
                        } else {
                            this.couponError = data.message;
                        }
                    } catch (error) {
                        this.couponError = 'Có lỗi xảy ra. Vui lòng thử lại.';
                    } finally {
                        this.couponLoading = false;
                    }
                },

                async removeCoupon() {
                    try {
                        const response = await fetch('{{ route('checkout.remove-coupon') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        const data = await response.json();

                        if (data.success) {
                            this.appliedCoupon = null;
                            this.discount = 0;
                        }
                    } catch (error) {
                        console.error('Failed to remove coupon:', error);
                    }
                },

                handleSubmit(e) {
                    if (!this.selectedCity || !this.selectedShipping) {
                        e.preventDefault();
                        alert('Vui lòng chọn tỉnh/thành và phương thức vận chuyển');
                    }
                }
            }
        }
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #aaa;
        }
    </style>
@endsection