@extends('layouts.app')

@section('title', 'Xác nhận đơn hàng - UITech')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Progress Steps --}}
    <div class="mb-8">
        <div class="flex items-center justify-center">
            <div class="flex items-center">
                <div class="flex items-center text-cyber-glow">
                    <div class="rounded-full h-10 w-10 bg-cyber-glow text-cyber-darker flex items-center justify-center font-bold">✓</div>
                    <span class="ml-2">Giao hàng</span>
                </div>
                <div class="w-16 h-1 bg-cyber-glow mx-4"></div>
                <div class="flex items-center text-cyber-glow">
                    <div class="rounded-full h-10 w-10 bg-cyber-glow text-cyber-darker flex items-center justify-center font-bold">✓</div>
                    <span class="ml-2">Thanh toán</span>
                </div>
                <div class="w-16 h-1 bg-cyber-accent mx-4"></div>
                <div class="flex items-center text-cyber-accent">
                    <div class="rounded-full h-10 w-10 bg-cyber-accent text-cyber-darker flex items-center justify-center font-bold">3</div>
                    <span class="ml-2 font-semibold">Xác nhận</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            {{-- Order Items --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-text mb-6">Sản phẩm đặt mua</h2>
                
                <div class="space-y-4">
                    @foreach($cart->items as $item)
                        <div class="flex gap-4 pb-4 border-b border-cyber-border last:border-0">
                            <div class="w-20 h-20 bg-cyber-darker rounded-lg flex-shrink-0 overflow-hidden">
                                @if($item->product->images->first())
                                    <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-cyber-muted text-xs">No image</div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-cyber-text">{{ $item->product->name }}</h3>
                                <p class="text-cyber-muted text-sm mt-1">SKU: {{ $item->product->sku }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-cyber-muted text-sm">Số lượng: {{ $item->qty }}</span>
                                    <span class="text-cyber-accent font-bold">{{ number_format($item->subtotal, 0, ',', '.') }}₫</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-cyber-text text-lg">Địa chỉ giao hàng</h3>
                    <a href="{{ route('checkout.shipping') }}" class="text-cyber-accent text-sm hover:underline">Thay đổi</a>
                </div>
                <div class="bg-cyber-darker rounded-lg p-4">
                    <p class="font-semibold text-cyber-text">{{ $address->fullname }}</p>
                    <p class="text-sm text-cyber-muted mt-1">📱 {{ $address->phone }}</p>
                    <p class="text-sm text-cyber-text mt-2">
                        📍 {{ $address->address }}
                        @if($address->ward), {{ $address->ward }}@endif
                        @if($address->district), {{ $address->district }}@endif
                        @if($address->city), {{ $address->city }}@endif
                        @if($address->postal_code) {{ $address->postal_code }}@endif
                    </p>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-cyber-text text-lg">Phương thức thanh toán</h3>
                    <a href="{{ route('checkout.payment') }}" class="text-cyber-accent text-sm hover:underline">Thay đổi</a>
                </div>
                <div class="bg-cyber-darker rounded-lg p-4 flex items-center gap-3">
                    <div class="text-2xl">
                        @if($paymentMethod === 'cod')
                            💵
                        @else
                            🏦
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold text-cyber-text">
                            @if($paymentMethod === 'cod')
                                Thanh toán khi nhận hàng (COD)
                            @else
                                Chuyển khoản ngân hàng
                            @endif
                        </p>
                        <p class="text-sm text-cyber-muted mt-1">
                            @if($paymentMethod === 'cod')
                                Thanh toán bằng tiền mặt khi nhận hàng
                            @else
                                Vui lòng chuyển khoản theo thông tin đã cung cấp
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Place Order Form --}}
            <form method="POST" action="{{ route('checkout.place-order') }}" id="place-order-form">
                @csrf
                <div class="flex gap-4">
                    <a href="{{ route('checkout.payment') }}" class="px-6 py-3 border border-cyber-border text-cyber-text rounded-lg hover:border-cyber-accent transition-all">
                        ← Quay lại
                    </a>
                    <button type="submit" class="flex-1 px-6 py-4 bg-cyber-accent text-cyber-darker rounded-lg hover:shadow-glow-cyan transition-all font-bold text-lg">
                        🛒 Đặt hàng
                    </button>
                </div>
            </form>
        </div>

        {{-- Order Summary --}}
        <div class="lg:col-span-1">
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 sticky top-20">
                <h3 class="font-bold text-cyber-text text-lg mb-4">Tóm tắt đơn hàng</h3>
                
                <div class="space-y-3 pb-4 border-b border-cyber-border">
                    <div class="flex justify-between text-cyber-text">
                        <span>Tạm tính ({{ $cart->items->count() }} sản phẩm):</span>
                        <span>{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                    </div>
                    <div class="flex justify-between text-cyber-text">
                        <span>Phí vận chuyển:</span>
                        <span>{{ number_format($shippingFee, 0, ',', '.') }}₫</span>
                    </div>
                </div>

                <div class="py-4 border-b border-cyber-border">
                    <div class="flex justify-between font-bold text-cyber-accent text-2xl">
                        <span>Tổng cộng:</span>
                        <span>{{ number_format($total, 0, ',', '.') }}₫</span>
                    </div>
                </div>

                <div class="mt-4 space-y-3">
                    <div class="flex items-start gap-2 text-sm text-cyber-muted">
                        <svg class="w-5 h-5 text-cyber-glow flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Giao hàng trong 2-3 ngày làm việc</span>
                    </div>
                    <div class="flex items-start gap-2 text-sm text-cyber-muted">
                        <svg class="w-5 h-5 text-cyber-glow flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Kiểm tra hàng trước khi thanh toán (COD)</span>
                    </div>
                    <div class="flex items-start gap-2 text-sm text-cyber-muted">
                        <svg class="w-5 h-5 text-cyber-glow flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Bảo hành chính hãng theo quy định</span>
                    </div>
                </div>

                @if($paymentMethod === 'bank_transfer')
                    <div class="mt-6 p-4 bg-cyber-error/10 border border-cyber-error/30 rounded-lg">
                        <p class="text-sm text-cyber-error font-semibold mb-2">⚠️ Lưu ý quan trọng:</p>
                        <p class="text-xs text-cyber-error">
                            Đơn hàng sẽ được xử lý sau khi chúng tôi nhận được xác nhận chuyển khoản thành công. 
                            Vui lòng ghi rõ nội dung: <span class="font-mono bg-cyber-darker px-1 rounded">{{ $address->fullname }} {{ $address->phone }}</span>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('place-order-form').addEventListener('submit', function(e) {
    const button = this.querySelector('button[type="submit"]');
    button.disabled = true;
    button.innerHTML = '⏳ Đang xử lý...';
    button.classList.add('opacity-50', 'cursor-not-allowed');
});
</script>
@endpush
@endsection
