@extends('layouts.app')

@section('title', 'Thanh toán - UITech')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8" x-data="checkoutPage()">
        <div class="container mx-auto px-4 max-w-5xl">

            {{-- Checkout Steps Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Thanh toán</h1>
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-2">
                        <span
                            class="w-6 h-6 rounded-full bg-gray-900 text-white text-xs flex items-center justify-center font-bold">1</span>
                        <span class="text-sm font-medium text-gray-900">Thông tin</span>
                    </div>
                    <div class="flex-1 h-px bg-gray-300 mx-2"></div>
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full text-xs flex items-center justify-center font-bold"
                            :class="selectedCity ? 'bg-gray-900 text-white' : 'bg-gray-200 text-gray-500'">2</span>
                        <span class="text-sm font-medium" :class="selectedCity ? 'text-gray-900' : 'text-gray-400'">Vận
                            chuyển</span>
                    </div>
                    <div class="flex-1 h-px bg-gray-300 mx-2"></div>
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full text-xs flex items-center justify-center font-bold"
                            :class="selectedPayment ? 'bg-gray-900 text-white' : 'bg-gray-200 text-gray-500'">3</span>
                        <span class="text-sm font-medium" :class="selectedPayment ? 'text-gray-900' : 'text-gray-400'">Thanh
                            toán</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('checkout.place-order') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6"
                @submit="handleSubmit">
                @csrf

                {{-- Left Column: Forms --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Shipping Info --}}
                    <div class="bg-white rounded-2xl border border-gray-200 p-6">
                        <h2 class="font-bold text-gray-900 mb-5">Thông tin giao hàng</h2>

                        <div class="space-y-4">
                            <input type="text" name="fullname" placeholder="Họ và tên *"
                                value="{{ old('fullname', $defaultAddress->recipient_name ?? Auth::user()->name ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 transition-all text-sm"
                                required>

                            <div class="grid grid-cols-2 gap-4">
                                <input type="email" name="email" placeholder="Email *"
                                    value="{{ old('email', Auth::user()->email ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 transition-all text-sm"
                                    required>

                                <input type="tel" name="phone" placeholder="Số điện thoại *"
                                    value="{{ old('phone', $defaultAddress->phone ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 transition-all text-sm"
                                    required>
                            </div>

                            <input type="text" name="address" placeholder="Địa chỉ chi tiết *"
                                value="{{ old('address', '') }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 transition-all text-sm"
                                required>

                            <div class="grid grid-cols-3 gap-4">
                                <select name="city" x-model="selectedCity" @change="loadShippingMethods()"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 transition-all text-sm bg-white"
                                    required>
                                    <option value="">Tỉnh/Thành *</option>
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
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 transition-all text-sm bg-white"
                                    required>
                                    <option value="">Quận/Huyện *</option>
                                    <option value="Quận 1">Quận 1</option>
                                    <option value="Quận 3">Quận 3</option>
                                    <option value="Quận 7">Quận 7</option>
                                    <option value="Thủ Đức">Thủ Đức</option>
                                    <option value="Bình Thạnh">Bình Thạnh</option>
                                    <option value="Tân Bình">Tân Bình</option>
                                    <option value="Gò Vấp">Gò Vấp</option>
                                </select>

                                <select name="ward"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 transition-all text-sm bg-white">
                                    <option value="">Phường/Xã</option>
                                    <option value="Linh Trung">Linh Trung</option>
                                    <option value="Linh Chiểu">Linh Chiểu</option>
                                    <option value="Hiệp Bình Chánh">Hiệp Bình Chánh</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Method --}}
                    <div class="bg-white rounded-2xl border border-gray-200 p-6">
                        <h2 class="font-bold text-gray-900 mb-5">Phương thức vận chuyển</h2>

                        <template x-if="!selectedCity">
                            <p class="text-gray-400 text-sm py-4 text-center">Vui lòng chọn tỉnh/thành để xem phương thức
                                vận chuyển</p>
                        </template>

                        <template x-if="selectedCity && freeShipping">
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4">
                                <p class="text-green-700 text-sm font-medium">Đơn hàng được miễn phí vận chuyển!</p>
                            </div>
                        </template>

                        <template x-if="selectedCity && shippingMethods.length > 0">
                            <div class="space-y-3">
                                <template x-for="method in shippingMethods" :key="method.id">
                                    <label
                                        class="flex items-center justify-between p-4 border rounded-xl cursor-pointer transition-all"
                                        :class="selectedShipping === method.id ? 'border-gray-900 bg-gray-50' : 'border-gray-200 hover:border-gray-300'">
                                        <div class="flex items-center gap-3">
                                            <input type="radio" name="shipping_method" :value="method.id"
                                                x-model="selectedShipping" @change="updateShipping()"
                                                class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900">
                                            <div>
                                                <span class="text-sm font-medium text-gray-900" x-text="method.name"></span>
                                                <p class="text-xs text-gray-400" x-text="method.description"></p>
                                            </div>
                                        </div>
                                        <span class="text-sm font-bold"
                                            :class="freeShipping ? 'text-green-600' : 'text-gray-900'"
                                            x-text="method.formatted_fee"></span>
                                    </label>
                                </template>
                            </div>
                        </template>

                        <template x-if="shippingLoading">
                            <div class="flex items-center justify-center py-8">
                                <div class="w-6 h-6 border-2 border-gray-300 border-t-gray-900 rounded-full animate-spin">
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Payment Method --}}
                    <div class="bg-white rounded-2xl border border-gray-200 p-6">
                        <h2 class="font-bold text-gray-900 mb-5">Phương thức thanh toán</h2>

                        <div class="space-y-3">
                            {{-- COD --}}
                            <label
                                class="flex items-center justify-between p-4 border rounded-xl cursor-pointer transition-all"
                                :class="selectedPayment === 'cod' ? 'border-gray-900 bg-gray-50' : 'border-gray-200 hover:border-gray-300'">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="cod" x-model="selectedPayment"
                                        class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900" checked>
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">Thanh toán khi nhận hàng</span>
                                        <p class="text-xs text-gray-400">COD - Kiểm tra hàng trước khi thanh toán</p>
                                    </div>
                                </div>
                            </label>

                            {{-- Bank Transfer --}}
                            <label
                                class="flex items-center justify-between p-4 border rounded-xl cursor-pointer transition-all"
                                :class="selectedPayment === 'bank_transfer' ? 'border-gray-900 bg-gray-50' : 'border-gray-200 hover:border-gray-300'">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="bank_transfer"
                                        x-model="selectedPayment"
                                        class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900">
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">Chuyển khoản ngân hàng</span>
                                        <p class="text-xs text-gray-400">Thanh toán qua QR hoặc số tài khoản</p>
                                    </div>
                                </div>
                            </label>

                            {{-- ATM/Card --}}
                            <label
                                class="flex items-center justify-between p-4 border rounded-xl cursor-pointer transition-all"
                                :class="selectedPayment === 'atm' ? 'border-gray-900 bg-gray-50' : 'border-gray-200 hover:border-gray-300'">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="atm" x-model="selectedPayment"
                                        class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900">
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">Thẻ ATM / Visa / Master</span>
                                        <p class="text-xs text-gray-400">Thanh toán an toàn qua cổng bảo mật</p>
                                    </div>
                                </div>
                            </label>

                            {{-- Fundiin --}}
                            <label
                                class="flex items-center justify-between p-4 border rounded-xl cursor-pointer transition-all"
                                :class="selectedPayment === 'fundiin' ? 'border-gray-900 bg-gray-50' : 'border-gray-200 hover:border-gray-300'">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="fundiin" x-model="selectedPayment"
                                        class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900">
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">Trả sau 0% lãi suất</span>
                                        <p class="text-xs text-gray-400">Fundiin - Chia nhỏ thanh toán</p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">-50K</span>
                            </label>
                        </div>

                        {{-- Bank Transfer Details --}}
                        <div x-show="selectedPayment === 'bank_transfer'" x-transition
                            class="mt-6 p-5 bg-gray-50 rounded-xl border border-gray-200">
                            <p class="font-medium text-gray-900 mb-4 text-sm">Thông tin chuyển khoản</p>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Ngân hàng</span>
                                    <span class="font-medium text-gray-900">Vietcombank</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Số tài khoản</span>
                                    <span class="font-mono font-medium text-gray-900">1234567890</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Chủ TK</span>
                                    <span class="font-medium text-gray-900">CONG TY UITECH</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Số tiền</span>
                                    <span class="font-bold text-gray-900" x-text="formattedTotal"></span>
                                </div>
                                <div class="pt-3 border-t border-gray-200">
                                    <p class="text-gray-500 mb-1">Nội dung CK:</p>
                                    <p class="font-mono font-medium text-gray-900 bg-white px-3 py-2 rounded border"
                                        x-text="'UITECH ' + orderCodePreview"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Card Payment Form --}}
                        <div x-show="selectedPayment === 'atm'" x-transition
                            class="mt-6 p-5 bg-gray-50 rounded-xl border border-gray-200">
                            <p class="font-medium text-gray-900 mb-4 text-sm">Thông tin thẻ</p>
                            <div class="space-y-4">
                                <input type="text" name="card_number" placeholder="Số thẻ" maxlength="19"
                                    x-model="cardNumber" @input="formatCardNumber"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 transition-all text-sm font-mono">

                                <div class="grid grid-cols-2 gap-4">
                                    <input type="text" name="card_expiry" placeholder="MM/YY" maxlength="5"
                                        x-model="cardExpiry" @input="formatCardExpiry"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 transition-all text-sm font-mono">
                                    <input type="password" name="card_cvv" placeholder="CVV" maxlength="4"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 transition-all text-sm font-mono">
                                </div>

                                <input type="text" name="card_holder" placeholder="Tên chủ thẻ"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 transition-all text-sm uppercase">
                            </div>
                        </div>

                        {{-- Fundiin Info --}}
                        <div x-show="selectedPayment === 'fundiin'" x-transition
                            class="mt-6 p-5 bg-gray-50 rounded-xl border border-gray-200">
                            <p class="font-medium text-gray-900 mb-4 text-sm">Chia 3 kỳ thanh toán</p>
                            <div class="grid grid-cols-3 gap-3 text-center">
                                <div class="bg-white p-3 rounded-lg border border-gray-200">
                                    <p class="text-xs text-gray-400 mb-1">Kỳ 1</p>
                                    <p class="font-bold text-gray-900 text-sm"
                                        x-text="formatCurrency(Math.round(total / 3))"></p>
                                </div>
                                <div class="bg-white p-3 rounded-lg border border-gray-200">
                                    <p class="text-xs text-gray-400 mb-1">Kỳ 2</p>
                                    <p class="font-bold text-gray-900 text-sm"
                                        x-text="formatCurrency(Math.round(total / 3))"></p>
                                </div>
                                <div class="bg-white p-3 rounded-lg border border-gray-200">
                                    <p class="text-xs text-gray-400 mb-1">Kỳ 3</p>
                                    <p class="font-bold text-gray-900 text-sm"
                                        x-text="formatCurrency(Math.round(total / 3))"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl border border-gray-200 p-6 sticky top-24">
                        <h2 class="font-bold text-gray-900 mb-5">Đơn hàng ({{ $cart->items->count() }})</h2>

                        {{-- Product List --}}
                        <div class="space-y-4 mb-6 max-h-60 overflow-y-auto">
                            @foreach($cart->items as $item)
                                <div class="flex gap-3">
                                    <div
                                        class="w-14 h-14 bg-gray-50 rounded-lg border border-gray-100 flex-shrink-0 overflow-hidden p-1 relative">
                                        @if($item->product->images->first())
                                            <img src="{{ asset($item->product->images->first()->url) }}" alt="{{ $item->product->name }}"
                                                class="w-full h-full object-contain">
                                        @endif
                                        <span
                                            class="absolute -top-1 -right-1 w-5 h-5 bg-gray-900 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $item->qty }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-900 font-medium truncate">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-400">{{ number_format($item->subtotal, 0, ',', '.') }}₫</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Coupon --}}
                        <div class="mb-6 pb-6 border-b border-gray-100">
                            <template x-if="!appliedCoupon">
                                <div class="flex gap-2">
                                    <input type="text" x-model="couponCode" placeholder="Mã giảm giá"
                                        class="flex-1 px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900"
                                        @keyup.enter.prevent="applyCoupon()">
                                    <button type="button" @click="applyCoupon()" :disabled="couponLoading || !couponCode"
                                        class="px-4 py-2.5 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-gray-800 disabled:bg-gray-300 disabled:cursor-not-allowed">
                                        Áp dụng
                                    </button>
                                </div>
                            </template>

                            <template x-if="appliedCoupon">
                                <div
                                    class="flex items-center justify-between p-3 bg-green-50 border border-green-200 rounded-lg">
                                    <div>
                                        <span class="font-medium text-green-700 text-sm" x-text="appliedCoupon.code"></span>
                                        <span class="text-green-600 text-sm ml-2" x-text="'-' + formattedDiscount"></span>
                                    </div>
                                    <button type="button" @click="removeCoupon()" class="text-gray-400 hover:text-red-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <p x-show="couponError" x-text="couponError" class="mt-2 text-xs text-red-500"></p>
                        </div>

                        {{-- Totals --}}
                        <div class="space-y-3 text-sm mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Tạm tính</span>
                                <span>{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                            </div>

                            <div class="flex justify-between text-green-600" x-show="discount > 0">
                                <span>Giảm giá</span>
                                <span x-text="'-' + formattedDiscount"></span>
                            </div>

                            <div class="flex justify-between text-gray-600">
                                <span>Phí vận chuyển</span>
                                <span :class="shippingFee === 0 ? 'text-green-600' : ''"
                                    x-text="shippingFee === 0 ? 'Miễn phí' : formattedShippingFee"></span>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-900">Tổng cộng</span>
                                <span class="text-xl font-bold text-gray-900" x-text="formattedTotal"></span>
                            </div>
                        </div>

                        <button type="submit" :disabled="!selectedCity || !selectedShipping"
                            class="w-full px-6 py-3.5 bg-gray-900 text-white font-medium rounded-xl hover:bg-gray-800 transition-all disabled:bg-gray-300 disabled:cursor-not-allowed">
                            Hoàn tất đơn hàng
                        </button>

                        <a href="{{ route('cart.index') }}"
                            class="block text-center text-gray-500 hover:text-gray-900 text-sm mt-4">
                            ← Quay lại giỏ hàng
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function checkoutPage() {
            return {
                subtotal: {{ $subtotal }},
                discount: {{ $discount ?? 0 }},
                shippingFee: {{ $shippingFee ?? 0 }},
                freeShipping: {{ $freeShipping ? 'true' : 'false' }},

                selectedCity: '{{ session("shipping_city", "") }}',
                selectedShipping: '{{ $selectedShipping ?? "standard" }}',
                selectedPayment: 'cod',
                shippingMethods: @json($shippingMethods ?? []),
                shippingLoading: false,

                couponCode: '',
                appliedCoupon: @json($coupon ? ['code' => $coupon->code, 'name' => $coupon->name] : null),
                couponLoading: false,
                couponError: '',

                cardNumber: '',
                cardExpiry: '',

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
                get orderCodePreview() {
                    const date = new Date();
                    return date.getFullYear().toString() + String(date.getMonth() + 1).padStart(2, '0') + String(date.getDate()).padStart(2, '0') + '-XXXXX';
                },

                formatCurrency(amount) {
                    return new Intl.NumberFormat('vi-VN').format(amount) + '₫';
                },
                formatCardNumber() {
                    let value = this.cardNumber.replace(/\s/g, '').replace(/\D/g, '');
                    this.cardNumber = (value.match(/.{1,4}/g)?.join(' ') || value).substring(0, 19);
                },
                formatCardExpiry() {
                    let value = this.cardExpiry.replace(/\D/g, '');
                    if (value.length >= 2) value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    this.cardExpiry = value.substring(0, 5);
                },

                async loadShippingMethods() {
                    if (!this.selectedCity) return;
                    this.shippingLoading = true;
                    try {
                        const response = await fetch(`{{ route('checkout.shipping-methods') }}?city=${encodeURIComponent(this.selectedCity)}`, {
                            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
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
                    } catch (e) { console.error(e); }
                    finally { this.shippingLoading = false; }
                },

                async updateShipping() {
                    try {
                        const response = await fetch('{{ route('checkout.update-shipping') }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                            body: JSON.stringify({ shipping_method: this.selectedShipping })
                        });
                        const data = await response.json();
                        if (data.success) this.shippingFee = data.shipping_fee;
                    } catch (e) { console.error(e); }
                },

                async applyCoupon() {
                    if (!this.couponCode.trim()) return;
                    this.couponLoading = true;
                    this.couponError = '';
                    try {
                        const response = await fetch('{{ route('checkout.apply-coupon') }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
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
                    } catch (e) { this.couponError = 'Có lỗi xảy ra.'; }
                    finally { this.couponLoading = false; }
                },

                async removeCoupon() {
                    try {
                        const response = await fetch('{{ route('checkout.remove-coupon') }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                        });
                        const data = await response.json();
                        if (data.success) { this.appliedCoupon = null; this.discount = 0; }
                    } catch (e) { console.error(e); }
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
@endsection