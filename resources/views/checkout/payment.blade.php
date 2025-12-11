@extends('layouts.app')

@section('title', 'Thanh toán - UITech')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4 max-w-6xl">
            {{-- Progress Steps --}}
            <div class="mb-12">
                <div class="flex items-center justify-center">
                    <div class="flex items-center">
                        <div class="flex items-center text-green-600">
                            <div
                                class="h-10 w-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg shadow-green-500/30">
                                ✓</div>
                            <span class="ml-3 font-medium text-gray-900">Giao hàng</span>
                        </div>
                        <div class="w-24 h-1 bg-green-600 mx-4 rounded-full"></div>
                        <div class="flex items-center text-gray-900">
                            <div
                                class="h-10 w-10 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold shadow-lg shadow-gray-900/20">
                                2</div>
                            <span class="ml-3 font-bold text-gray-900">Thanh toán</span>
                        </div>
                        <div class="w-24 h-1 bg-gray-200 mx-4 rounded-full"></div>
                        <div class="flex items-center text-gray-400">
                            <div
                                class="h-10 w-10 bg-white border-2 border-gray-200 rounded-full flex items-center justify-center font-medium">
                                3</div>
                            <span class="ml-3 font-medium">Xác nhận</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                {{-- Payment Method Selection --}}
                <div class="lg:col-span-8 space-y-6">
                    {{-- Selected Shipping Address --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-gray-900 text-lg">Địa chỉ giao hàng</h3>
                            <a href="{{ route('checkout.shipping') }}"
                                class="text-gray-900 text-sm font-medium hover:text-gray-700 hover:underline transition-colors">Thay
                                đổi</a>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <p class="font-bold text-gray-900 text-lg">{{ $address->fullname }}</p>
                            <p class="text-sm text-gray-500 mt-1 font-medium">{{ $address->phone }}</p>
                            <p class="text-sm text-gray-600 mt-2 leading-relaxed">
                                {{ $address->address }}
                                @if($address->ward), {{ $address->ward }}@endif
                                @if($address->district), {{ $address->district }}@endif
                                @if($address->city), {{ $address->city }}@endif
                            </p>
                        </div>
                    </div>

                    {{-- Payment Methods --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Phương thức thanh toán</h2>

                        <form method="POST" action="{{ route('checkout.store-payment') }}" id="payment-form">
                            @csrf

                            <div class="space-y-4">
                                {{-- COD --}}
                                <label class="block cursor-pointer group relative">
                                    <input type="radio" name="payment_method" value="cod" class="hidden peer" checked
                                        required>
                                    <div
                                        class="border-2 border-gray-100 rounded-xl p-6 transition-all peer-checked:border-gray-900 peer-checked:bg-gray-50 hover:border-gray-300">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-2xl">
                                                    💵
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-900">Thanh toán khi nhận hàng (COD)</p>
                                                    <p class="text-sm text-gray-500 mt-1">Thanh toán bằng tiền mặt khi nhận
                                                        hàng</p>
                                                </div>
                                            </div>
                                            <div
                                                class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-gray-900 peer-checked:bg-gray-900 flex items-center justify-center transition-colors">
                                                <div
                                                    class="w-2.5 h-2.5 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="absolute inset-0 border-2 border-gray-900 rounded-xl opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity">
                                    </div>
                                </label>

                                {{-- Bank Transfer --}}
                                <label class="block cursor-pointer group relative">
                                    <input type="radio" name="payment_method" value="bank_transfer" class="hidden peer"
                                        required>
                                    <div
                                        class="border-2 border-gray-100 rounded-xl p-6 transition-all peer-checked:border-gray-900 peer-checked:bg-gray-50 hover:border-gray-300">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-12 h-12 bg-gray-100 text-gray-900 rounded-full flex items-center justify-center text-2xl">
                                                    🏦
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-900">Chuyển khoản ngân hàng</p>
                                                    <p class="text-sm text-gray-500 mt-1">Chuyển khoản qua ngân hàng
                                                        (Internet Banking/QR Code)</p>
                                                </div>
                                            </div>
                                            <div
                                                class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-gray-900 peer-checked:bg-gray-900 flex items-center justify-center transition-colors">
                                                <div
                                                    class="w-2.5 h-2.5 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Bank Details (shown when selected) --}}
                                        <div
                                            class="hidden peer-checked:block bg-white rounded-xl p-6 mt-4 border border-gray-200 shadow-sm">
                                            <p class="text-gray-900 text-sm font-bold mb-4 flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                Thông tin chuyển khoản:
                                            </p>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                {{-- Techcombank --}}
                                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <span class="font-bold text-red-600">Techcombank</span>
                                                        <button type="button"
                                                            onclick="copyToClipboard('19037859362018', this)"
                                                            class="text-xs px-2.5 py-1.5 bg-white border border-gray-200 rounded-md text-gray-600 hover:text-blue-600 hover:border-blue-600 transition-all font-medium shadow-sm">
                                                            Sao chép
                                                        </button>
                                                    </div>
                                                    <p class="text-sm text-gray-500 mb-1">Số tài khoản</p>
                                                    <p class="text-lg font-mono font-bold text-gray-900 mb-2">19037859362018
                                                    </p>
                                                    <p class="text-sm text-gray-500 mb-1">Chủ tài khoản</p>
                                                    <p class="text-sm font-bold text-gray-900 uppercase">NGUYEN VAN A</p>
                                                </div>

                                                {{-- ACB --}}
                                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <span class="font-bold text-blue-600">ACB</span>
                                                        <button type="button" onclick="copyToClipboard('123456789', this)"
                                                            class="text-xs px-2.5 py-1.5 bg-white border border-gray-200 rounded-md text-gray-600 hover:text-blue-600 hover:border-blue-600 transition-all font-medium shadow-sm">
                                                            Sao chép
                                                        </button>
                                                    </div>
                                                    <p class="text-sm text-gray-500 mb-1">Số tài khoản</p>
                                                    <p class="text-lg font-mono font-bold text-gray-900 mb-2">123456789</p>
                                                    <p class="text-sm text-gray-500 mb-1">Chủ tài khoản</p>
                                                    <p class="text-sm font-bold text-gray-900 uppercase">NGUYEN VAN A</p>
                                                </div>
                                            </div>

                                            <div
                                                class="mt-4 p-3 bg-yellow-50 rounded-lg border border-yellow-100 flex items-start gap-3">
                                                <svg class="w-5 h-5 text-yellow-600 shrink-0 mt-0.5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                    </path>
                                                </svg>
                                                <p class="text-sm text-yellow-800">
                                                    Vui lòng ghi rõ nội dung chuyển khoản: <span class="font-bold">Họ tên +
                                                        Số điện thoại</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="absolute inset-0 border-2 border-gray-900 rounded-xl opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity">
                                    </div>
                                </label>
                            </div>

                            @error('payment_method')
                                <p class="text-red-500 text-sm mt-4 bg-red-50 p-3 rounded-lg flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror

                            <div class="flex flex-col sm:flex-row gap-4 mt-8 pt-6 border-t border-gray-100">
                                <a href="{{ route('checkout.shipping') }}"
                                    class="px-6 py-3.5 border-2 border-gray-200 text-gray-700 rounded-xl hover:border-gray-900 hover:text-gray-900 transition-all font-bold text-center">
                                    ← Quay lại
                                </a>
                                <button type="submit"
                                    class="flex-1 px-6 py-3.5 bg-gray-900 text-white rounded-xl hover:bg-gray-800 transition-all font-bold shadow-lg hover:shadow-gray-900/20 transform hover:-translate-y-0.5">
                                    Tiếp tục xác nhận
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h3 class="font-bold text-gray-900 text-lg mb-6">Đơn hàng ({{ $cart->items->count() }} sản phẩm)
                        </h3>

                        <div class="space-y-4 mb-6 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($cart->items as $item)
                                <div class="flex gap-4 group">
                                    <div
                                        class="w-16 h-16 bg-gray-50 rounded-lg overflow-hidden border border-gray-100 shrink-0">
                                        @if($item->product->images->first())
                                            <img src="{{ asset($item->product->images->first()->url) }}"
                                                alt="{{ $item->product->name }}"
                                                class="w-full h-full object-contain p-1 group-hover:scale-110 transition-transform duration-500">
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-gray-900 text-sm font-medium truncate mb-1">{{ $item->product->name }}
                                        </h4>
                                        <div class="flex justify-between items-center">
                                            <p class="text-gray-500 text-xs">SL: {{ $item->qty }}</p>
                                            <p class="text-gray-900 text-sm font-bold">
                                                {{ number_format($item->subtotal, 0, ',', '.') }}₫
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-100 pt-4 space-y-3">
                            <div class="flex justify-between text-gray-600">
                                <span>Tạm tính</span>
                                <span
                                    class="font-medium text-gray-900">{{ number_format($cart->getTotal(), 0, ',', '.') }}₫</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Phí vận chuyển</span>
                                <span class="text-gray-900 font-medium">30.000₫</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-4 mt-4">
                            <div class="flex justify-between items-end">
                                <span class="font-bold text-gray-900">Tổng cộng</span>
                                <span
                                    class="text-2xl font-bold text-gray-900">{{ number_format($cart->getTotal() + 30000, 0, ',', '.') }}₫</span>
                            </div>
                            <p class="text-right text-xs text-gray-400 mt-1">(Đã bao gồm VAT)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function copyToClipboard(text, button) {
                navigator.clipboard.writeText(text).then(() => {
                    const originalText = button.textContent;
                    button.textContent = '✓ Đã sao chép';
                    button.classList.add('bg-green-50', 'text-green-600', 'border-green-200');
                    button.classList.remove('text-gray-600', 'hover:text-blue-600', 'hover:border-blue-600');

                    setTimeout(() => {
                        button.textContent = originalText;
                        button.classList.remove('bg-green-50', 'text-green-600', 'border-green-200');
                        button.classList.add('text-gray-600', 'hover:text-blue-600', 'hover:border-blue-600');
                    }, 2000);
                }).catch(err => {
                    alert('Không thể sao chép. Vui lòng sao chép thủ công.');
                });
            }
        </script>
    @endpush
@endsection