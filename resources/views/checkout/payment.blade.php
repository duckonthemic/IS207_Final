@extends('layouts.app')

@section('title', 'Thanh toán - UITech')

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
                <div class="w-16 h-1 bg-cyber-accent mx-4"></div>
                <div class="flex items-center text-cyber-accent">
                    <div class="rounded-full h-10 w-10 bg-cyber-accent text-cyber-darker flex items-center justify-center font-bold">2</div>
                    <span class="ml-2 font-semibold">Thanh toán</span>
                </div>
                <div class="w-16 h-1 bg-cyber-border mx-4"></div>
                <div class="flex items-center text-cyber-muted">
                    <div class="rounded-full h-10 w-10 bg-cyber-darker border-2 border-cyber-border flex items-center justify-center">3</div>
                    <span class="ml-2">Xác nhận</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Payment Method Selection --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Selected Shipping Address --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-cyber-text">Địa chỉ giao hàng</h3>
                    <a href="{{ route('checkout.shipping') }}" class="text-cyber-accent text-sm hover:underline">Thay đổi</a>
                </div>
                <div class="text-cyber-text">
                    <p class="font-semibold">{{ $address->fullname }}</p>
                    <p class="text-sm text-cyber-muted mt-1">{{ $address->phone }}</p>
                    <p class="text-sm mt-1">
                        {{ $address->address }}
                        @if($address->ward), {{ $address->ward }}@endif
                        @if($address->district), {{ $address->district }}@endif
                        @if($address->city), {{ $address->city }}@endif
                    </p>
                </div>
            </div>

            {{-- Payment Methods --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-text mb-6">Phương thức thanh toán</h2>

                <form method="POST" action="{{ route('checkout.store-payment') }}" id="payment-form">
                    @csrf
                    
                    <div class="space-y-4">
                        {{-- COD --}}
                        <label class="block cursor-pointer">
                            <input type="radio" name="payment_method" value="cod" class="hidden peer" checked required>
                            <div class="border-2 border-cyber-border peer-checked:border-cyber-accent rounded-lg p-4 hover:border-cyber-accent/50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-cyber-darker rounded-lg flex items-center justify-center text-2xl">
                                            💵
                                        </div>
                                        <div>
                                            <p class="font-bold text-cyber-text">Thanh toán khi nhận hàng (COD)</p>
                                            <p class="text-sm text-cyber-muted mt-1">Thanh toán bằng tiền mặt khi nhận hàng</p>
                                        </div>
                                    </div>
                                    <svg class="w-6 h-6 text-cyber-accent hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </label>

                        {{-- Bank Transfer --}}
                        <label class="block cursor-pointer">
                            <input type="radio" name="payment_method" value="bank_transfer" class="hidden peer" required>
                            <div class="border-2 border-cyber-border peer-checked:border-cyber-accent rounded-lg p-4 hover:border-cyber-accent/50 transition-colors">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-cyber-darker rounded-lg flex items-center justify-center text-2xl">
                                            🏦
                                        </div>
                                        <div>
                                            <p class="font-bold text-cyber-text">Chuyển khoản ngân hàng</p>
                                            <p class="text-sm text-cyber-muted mt-1">Chuyển khoản qua ngân hàng</p>
                                        </div>
                                    </div>
                                    <svg class="w-6 h-6 text-cyber-accent hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                
                                {{-- Bank Details (shown when selected) --}}
                                <div class="hidden peer-checked:block bg-cyber-darker rounded-lg p-4 mt-4 space-y-4">
                                    <p class="text-cyber-accent text-sm font-semibold">Thông tin chuyển khoản:</p>
                                    
                                    {{-- Techcombank --}}
                                    <div class="border border-cyber-border rounded p-3">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-bold text-cyber-text">Techcombank</span>
                                            <button type="button" onclick="copyToClipboard('19037859362018', this)" class="text-xs px-2 py-1 bg-cyber-accent/20 text-cyber-accent rounded hover:bg-cyber-accent/30 transition-colors">
                                                Copy STK
                                            </button>
                                        </div>
                                        <p class="text-sm text-cyber-muted">STK: <span class="text-cyber-text font-mono">19037859362018</span></p>
                                        <p class="text-sm text-cyber-muted">Chủ TK: <span class="text-cyber-text">NGUYEN VAN A</span></p>
                                    </div>

                                    {{-- ACB --}}
                                    <div class="border border-cyber-border rounded p-3">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-bold text-cyber-text">ACB</span>
                                            <button type="button" onclick="copyToClipboard('123456789', this)" class="text-xs px-2 py-1 bg-cyber-accent/20 text-cyber-accent rounded hover:bg-cyber-accent/30 transition-colors">
                                                Copy STK
                                            </button>
                                        </div>
                                        <p class="text-sm text-cyber-muted">STK: <span class="text-cyber-text font-mono">123456789</span></p>
                                        <p class="text-sm text-cyber-muted">Chủ TK: <span class="text-cyber-text">NGUYEN VAN A</span></p>
                                    </div>

                                    <p class="text-xs text-cyber-error">⚠️ Vui lòng ghi rõ nội dung: <span class="font-mono text-cyber-accent">Họ tên + Số điện thoại</span></p>
                                </div>
                            </div>
                        </label>
                    </div>

                    @error('payment_method')
                        <p class="text-cyber-error text-sm mt-4">{{ $message }}</p>
                    @enderror

                    <div class="flex gap-4 mt-6">
                        <a href="{{ route('checkout.shipping') }}" class="px-6 py-3 border border-cyber-border text-cyber-text rounded-lg hover:border-cyber-accent transition-all">
                            ← Quay lại
                        </a>
                        <button type="submit" class="flex-1 px-6 py-3 bg-cyber-accent text-cyber-darker rounded-lg hover:shadow-glow-cyan transition-all font-bold">
                            Tiếp tục xác nhận
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="lg:col-span-1">
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 sticky top-20">
                <h3 class="font-bold text-cyber-text text-lg mb-4">Đơn hàng ({{ $cart->items->count() }} sản phẩm)</h3>
                
                <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                    @foreach($cart->items as $item)
                        <div class="flex gap-3">
                            <div class="w-16 h-16 bg-cyber-darker rounded flex-shrink-0 overflow-hidden">
                                @if($item->product->images->first())
                                    <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-cyber-text text-sm font-medium truncate">{{ $item->product->name }}</p>
                                <p class="text-cyber-muted text-xs">SL: {{ $item->qty }}</p>
                                <p class="text-cyber-accent text-sm font-bold">{{ number_format($item->subtotal, 0, ',', '.') }}₫</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-cyber-border pt-4 space-y-2">
                    <div class="flex justify-between text-cyber-text">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($cart->getTotal(), 0, ',', '.') }}₫</span>
                    </div>
                    <div class="flex justify-between text-cyber-text">
                        <span>Phí vận chuyển:</span>
                        <span>30,000₫</span>
                    </div>
                </div>

                <div class="border-t border-cyber-border pt-4 mt-4">
                    <div class="flex justify-between font-bold text-cyber-accent text-xl">
                        <span>Tổng cộng:</span>
                        <span>{{ number_format($cart->getTotal() + 30000, 0, ',', '.') }}₫</span>
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
        button.textContent = '✓ Đã copy';
        button.classList.add('bg-cyber-glow/30', 'text-cyber-glow');
        button.classList.remove('bg-cyber-accent/20', 'text-cyber-accent');
        
        setTimeout(() => {
            button.textContent = originalText;
            button.classList.remove('bg-cyber-glow/30', 'text-cyber-glow');
            button.classList.add('bg-cyber-accent/20', 'text-cyber-accent');
        }, 2000);
    }).catch(err => {
        alert('Không thể copy. Vui lòng copy thủ công.');
    });
}
</script>
@endpush
@endsection
