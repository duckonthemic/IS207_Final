@extends('layouts.app')

@section('title', 'Xác nhận đơn hàng - UITech')

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
                        <div class="flex items-center text-green-600">
                            <div
                                class="h-10 w-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg shadow-green-500/30">
                                ✓</div>
                            <span class="ml-3 font-medium text-gray-900">Thanh toán</span>
                        </div>
                        <div class="w-24 h-1 bg-green-600 mx-4 rounded-full"></div>
                        <div class="flex items-center text-gray-900">
                            <div
                                class="h-10 w-10 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold shadow-lg shadow-gray-900/20">
                                3</div>
                            <span class="ml-3 font-bold text-gray-900">Xác nhận</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-8 space-y-6">
                    {{-- Review Information --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-gray-900">Kiểm tra thông tin đơn hàng</h2>
                            <p class="text-sm text-gray-500 mt-1">Vui lòng kiểm tra kỹ thông tin trước khi đặt hàng</p>
                        </div>

                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Shipping Info --}}
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Địa chỉ giao hàng
                                    </h3>
                                    <a href="{{ route('checkout.shipping') }}"
                                        class="text-gray-900 text-sm font-medium hover:text-gray-700 hover:underline transition-colors">Sửa</a>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 h-full">
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

                            {{-- Payment Info --}}
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                            </path>
                                        </svg>
                                        Phương thức thanh toán
                                    </h3>
                                    <a href="{{ route('checkout.payment') }}"
                                        class="text-gray-900 text-sm font-medium hover:text-gray-700 hover:underline transition-colors">Sửa</a>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 h-full flex items-center">
                                    @if($paymentMethod == 'cod')
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xl">
                                                💵</div>
                                            <div>
                                                <p class="font-bold text-gray-900">Thanh toán khi nhận hàng (COD)</p>
                                                <p class="text-xs text-gray-500 mt-0.5">Thanh toán tiền mặt</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-gray-100 text-gray-900 rounded-full flex items-center justify-center text-xl">
                                                🏦</div>
                                            <div>
                                                <p class="font-bold text-gray-900">Chuyển khoản ngân hàng</p>
                                                <p class="text-xs text-gray-500 mt-0.5">Internet Banking / QR Code</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order Items --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="font-bold text-gray-900 text-lg">Chi tiết đơn hàng</h3>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @foreach($cart->items as $item)
                                <div class="p-6 flex gap-6 hover:bg-gray-50 transition-colors">
                                    <div
                                        class="w-24 h-24 bg-gray-50 rounded-xl overflow-hidden border border-gray-100 shrink-0">
                                        @if($item->product->images->first())
                                            <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product->name }}"
                                                class="w-full h-full object-contain p-2">
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0 flex flex-col justify-center">
                                        <h4 class="text-gray-900 font-bold text-lg mb-1 truncate">{{ $item->product->name }}
                                        </h4>
                                        <p class="text-sm text-gray-500 mb-2">Đơn giá:
                                            {{ number_format($item->price, 0, ',', '.') }}₫</p>
                                        <div class="flex items-center justify-between">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                x{{ $item->qty }}
                                            </span>
                                            <span
                                                class="text-gray-900 font-bold text-lg">{{ number_format($item->subtotal, 0, ',', '.') }}₫</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ route('checkout.payment') }}"
                            class="px-6 py-3.5 border-2 border-gray-200 text-gray-700 rounded-xl hover:border-gray-900 hover:text-gray-900 transition-all font-bold text-center">
                            ← Quay lại
                        </a>
                        <form action="{{ route('checkout.place-order') }}" method="POST" class="flex-1"
                            id="place-order-form">
                            @csrf
                            <button type="submit"
                                class="w-full px-6 py-3.5 bg-gray-900 text-white rounded-xl hover:bg-gray-800 transition-all font-bold shadow-lg hover:shadow-gray-900/20 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <span>Đặt hàng ngay</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h3 class="font-bold text-gray-900 text-lg mb-6">Tổng quan đơn hàng</h3>

                        <div class="space-y-4">
                            <div class="flex justify-between text-gray-600">
                                <span>Tạm tính</span>
                                <span
                                    class="font-medium text-gray-900">{{ number_format($cart->getTotal(), 0, ',', '.') }}₫</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Phí vận chuyển</span>
                                <span class="text-gray-900 font-medium">30.000₫</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Giảm giá</span>
                                <span class="text-green-600 font-medium">-0₫</span>
                            </div>

                            <div class="border-t border-gray-100 pt-4 mt-4">
                                <div class="flex justify-between items-end mb-1">
                                    <span class="font-bold text-gray-900 text-lg">Tổng thanh toán</span>
                                    <span
                                        class="text-3xl font-bold text-gray-900">{{ number_format($cart->getTotal() + 30000, 0, ',', '.') }}₫</span>
                                </div>
                                <p class="text-right text-xs text-gray-400">(Đã bao gồm VAT)</p>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 text-gray-900 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                                <p class="text-sm text-gray-700">
                                    Bằng việc đặt hàng, bạn đồng ý với <a href="#"
                                        class="font-bold underline hover:text-gray-900">Điều khoản dịch vụ</a> và <a
                                        href="#" class="font-bold underline hover:text-gray-900">Chính sách bảo mật</a> của
                                    chúng tôi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('place-order-form').addEventListener('submit', function (e) {
                const button = this.querySelector('button[type="submit"]');
                button.disabled = true;
                button.innerHTML = '⏳ Đang xử lý...';
                button.classList.add('opacity-50', 'cursor-not-allowed');
            });
        </script>
    @endpush
@endsection