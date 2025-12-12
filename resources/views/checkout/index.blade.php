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
                                <select name="city" x-model="selectedCity" @change="loadShippingMethods(); updateDistricts()"
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

                                <select name="district" x-model="selectedDistrict" @change="updateWards()"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 transition-all text-sm bg-white"
                                    required>
                                    <option value="">Quận/Huyện *</option>
                                    <template x-for="district in districts" :key="district">
                                        <option :value="district" x-text="district"></option>
                                    </template>
                                </select>

                                <select name="ward" x-model="selectedWard"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 transition-all text-sm bg-white">
                                    <option value="">Phường/Xã</option>
                                    <template x-for="ward in wards" :key="ward">
                                        <option :value="ward" x-text="ward"></option>
                                    </template>
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

        {{-- Payment Simulation Modal --}}
        <div x-show="showPaymentModal" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4" 
             style="display: none;">
            
            <div class="absolute inset-0 bg-black/60"></div>
            
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 text-center"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                
                {{-- Processing State --}}
                <div x-show="paymentState === 'processing'">
                    <div class="w-20 h-20 mx-auto mb-6 relative">
                        <div class="absolute inset-0 rounded-full border-4 border-gray-200"></div>
                        <div class="absolute inset-0 rounded-full border-4 border-gray-900 border-t-transparent animate-spin"></div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Đang xử lý thanh toán</h3>
                    <p class="text-gray-500 mb-4">Vui lòng không đóng trang này...</p>
                    <div class="text-sm text-gray-400">
                        <span x-text="getPaymentMethodName()"></span> - 
                        <span x-text="formattedTotal"></span>
                    </div>
                </div>

                {{-- Success State --}}
                <div x-show="paymentState === 'success'">
                    <div class="w-20 h-20 mx-auto mb-6 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Thanh toán thành công!</h3>
                    <p class="text-gray-500 mb-4">Đang tạo đơn hàng của bạn...</p>
                    <div class="text-2xl font-bold text-green-600" x-text="formattedTotal"></div>
                </div>

                {{-- Failed State (for demo purposes) --}}
                <div x-show="paymentState === 'failed'">
                    <div class="w-20 h-20 mx-auto mb-6 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Thanh toán thất bại</h3>
                    <p class="text-gray-500 mb-6">Vui lòng kiểm tra lại thông tin thẻ và thử lại.</p>
                    <button @click="closePaymentModal()" 
                            class="px-6 py-3 bg-gray-900 text-white font-medium rounded-xl hover:bg-gray-800 transition">
                        Thử lại
                    </button>
                </div>
            </div>
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
                selectedDistrict: '',
                selectedWard: '',
                selectedShipping: '{{ $selectedShipping ?? "standard" }}',
                selectedPayment: 'cod',
                shippingMethods: @json($shippingMethods ?? []),
                shippingLoading: false,
                
                // Address data by city
                districts: [],
                wards: [],
                addressData: {
                    'Hồ Chí Minh': {
                        'Quận 1': ['Bến Nghé', 'Bến Thành', 'Cầu Kho', 'Cầu Ông Lãnh', 'Cô Giang', 'Đa Kao', 'Nguyễn Cư Trinh', 'Nguyễn Thái Bình', 'Phạm Ngũ Lão', 'Tân Định'],
                        'Quận 3': ['Phường 1', 'Phường 2', 'Phường 3', 'Phường 4', 'Phường 5', 'Phường 9', 'Phường 10', 'Phường 11', 'Phường 12', 'Phường 13', 'Phường 14', 'Võ Thị Sáu'],
                        'Quận 7': ['Bình Thuận', 'Phú Mỹ', 'Phú Thuận', 'Tân Hưng', 'Tân Kiểng', 'Tân Phong', 'Tân Phú', 'Tân Quy'],
                        'Thủ Đức': ['Linh Trung', 'Linh Chiểu', 'Linh Tây', 'Linh Xuân', 'Hiệp Bình Chánh', 'Hiệp Bình Phước', 'Tam Bình', 'Tam Phú', 'Trường Thọ', 'Bình Chiểu', 'Bình Thọ', 'An Phú', 'Thảo Điền', 'An Khánh', 'Bình Trưng Đông', 'Bình Trưng Tây', 'Cát Lái', 'Long Bình', 'Long Phước', 'Long Thạnh Mỹ', 'Long Trường', 'Phú Hữu', 'Phước Bình', 'Phước Long A', 'Phước Long B', 'Tân Phú', 'Tăng Nhơn Phú A', 'Tăng Nhơn Phú B', 'Thạnh Mỹ Lợi', 'Thủ Thiêm', 'Trường Thạnh', 'An Lợi Đông'],
                        'Bình Thạnh': ['Phường 1', 'Phường 2', 'Phường 3', 'Phường 5', 'Phường 6', 'Phường 7', 'Phường 11', 'Phường 12', 'Phường 13', 'Phường 14', 'Phường 15', 'Phường 17', 'Phường 19', 'Phường 21', 'Phường 22', 'Phường 24', 'Phường 25', 'Phường 26', 'Phường 27', 'Phường 28'],
                        'Tân Bình': ['Phường 1', 'Phường 2', 'Phường 3', 'Phường 4', 'Phường 5', 'Phường 6', 'Phường 7', 'Phường 8', 'Phường 9', 'Phường 10', 'Phường 11', 'Phường 12', 'Phường 13', 'Phường 14', 'Phường 15'],
                        'Gò Vấp': ['Phường 1', 'Phường 3', 'Phường 4', 'Phường 5', 'Phường 6', 'Phường 7', 'Phường 8', 'Phường 9', 'Phường 10', 'Phường 11', 'Phường 12', 'Phường 13', 'Phường 14', 'Phường 15', 'Phường 16', 'Phường 17'],
                        'Phú Nhuận': ['Phường 1', 'Phường 2', 'Phường 3', 'Phường 4', 'Phường 5', 'Phường 7', 'Phường 8', 'Phường 9', 'Phường 10', 'Phường 11', 'Phường 13', 'Phường 15', 'Phường 17'],
                        'Tân Phú': ['Hiệp Tân', 'Hòa Thạnh', 'Phú Thạnh', 'Phú Thọ Hòa', 'Phú Trung', 'Sơn Kỳ', 'Tân Quý', 'Tân Sơn Nhì', 'Tân Thành', 'Tân Thới Hòa', 'Tây Thạnh'],
                        'Quận 5': ['Phường 1', 'Phường 2', 'Phường 3', 'Phường 4', 'Phường 5', 'Phường 6', 'Phường 7', 'Phường 8', 'Phường 9', 'Phường 10', 'Phường 11', 'Phường 12', 'Phường 13', 'Phường 14'],
                        'Quận 10': ['Phường 1', 'Phường 2', 'Phường 3', 'Phường 4', 'Phường 5', 'Phường 6', 'Phường 7', 'Phường 8', 'Phường 9', 'Phường 10', 'Phường 11', 'Phường 12', 'Phường 13', 'Phường 14', 'Phường 15'],
                        'Quận 11': ['Phường 1', 'Phường 2', 'Phường 3', 'Phường 4', 'Phường 5', 'Phường 6', 'Phường 7', 'Phường 8', 'Phường 9', 'Phường 10', 'Phường 11', 'Phường 12', 'Phường 13', 'Phường 14', 'Phường 15', 'Phường 16'],
                        'Quận 12': ['An Phú Đông', 'Đông Hưng Thuận', 'Hiệp Thành', 'Tân Chánh Hiệp', 'Tân Hưng Thuận', 'Tân Thới Hiệp', 'Tân Thới Nhất', 'Thạnh Lộc', 'Thạnh Xuân', 'Thới An', 'Trung Mỹ Tây'],
                        'Bình Tân': ['An Lạc', 'An Lạc A', 'Bình Hưng Hòa', 'Bình Hưng Hòa A', 'Bình Hưng Hòa B', 'Bình Trị Đông', 'Bình Trị Đông A', 'Bình Trị Đông B', 'Tân Tạo', 'Tân Tạo A'],
                    },
                    'Hà Nội': {
                        'Ba Đình': ['Cống Vị', 'Điện Biên', 'Đội Cấn', 'Giảng Võ', 'Kim Mã', 'Liễu Giai', 'Ngọc Hà', 'Ngọc Khánh', 'Nguyễn Trung Trực', 'Phúc Xá', 'Quán Thánh', 'Thành Công', 'Trúc Bạch', 'Vĩnh Phúc'],
                        'Hoàn Kiếm': ['Chương Dương', 'Cửa Đông', 'Cửa Nam', 'Đồng Xuân', 'Hàng Bạc', 'Hàng Bài', 'Hàng Bồ', 'Hàng Bông', 'Hàng Buồm', 'Hàng Đào', 'Hàng Gai', 'Hàng Mã', 'Hàng Trống', 'Lý Thái Tổ', 'Phan Chu Trinh', 'Phúc Tân', 'Tràng Tiền', 'Trần Hưng Đạo'],
                        'Đống Đa': ['Cát Linh', 'Hàng Bột', 'Khâm Thiên', 'Khương Thượng', 'Kim Liên', 'Láng Hạ', 'Láng Thượng', 'Nam Đồng', 'Ngã Tư Sở', 'Ô Chợ Dừa', 'Phương Liên', 'Phương Mai', 'Quang Trung', 'Quốc Tử Giám', 'Thịnh Quang', 'Thổ Quan', 'Trung Liệt', 'Trung Phụng', 'Trung Tự', 'Văn Chương', 'Văn Miếu'],
                        'Hai Bà Trưng': ['Bạch Đằng', 'Bạch Mai', 'Bách Khoa', 'Cầu Dền', 'Đống Mác', 'Đồng Nhân', 'Đồng Tâm', 'Lê Đại Hành', 'Minh Khai', 'Ngô Thì Nhậm', 'Nguyễn Du', 'Phạm Đình Hổ', 'Phố Huế', 'Quỳnh Lôi', 'Quỳnh Mai', 'Thanh Lương', 'Thanh Nhàn', 'Trương Định', 'Vĩnh Tuy'],
                        'Thanh Xuân': ['Hạ Đình', 'Khương Đình', 'Khương Mai', 'Khương Trung', 'Kim Giang', 'Nhân Chính', 'Phương Liệt', 'Thanh Xuân Bắc', 'Thanh Xuân Nam', 'Thanh Xuân Trung', 'Thượng Đình'],
                        'Cầu Giấy': ['Dịch Vọng', 'Dịch Vọng Hậu', 'Mai Dịch', 'Nghĩa Đô', 'Nghĩa Tân', 'Quan Hoa', 'Trung Hòa', 'Yên Hòa'],
                        'Long Biên': ['Bồ Đề', 'Cự Khối', 'Đức Giang', 'Gia Thụy', 'Giang Biên', 'Long Biên', 'Ngọc Lâm', 'Ngọc Thụy', 'Phúc Đồng', 'Phúc Lợi', 'Sài Đồng', 'Thạch Bàn', 'Thượng Thanh', 'Việt Hưng'],
                        'Hoàng Mai': ['Đại Kim', 'Định Công', 'Giáp Bát', 'Hoàng Liệt', 'Hoàng Văn Thụ', 'Lĩnh Nam', 'Mai Động', 'Tân Mai', 'Thanh Trì', 'Thịnh Liệt', 'Trần Phú', 'Tương Mai', 'Vĩnh Hưng', 'Yên Sở'],
                        'Nam Từ Liêm': ['Cầu Diễn', 'Đại Mỗ', 'Mễ Trì', 'Mỹ Đình 1', 'Mỹ Đình 2', 'Phú Đô', 'Phương Canh', 'Tây Mỗ', 'Trung Văn', 'Xuân Phương'],
                        'Bắc Từ Liêm': ['Cổ Nhuế 1', 'Cổ Nhuế 2', 'Đông Ngạc', 'Đức Thắng', 'Liên Mạc', 'Minh Khai', 'Phú Diễn', 'Phúc Diễn', 'Tây Tựu', 'Thượng Cát', 'Thụy Phương', 'Xuân Đỉnh', 'Xuân Tảo'],
                    },
                    'Đà Nẵng': {
                        'Hải Châu': ['Bình Hiên', 'Bình Thuận', 'Hải Châu 1', 'Hải Châu 2', 'Hòa Cường Bắc', 'Hòa Cường Nam', 'Hòa Thuận Đông', 'Hòa Thuận Tây', 'Nam Dương', 'Phước Ninh', 'Thạch Thang', 'Thanh Bình', 'Thuận Phước'],
                        'Thanh Khê': ['An Khê', 'Chính Gián', 'Hòa Khê', 'Tam Thuận', 'Tân Chính', 'Thạc Gián', 'Thanh Khê Đông', 'Thanh Khê Tây', 'Vĩnh Trung', 'Xuân Hà'],
                        'Sơn Trà': ['An Hải Bắc', 'An Hải Đông', 'An Hải Tây', 'Mân Thái', 'Nại Hiên Đông', 'Phước Mỹ', 'Thọ Quang'],
                        'Ngũ Hành Sơn': ['Hòa Hải', 'Hòa Quý', 'Khuê Mỹ', 'Mỹ An'],
                        'Cẩm Lệ': ['Hòa An', 'Hòa Phát', 'Hòa Thọ Đông', 'Hòa Thọ Tây', 'Hòa Xuân', 'Khuê Trung'],
                        'Liên Chiểu': ['Hòa Hiệp Bắc', 'Hòa Hiệp Nam', 'Hòa Khánh Bắc', 'Hòa Khánh Nam', 'Hòa Minh'],
                    },
                    'Cần Thơ': {
                        'Ninh Kiều': ['An Bình', 'An Cư', 'An Hòa', 'An Khánh', 'An Lạc', 'An Nghiệp', 'An Phú', 'Cái Khế', 'Hưng Lợi', 'Tân An', 'Thới Bình', 'Xuân Khánh'],
                        'Bình Thủy': ['An Thới', 'Bình Thủy', 'Bùi Hữu Nghĩa', 'Long Hòa', 'Long Tuyền', 'Thới An Đông', 'Trà An', 'Trà Nóc'],
                        'Cái Răng': ['Ba Láng', 'Hưng Phú', 'Hưng Thạnh', 'Lê Bình', 'Phú Thứ', 'Tân Phú', 'Thường Thạnh'],
                        'Ô Môn': ['Châu Văn Liêm', 'Long Hưng', 'Phước Thới', 'Thới An', 'Thới Hòa', 'Thới Long', 'Trường Lạc'],
                    },
                    'Hải Phòng': {
                        'Hồng Bàng': ['Hoàng Văn Thụ', 'Minh Khai', 'Phan Bội Châu', 'Quán Toan', 'Sở Dầu', 'Thượng Lý', 'Trại Chuối'],
                        'Lê Chân': ['An Biên', 'An Dương', 'Cát Dài', 'Dư Hàng', 'Dư Hàng Kênh', 'Hàng Kênh', 'Hồ Nam', 'Kênh Dương', 'Lam Sơn', 'Nghĩa Xá', 'Niệm Nghĩa', 'Trại Cau', 'Trần Nguyên Hãn', 'Vĩnh Niệm'],
                        'Ngô Quyền': ['Cầu Đất', 'Cầu Tre', 'Đằng Giang', 'Đằng Hải', 'Đằng Lâm', 'Đông Khê', 'Gia Viên', 'Lạc Viên', 'Lạch Tray', 'Lê Lợi', 'Máy Chai', 'Máy Tơ', 'Vạn Mỹ'],
                        'Hải An': ['Cát Bi', 'Đằng Hải', 'Đằng Lâm', 'Đông Hải 1', 'Đông Hải 2', 'Nam Hải', 'Tràng Cát'],
                    },
                    'Bình Dương': {
                        'Thủ Dầu Một': ['Chánh Mỹ', 'Chánh Nghĩa', 'Định Hòa', 'Hiệp An', 'Hiệp Thành', 'Hòa Phú', 'Phú Cường', 'Phú Hòa', 'Phú Lợi', 'Phú Mỹ', 'Phú Tân', 'Phú Thọ', 'Tân An', 'Tương Bình Hiệp'],
                        'Dĩ An': ['An Bình', 'Bình An', 'Bình Thắng', 'Đông Hòa', 'Tân Bình', 'Tân Đông Hiệp'],
                        'Thuận An': ['An Phú', 'An Thạnh', 'Bình Chuẩn', 'Bình Hòa', 'Bình Nhâm', 'Hưng Định', 'Lái Thiêu', 'Thuận Giao', 'Vĩnh Phú'],
                        'Bến Cát': ['Chánh Phú Hòa', 'Hòa Lợi', 'Mỹ Phước', 'Tân Định', 'Thới Hòa'],
                    },
                    'Đồng Nai': {
                        'Biên Hòa': ['An Bình', 'Bình Đa', 'Bửu Hòa', 'Bửu Long', 'Hố Nai', 'Hòa Bình', 'Long Bình', 'Long Bình Tân', 'Phước Tân', 'Quyết Thắng', 'Tân Biên', 'Tân Hiệp', 'Tân Hòa', 'Tân Mai', 'Tân Phong', 'Tân Tiến', 'Tân Vạn', 'Tam Hòa', 'Tam Hiệp', 'Tam Phước', 'Thống Nhất', 'Trảng Dài', 'Trung Dũng'],
                        'Long Khánh': ['Bảo Vinh', 'Xuân An', 'Xuân Bình', 'Xuân Hòa', 'Xuân Lập', 'Xuân Trung'],
                        'Long Thành': ['An Phước', 'Bình An', 'Bình Sơn', 'Long An', 'Long Đức', 'Long Phước', 'Long Thành', 'Phước Bình', 'Tam An', 'Tân Hiệp'],
                        'Nhơn Trạch': ['Long Tân', 'Long Thọ', 'Phú Đông', 'Phú Hội', 'Phú Hữu', 'Phú Thạnh', 'Phước An', 'Phước Khánh', 'Phước Thiền', 'Vĩnh Thanh'],
                    },
                    'Khác': {
                        'Khác': ['Khác']
                    }
                },

                couponCode: '',
                appliedCoupon: @json($coupon ? ['code' => $coupon->code, 'name' => $coupon->name] : null),
                couponLoading: false,
                couponError: '',

                cardNumber: '',
                cardExpiry: '',

                // Payment simulation
                showPaymentModal: false,
                paymentState: 'processing', // processing, success, failed
                formReference: null,

                updateDistricts() {
                    this.districts = this.selectedCity ? Object.keys(this.addressData[this.selectedCity] || {}) : [];
                    this.selectedDistrict = '';
                    this.wards = [];
                    this.selectedWard = '';
                },

                updateWards() {
                    if (this.selectedCity && this.selectedDistrict) {
                        this.wards = this.addressData[this.selectedCity]?.[this.selectedDistrict] || [];
                    } else {
                        this.wards = [];
                    }
                    this.selectedWard = '';
                },

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

                getPaymentMethodName() {
                    const names = {
                        'cod': 'Thanh toán khi nhận hàng',
                        'bank_transfer': 'Chuyển khoản ngân hàng',
                        'atm': 'Thẻ ATM/Visa/Master',
                        'fundiin': 'Trả sau Fundiin'
                    };
                    return names[this.selectedPayment] || this.selectedPayment;
                },

                isOnlinePayment() {
                    return ['atm', 'bank_transfer', 'fundiin'].includes(this.selectedPayment);
                },

                async simulatePayment() {
                    this.paymentState = 'processing';
                    this.showPaymentModal = true;
                    document.body.style.overflow = 'hidden';

                    // Simulate payment processing (3 seconds)
                    await new Promise(resolve => setTimeout(resolve, 3000));

                    // Simulate success (you can add random failure for demo: Math.random() > 0.1)
                    this.paymentState = 'success';

                    // Wait 1.5 seconds then submit the real form
                    await new Promise(resolve => setTimeout(resolve, 1500));
                    
                    // Submit the form
                    if (this.formReference) {
                        this.showPaymentModal = false;
                        document.body.style.overflow = '';
                        this.formReference.submit();
                    }
                },

                closePaymentModal() {
                    this.showPaymentModal = false;
                    this.paymentState = 'processing';
                    document.body.style.overflow = '';
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
                        return;
                    }

                    if (!this.selectedPayment) {
                        e.preventDefault();
                        alert('Vui lòng chọn phương thức thanh toán');
                        return;
                    }

                    // For online payment methods, show simulation modal
                    if (this.isOnlinePayment()) {
                        e.preventDefault();
                        this.formReference = e.target;
                        this.simulatePayment();
                    }
                    // For COD, submit form directly (no simulation needed)
                }
            }
        }
    </script>
@endsection