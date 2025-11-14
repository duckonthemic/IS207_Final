@extends('layouts.app')

@section('title', 'Giao hàng - UITech')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Progress Steps --}}
    <div class="mb-8">
        <div class="flex items-center justify-center">
            <div class="flex items-center">
                <div class="flex items-center text-cyber-accent">
                    <div class="rounded-full h-10 w-10 bg-cyber-accent text-cyber-darker flex items-center justify-center font-bold">1</div>
                    <span class="ml-2 font-semibold">Giao hàng</span>
                </div>
                <div class="w-16 h-1 bg-cyber-border mx-4"></div>
                <div class="flex items-center text-cyber-muted">
                    <div class="rounded-full h-10 w-10 bg-cyber-darker border-2 border-cyber-border flex items-center justify-center">2</div>
                    <span class="ml-2">Thanh toán</span>
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
        {{-- Shipping Address Selection --}}
        <div class="lg:col-span-2">
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-text mb-6">Chọn địa chỉ giao hàng</h2>

                @if($addresses->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-cyber-muted mb-4">Bạn chưa có địa chỉ giao hàng nào</p>
                        <a href="{{ route('addresses.create') }}" class="inline-block px-6 py-3 bg-cyber-accent text-cyber-darker rounded-lg hover:shadow-glow-cyan transition-all font-semibold">
                            Thêm địa chỉ mới
                        </a>
                    </div>
                @else
                    <form method="POST" action="{{ route('checkout.store-shipping') }}" id="shipping-form">
                        @csrf
                        
                        <div class="space-y-4 mb-6">
                            @foreach($addresses as $address)
                                <label class="block cursor-pointer">
                                    <input type="radio" name="address_id" value="{{ $address->id }}" 
                                           class="hidden peer" 
                                           {{ ($defaultAddress && $defaultAddress->id === $address->id) || old('address_id') == $address->id ? 'checked' : '' }}
                                           required>
                                    <div class="border-2 border-cyber-border peer-checked:border-cyber-accent rounded-lg p-4 hover:border-cyber-accent/50 transition-colors">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span class="font-bold text-cyber-text">{{ $address->fullname }}</span>
                                                    @if($address->is_default)
                                                        <span class="px-2 py-0.5 bg-cyber-accent/20 text-cyber-accent text-xs rounded">Mặc định</span>
                                                    @endif
                                                </div>
                                                <p class="text-cyber-muted text-sm mb-1">{{ $address->phone }}</p>
                                                <p class="text-cyber-text text-sm">
                                                    {{ $address->address }}
                                                    @if($address->ward), {{ $address->ward }}@endif
                                                    @if($address->district), {{ $address->district }}@endif
                                                    @if($address->city), {{ $address->city }}@endif
                                                    @if($address->postal_code) {{ $address->postal_code }}@endif
                                                </p>
                                            </div>
                                            <div class="ml-4">
                                                <svg class="w-6 h-6 text-cyber-accent hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        @error('address_id')
                            <p class="text-cyber-error text-sm mb-4">{{ $message }}</p>
                        @enderror

                        <div class="flex gap-4">
                            <a href="{{ route('addresses.create') }}" class="px-6 py-3 border border-cyber-accent text-cyber-accent rounded-lg hover:bg-cyber-accent/10 transition-all">
                                + Thêm địa chỉ mới
                            </a>
                            <button type="submit" class="flex-1 px-6 py-3 bg-cyber-accent text-cyber-darker rounded-lg hover:shadow-glow-cyan transition-all font-bold">
                                Tiếp tục đến thanh toán
                            </button>
                        </div>
                    </form>
                @endif
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
                        <span class="text-cyber-muted text-sm">Tính ở bước tiếp theo</span>
                    </div>
                </div>

                <div class="border-t border-cyber-border pt-4 mt-4">
                    <div class="flex justify-between font-bold text-cyber-accent text-xl">
                        <span>Tổng cộng:</span>
                        <span>{{ number_format($cart->getTotal(), 0, ',', '.') }}₫</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
