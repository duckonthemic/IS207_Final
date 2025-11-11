@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-gray-900 mb-4">
                PC Parts E-Store
            </h1>
            <p class="text-xl text-gray-600 mb-8">
                Tìm kiếm các linh kiện máy tính chất lượng cao với giá tốt nhất
            </p>
            <a href="{{ route('products.index') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
                Khám phá sản phẩm
            </a>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-4xl mb-4">💳</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Thanh toán an toàn</h3>
                    <p class="text-gray-600">Các phương thức thanh toán được bảo vệ tối đa</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl mb-4">🚚</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Giao hàng nhanh</h3>
                    <p class="text-gray-600">Giao hàng miễn phí cho đơn hàng trên 500k</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl mb-4">⭐</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Chất lượng tốt</h3>
                    <p class="text-gray-600">Tất cả sản phẩm đều có bảo hành chính hãng</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
