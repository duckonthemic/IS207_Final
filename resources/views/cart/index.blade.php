@extends('layouts.app')

@section('title', 'Giỏ hàng - UITech')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-cyber-text mb-2">Giỏ hàng</h1>
        <p class="text-cyber-muted" id="cart-count">{{ $cart->items->count() }} sản phẩm</p>
    </div>

    @if($cart->items->isEmpty())
        <div class="bg-cyber-card border border-cyber-border rounded-lg p-12 text-center">
            <svg class="w-20 h-20 mx-auto mb-4 text-cyber-muted opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <p class="text-cyber-muted text-lg mb-6">Giỏ hàng của bạn trống</p>
            <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-cyber-accent text-cyber-darker rounded-lg hover:shadow-glow-cyan transition-all font-semibold">
                Tiếp tục mua sắm
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-4" id="cart-items">
                @foreach($cart->items as $item)
                    <div class="bg-cyber-card border border-cyber-border rounded-lg p-4 flex gap-4 hover:border-cyber-accent transition-colors" data-item-id="{{ $item->id }}">
                        {{-- Product Image --}}
                        <a href="{{ route('products.show', $item->product) }}" class="w-24 h-24 bg-cyber-darker rounded-lg flex-shrink-0 overflow-hidden">
                            @if($item->product->images->first())
                                <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover hover:scale-110 transition-transform">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-cyber-muted text-xs">No image</div>
                            @endif
                        </a>

                        {{-- Product Info --}}
                        <div class="flex-1">
                            <a href="{{ route('products.show', $item->product) }}" class="font-bold text-cyber-text hover:text-cyber-accent transition-colors">
                                {{ $item->product->name }}
                            </a>
                            <p class="text-cyber-muted text-sm mt-1">SKU: {{ $item->product->sku }}</p>
                            <p class="text-cyber-accent font-bold mt-2">{{ number_format($item->price, 0, ',', '.') }}₫</p>
                            @if($item->product->stock < 10)
                                <p class="text-cyber-error text-xs mt-1">Chỉ còn {{ $item->product->stock }} sản phẩm</p>
                            @endif
                        </div>

                        {{-- Quantity & Subtotal --}}
                        <div class="text-right flex flex-col justify-between">
                            <div>
                                <div class="inline-flex items-center gap-2 mb-2 bg-cyber-darker rounded-lg border border-cyber-border">
                                    <button onclick="updateQuantity({{ $item->id }}, -1)" class="px-3 py-2 hover:bg-cyber-accent/10 hover:text-cyber-accent transition-colors rounded-l-lg">−</button>
                                    <span class="w-10 text-center font-mono" data-qty="{{ $item->id }}">{{ $item->qty }}</span>
                                    <button onclick="updateQuantity({{ $item->id }}, 1)" class="px-3 py-2 hover:bg-cyber-accent/10 hover:text-cyber-accent transition-colors rounded-r-lg">+</button>
                                </div>
                                <p class="text-cyber-accent font-bold" data-subtotal="{{ $item->id }}">{{ number_format($item->subtotal, 0, ',', '.') }}₫</p>
                            </div>
                            <button onclick="removeItem({{ $item->id }})" class="text-cyber-error hover:text-cyber-error/80 text-sm transition-colors mt-2">
                                🗑️ Xóa
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Cart Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 sticky top-20">
                    <h3 class="font-bold text-cyber-text text-lg mb-4">Tóm tắt đơn hàng</h3>
                    
                    <div class="space-y-3 mb-6 border-t border-cyber-border pt-4">
                        <div class="flex justify-between text-cyber-text">
                            <span>Tạm tính:</span>
                            <span id="subtotal">{{ number_format($cart->getTotal(), 0, ',', '.') }}₫</span>
                        </div>
                        <div class="flex justify-between text-cyber-text">
                            <span>Phí vận chuyển:</span>
                            <span class="text-cyber-muted text-sm">Tính khi thanh toán</span>
                        </div>
                    </div>

                    <div class="flex justify-between font-bold text-cyber-accent text-xl mb-6 border-t border-cyber-border pt-4">
                        <span>Tổng cộng:</span>
                        <span id="total">{{ number_format($cart->getTotal(), 0, ',', '.') }}₫</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="w-full block text-center px-4 py-3 bg-cyber-accent text-cyber-darker rounded-lg hover:shadow-glow-cyan transition-all font-bold mb-3">
                        Tiến hành thanh toán
                    </a>

                    <a href="{{ route('products.index') }}" class="w-full block text-center px-4 py-2 border border-cyber-accent text-cyber-accent rounded-lg hover:bg-cyber-accent/10 transition-all">
                        Tiếp tục mua sắm
                    </a>
                    
                    <button onclick="clearCart()" class="w-full mt-3 px-4 py-2 text-cyber-error border border-cyber-error rounded-lg hover:bg-cyber-error/10 transition-all text-sm">
                        Xóa toàn bộ giỏ hàng
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function updateQuantity(itemId, change) {
    const qtyElement = document.querySelector(`[data-qty="${itemId}"]`);
    const currentQty = parseInt(qtyElement.textContent);
    const newQty = currentQty + change;
    
    if (newQty < 1) {
        if (confirm('Xóa sản phẩm này khỏi giỏ hàng?')) {
            removeItem(itemId);
        }
        return;
    }
    
    // Disable buttons during request
    qtyElement.textContent = '...';
    
    fetch(`/cart/${itemId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ qty: newQty })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update quantity display
            qtyElement.textContent = newQty;
            
            // Update subtotal for this item
            const subtotalElement = document.querySelector(`[data-subtotal="${itemId}"]`);
            const price = parseInt(subtotalElement.textContent.replace(/[^\d]/g, '')) / currentQty;
            subtotalElement.textContent = formatMoney(price * newQty);
            
            // Update cart totals
            updateCartTotals(data.cart_total);
            
            // Show success message
            showToast('Đã cập nhật số lượng', 'success');
        } else {
            qtyElement.textContent = currentQty;
            showToast(data.message || 'Có lỗi xảy ra', 'error');
        }
    })
    .catch(error => {
        qtyElement.textContent = currentQty;
        showToast('Có lỗi xảy ra', 'error');
    });
}

function removeItem(itemId) {
    fetch(`/cart/${itemId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove item from DOM
            const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
            itemElement.style.opacity = '0';
            setTimeout(() => itemElement.remove(), 300);
            
            // Update cart totals
            updateCartTotals(data.cart_total);
            
            // Update cart count
            const cartCount = document.getElementById('cart-count');
            const currentCount = parseInt(cartCount.textContent);
            cartCount.textContent = `${currentCount - 1} sản phẩm`;
            
            // Show empty state if no items left
            if (data.item_count === 0) {
                setTimeout(() => location.reload(), 500);
            }
            
            showToast('Đã xóa sản phẩm', 'success');
        } else {
            showToast(data.message || 'Có lỗi xảy ra', 'error');
        }
    })
    .catch(error => {
        showToast('Có lỗi xảy ra', 'error');
    });
}

function clearCart() {
    if (!confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')) return;
    
    fetch('/cart/clear', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            showToast(data.message || 'Có lỗi xảy ra', 'error');
        }
    })
    .catch(error => {
        showToast('Có lỗi xảy ra', 'error');
    });
}

function updateCartTotals(total) {
    document.getElementById('subtotal').textContent = formatMoney(total);
    document.getElementById('total').textContent = formatMoney(total);
}

function formatMoney(amount) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount).replace('₫', '₫');
}

function showToast(message, type) {
    // Use existing toast from layout
    const toast = document.getElementById('toast');
    if (toast) {
        toast.querySelector('p').textContent = message;
        toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-cyber-glow text-cyber-darker' : 'bg-cyber-error text-white'}`;
        toast.style.display = 'block';
        setTimeout(() => toast.style.display = 'none', 3000);
    }
}
</script>
@endpush
@endsection
