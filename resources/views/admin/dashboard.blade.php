@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Bảng điều khiển</h1>
    
    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium mb-2">Tổng sản phẩm</h3>
            <p class="text-3xl font-bold text-gray-900">0</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium mb-2">Đơn hàng hôm nay</h3>
            <p class="text-3xl font-bold text-gray-900">0</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium mb-2">Doanh thu</h3>
            <p class="text-3xl font-bold text-gray-900">0 đ</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium mb-2">Người dùng</h3>
            <p class="text-3xl font-bold text-gray-900">0</p>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Quản lý nhanh</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.products.create') }}" class="block p-4 border-2 border-indigo-200 rounded-lg hover:border-indigo-600 transition duration-200">
                <h3 class="font-semibold text-indigo-600 mb-2">➕ Thêm sản phẩm</h3>
                <p class="text-sm text-gray-600">Thêm sản phẩm mới vào kho</p>
            </a>
            <a href="{{ route('admin.products.index') }}" class="block p-4 border-2 border-indigo-200 rounded-lg hover:border-indigo-600 transition duration-200">
                <h3 class="font-semibold text-indigo-600 mb-2">📋 Quản lý sản phẩm</h3>
                <p class="text-sm text-gray-600">Xem và chỉnh sửa sản phẩm</p>
            </a>
            <a href="#" class="block p-4 border-2 border-indigo-200 rounded-lg hover:border-indigo-600 transition duration-200">
                <h3 class="font-semibold text-indigo-600 mb-2">📊 Xem báo cáo</h3>
                <p class="text-sm text-gray-600">Xem thống kê bán hàng</p>
            </a>
        </div>
    </div>
</div>
@endsection
