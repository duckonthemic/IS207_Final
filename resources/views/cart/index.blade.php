@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12 font-sans">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Giỏ hàng của bạn</h1>
                <span class="text-gray-500 font-medium" id="cart-count-header">{{ $cart ? $cart->items->count() : 0 }} sản
                    phẩm</span>
            </div>

            @if(!$cart || $cart->items->count() === 0)
                <div class="bg-white rounded-2xl shadow-sm p-16 text-center border border-gray-100">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">Giỏ hàng của bạn đang trống</h2>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Có vẻ như bạn chưa thêm sản phẩm nào. Hãy khám phá các sản
                        phẩm công nghệ mới nhất của chúng tôi.</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-full text-white bg-gray-900 hover:bg-gray-800 transition-all shadow-lg hover:shadow-gray-900/20 transform hover:-translate-y-0.5">
                        Tiếp tục mua sắm
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    {{-- Cart Items List --}}
                    <div class="lg:col-span-8 space-y-4" id="cart-items-container">
                        @foreach($cart->items as $item)
                            <div class="bg-white rounded-2xl shadow-sm p-6 flex gap-6 items-center group transition-all hover:shadow-md border border-gray-100"
                                data-item-id="{{ $item->id }}">
                                {{-- Product Image --}}
                                <div
                                    class="w-28 h-28 shrink-0 bg-gray-50 rounded-xl overflow-hidden border border-gray-100 relative">
                                    <img src="{{ $item->product->image_url ?? asset('images/no-image.png') }}"
                                        alt="{{ $item->product->name }}"
                                        class="w-full h-full object-contain p-2 group-hover:scale-110 transition-transform duration-500">
                                </div>

                                {{-- Product Info --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900 truncate pr-4 leading-tight">
                                                <a href="{{ route('products.show', $item->product) }}"
                                                    class="hover:text-blue-600 transition-colors">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $item->product->category->name ?? 'Linh kiện' }}</p>
                                        </div>
                                        <button onclick="removeItem({{ $item->id }})"
                                            class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-50 group/delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="flex items-center justify-between mt-4">
                                        {{-- Quantity Control --}}
                                        <div class="flex items-center bg-gray-50 rounded-full border border-gray-200 p-1">
                                            <button onclick="updateQuantity({{ $item->id }}, -1)"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-600 shadow-sm hover:bg-gray-100 hover:text-blue-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                                {{ $item->qty <= 1 ? 'disabled' : '' }}>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <span class="w-10 text-center text-sm font-bold text-gray-900"
                                                data-qty="{{ $item->id }}">{{ $item->qty }}</span>
                                            <button onclick="updateQuantity({{ $item->id }}, 1)"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-600 shadow-sm hover:bg-gray-100 hover:text-blue-600 transition-colors">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        {{-- Price --}}
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-gray-900" data-subtotal="{{ $item->id }}">
                                                {{ number_format($item->subtotal, 0, ',', '.') }}₫
                                            </div>
                                            <div class="text-xs text-gray-400 font-medium">
                                                {{ number_format($item->price, 0, ',', '.') }}₫ / cái
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Order Summary --}}
                    <div class="lg:col-span-4">
                        <div class="bg-white rounded-2xl shadow-sm p-8 sticky top-24 border border-gray-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Tổng đơn hàng</h3>

                            <div class="space-y-4 mb-8">
                                <div class="flex justify-between text-gray-600">
                                    <span>Tạm tính</span>
                                    <span class="font-medium text-gray-900"
                                        id="summary-subtotal">{{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}₫</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Phí vận chuyển</span>
                                    <span class="text-green-600 font-medium bg-green-50 px-2 py-1 rounded text-xs">Miễn
                                        phí</span>
                                </div>
                                <div class="border-t border-gray-100 pt-4 flex justify-between items-end">
                                    <span class="font-bold text-gray-900 text-lg">Tổng cộng</span>
                                    <div class="text-right">
                                        <span class="block text-2xl font-bold text-gray-900"
                                            id="summary-total">{{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}₫</span>
                                        <span class="text-xs text-gray-500 font-medium">(Đã bao gồm VAT)</span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('checkout.index') }}"
                                class="block w-full bg-gray-900 text-white text-center py-4 rounded-xl font-bold hover:bg-gray-800 transition-all shadow-lg hover:shadow-gray-900/20 transform hover:-translate-y-0.5">
                                Tiến hành thanh toán
                            </a>

                            <div class="mt-6 flex items-center justify-center gap-2 text-gray-400 text-xs font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <span>Bảo mật thanh toán 100%</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function updateQuantity(itemId, change) {
                const qtyElement = document.querySelector(`[data-qty="${itemId}"]`);
                const currentQty = parseInt(qtyElement.textContent);
                const newQty = currentQty + change;

                if (newQty < 1) return;

                // Optimistic UI update
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
                            subtotalElement.textContent = formatMoney(data.subtotal);

                            // Update cart totals
                            updateCartTotals(data.cart_total);

                            // Update button state
                            const minusBtn = qtyElement.previousElementSibling;
                            if (newQty <= 1) {
                                minusBtn.setAttribute('disabled', 'disabled');
                            } else {
                                minusBtn.removeAttribute('disabled');
                            }
                        } else {
                            qtyElement.textContent = currentQty;
                            alert(data.message || 'Có lỗi xảy ra');
                        }
                    })
                    .catch(error => {
                        qtyElement.textContent = currentQty;
                        console.error(error);
                    });
            }

            function removeItem(itemId) {
                if (!confirm('Bạn có chắc muốn xóa sản phẩm này?')) return;

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
                            // Remove item from DOM with animation
                            const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
                            itemElement.style.transition = 'all 0.3s ease';
                            itemElement.style.opacity = '0';
                            itemElement.style.transform = 'translateX(20px)';

                            setTimeout(() => {
                                itemElement.remove();

                                // Update cart totals
                                updateCartTotals(data.cart_total);

                                // Update header count
                                const headerCount = document.getElementById('cart-count-header');
                                if (headerCount) {
                                    headerCount.textContent = `${data.item_count} sản phẩm`;
                                }

                                // Reload if empty to show empty state
                                if (data.item_count === 0) {
                                    location.reload();
                                }
                            }, 300);
                        } else {
                            alert(data.message || 'Có lỗi xảy ra');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            function updateCartTotals(total) {
                const formattedTotal = formatMoney(total);
                document.getElementById('summary-subtotal').textContent = formattedTotal;
                document.getElementById('summary-total').textContent = formattedTotal;
            }

            function formatMoney(amount) {
                return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount).replace('₫', '₫');
            }
        </script>
    @endpush
@endsection