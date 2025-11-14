@extends('layouts.app')

@section('title', 'Thanh toán - UITech')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-12">
        <h1 class="text-3xl font-bold text-cyber-text mb-4">Thanh toán</h1>
        <div class="flex gap-8 mb-8">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-full bg-cyber-accent text-cyber-darker flex items-center justify-center font-bold">1</div>
                    <span class="text-cyber-text font-semibold">Địa chỉ giao hàng</span>
                </div>
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-full bg-cyber-accent/30 text-cyber-accent flex items-center justify-center font-bold">2</div>
                    <span class="text-cyber-muted font-semibold">Mã giảm giá</span>
                </div>
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-full bg-cyber-accent/30 text-cyber-accent flex items-center justify-center font-bold">3</div>
                    <span class="text-cyber-muted font-semibold">Phương thức thanh toán</span>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('checkout.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf

        <div class="lg:col-span-2 space-y-6">
            {{-- Shipping Address --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-text mb-4">Địa chỉ giao hàng</h2>

                @if(auth()->user()->addresses->isNotEmpty())
                    <div class="space-y-3 mb-6">
                        @foreach(auth()->user()->addresses as $address)
                            <label class="flex items-start gap-3 p-4 border border-cyber-border rounded cursor-pointer hover:border-cyber-accent">
                                <input type="radio" name="address_id" value="{{ $address->id }}" {{ $loop->first ? 'checked' : '' }} class="mt-1">
                                <div class="flex-1">
                                    <p class="text-cyber-text font-semibold">{{ $address->full_name }}</p>
                                    <p class="text-cyber-muted text-sm">{{ $address->phone_number }}</p>
                                    <p class="text-cyber-muted text-sm">{{ $address->street }} {{ $address->ward }}, {{ $address->district }}, {{ $address->province }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @endif

                <button type="button" class="w-full px-4 py-2 border border-cyber-accent text-cyber-accent rounded font-semibold hover:bg-cyber-accent/10">
                    + Thêm địa chỉ mới
                </button>
            </div>

            {{-- Promotion Code --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-text mb-4">Mã giảm giá</h2>
                <div class="flex gap-2">
                    <input type="text" name="promo_code" placeholder="Nhập mã giảm giá..." class="flex-1 px-4 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none">
                    <button type="button" class="px-6 py-2 bg-cyber-accent text-cyber-darker rounded font-semibold hover:shadow-glow-cyan">
                        Áp dụng
                    </button>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-text mb-4">Phương thức thanh toán</h2>
                <div class="space-y-3">
                    <label class="flex items-center gap-3 p-3 border border-cyber-border rounded cursor-pointer hover:border-cyber-accent">
                        <input type="radio" name="payment_method" value="cod" checked class="rounded">
                        <div>
                            <p class="text-cyber-text font-semibold">Thanh toán khi nhận hàng</p>
                            <p class="text-cyber-muted text-sm">Thanh toán bằng tiền mặt khi nhận hàng</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3 border border-cyber-border rounded cursor-pointer hover:border-cyber-accent">
                        <input type="radio" name="payment_method" value="bank" class="rounded">
                        <div>
                            <p class="text-cyber-text font-semibold">Chuyển khoản ngân hàng</p>
                            <p class="text-cyber-muted text-sm">Chuyển tiền trực tiếp vào tài khoản ngân hàng</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3 border border-cyber-border rounded cursor-pointer hover:border-cyber-accent opacity-50">
                        <input type="radio" name="payment_method" value="card" disabled class="rounded">
                        <div>
                            <p class="text-cyber-text font-semibold">Thẻ tín dụng</p>
                            <p class="text-cyber-muted text-sm">Sắp có</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="lg:col-span-1">
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 sticky top-20">
                <h3 class="text-xl font-bold text-cyber-text mb-4">Tóm tắt đơn hàng</h3>

                {{-- Items --}}
                <div class="space-y-2 mb-4 max-h-48 overflow-y-auto">
                    @foreach($cart->items as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-cyber-muted">{{ $item->product->name }} x{{ $item->qty }}</span>
                            <span class="text-cyber-text">{{ number_format($item->subtotal, 0, ',', '.') }}₫</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-cyber-border pt-4 space-y-3 mb-4">
                    <div class="flex justify-between text-cyber-muted">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($cart->getTotal(), 0, ',', '.') }}₫</span>
                    </div>
                    <div class="flex justify-between text-cyber-muted">
                        <span>Phí vận chuyển:</span>
                        <span>0₫</span>
                    </div>
                    <div id="discount-row" class="flex justify-between text-cyber-success hidden">
                        <span>Giảm giá:</span>
                        <span id="discount-amount">-0₫</span>
                    </div>
                </div>

                <div class="flex justify-between font-bold text-lg text-cyber-accent border-t border-cyber-border pt-4 mb-6">
                    <span>Tổng cộng:</span>
                    <span id="total-amount">{{ number_format($cart->getTotal(), 0, ',', '.') }}₫</span>
                </div>

                <button type="submit" class="w-full px-4 py-3 bg-cyber-accent text-cyber-darker rounded-lg font-bold hover:shadow-glow-cyan transition-all">
                    Xác nhận đơn hàng
                </button>

                <a href="{{ route('cart.index') }}" class="w-full block text-center px-4 py-3 mt-2 border border-cyber-border text-cyber-text rounded-lg hover:border-cyber-accent">
                    Quay lại giỏ hàng
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
