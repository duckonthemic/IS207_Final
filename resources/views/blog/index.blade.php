@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold text-gray-900 mb-8">Blog</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Blog Post 1 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">
                    Hướng dẫn chọn CPU cho máy tính
                </h2>
                <p class="text-gray-500 text-sm mb-4">2 tháng 11, 2025</p>
                <p class="text-gray-600 mb-4">
                    CPU là bộ xử lý trung tâm của máy tính, lựa chọn đúng CPU sẽ quyết định hiệu năng của máy...
                </p>
                <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">
                    Đọc thêm →
                </a>
            </div>
        </div>
        
        <!-- Blog Post 2 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">
                    So sánh RAM DDR4 vs DDR5
                </h2>
                <p class="text-gray-500 text-sm mb-4">31 tháng 10, 2025</p>
                <p class="text-gray-600 mb-4">
                    DDR5 là thế hệ RAM mới nhất với tốc độ nhanh hơn và tiết kiệm điện năng hơn so với DDR4...
                </p>
                <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">
                    Đọc thêm →
                </a>
            </div>
        </div>
        
        <!-- Blog Post 3 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">
                    Lựa chọn SSD cho gaming
                </h2>
                <p class="text-gray-500 text-sm mb-4">30 tháng 10, 2025</p>
                <p class="text-gray-600 mb-4">
                    SSD NVMe M.2 là lựa chọn tốt nhất cho gaming, cho phép tải trò chơi nhanh chóng...
                </p>
                <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">
                    Đọc thêm →
                </a>
            </div>
        </div>
        
        <!-- Blog Post 4 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">
                    Hướng dẫn chọn Power Supply
                </h2>
                <p class="text-gray-500 text-sm mb-4">29 tháng 10, 2025</p>
                <p class="text-gray-600 mb-4">
                    Nguồn điện chất lượng là yếu tố quan trọng để đảm bảo độ bền của máy tính...
                </p>
                <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">
                    Đọc thêm →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
