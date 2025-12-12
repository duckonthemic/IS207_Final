@extends('layouts.app')

@section('title', 'Chính sách bảo hành - UITech')

@section('content')
    <!-- Hero Section -->
    <div class="bg-gray-900 py-16">
        <div class="container mx-auto px-4 max-w-4xl text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Chính Sách Bảo Hành</h1>
            <p class="text-gray-400">Cam kết bảo hành chính hãng 100% - An tâm mua sắm</p>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-100">
        <div class="container mx-auto px-4 max-w-4xl py-4">
            <nav class="flex items-center gap-2 text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-gray-900 transition-colors">Trang chủ</a>
                <span class="text-gray-300">/</span>
                <span class="text-gray-900 font-medium">Chính sách bảo hành</span>
            </nav>
        </div>
    </div>

    <!-- Highlights -->
    <div class="bg-white border-b border-gray-100">
        <div class="container mx-auto px-4 max-w-4xl py-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <p class="text-2xl font-bold text-gray-900 mb-1">100%</p>
                    <p class="text-sm text-gray-500">Chính hãng</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 mb-1">30 ngày</p>
                    <p class="text-sm text-gray-500">Đổi mới</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 mb-1">36 tháng</p>
                    <p class="text-sm text-gray-500">Bảo hành tối đa</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 mb-1">24/7</p>
                    <p class="text-sm text-gray-500">Hỗ trợ kỹ thuật</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl space-y-8">

            <!-- Thời gian bảo hành -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Thời gian bảo hành</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left font-semibold text-gray-900">Loại sản phẩm</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-900">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="px-6 py-3 text-gray-700">CPU Intel / AMD</td>
                                <td class="px-6 py-3 text-gray-900 font-medium">36 tháng</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 text-gray-700">VGA (Card màn hình)</td>
                                <td class="px-6 py-3 text-gray-900 font-medium">36 tháng</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 text-gray-700">Mainboard</td>
                                <td class="px-6 py-3 text-gray-900 font-medium">36 tháng</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 text-gray-700">RAM</td>
                                <td class="px-6 py-3 text-gray-900 font-medium">Lifetime</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 text-gray-700">SSD</td>
                                <td class="px-6 py-3 text-gray-900 font-medium">36 - 60 tháng</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 text-gray-700">Nguồn (PSU)</td>
                                <td class="px-6 py-3 text-gray-900 font-medium">36 - 120 tháng</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 text-gray-700">Màn hình</td>
                                <td class="px-6 py-3 text-gray-900 font-medium">24 - 36 tháng</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 text-gray-700">Gaming Gear</td>
                                <td class="px-6 py-3 text-gray-900 font-medium">12 - 24 tháng</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Điều kiện bảo hành -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900">Được bảo hành</h2>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex items-start gap-3">
                                <span class="text-gray-400 mt-0.5">•</span>
                                <span>Sản phẩm còn trong thời hạn bảo hành</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-gray-400 mt-0.5">•</span>
                                <span>Tem bảo hành còn nguyên vẹn</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-gray-400 mt-0.5">•</span>
                                <span>Lỗi kỹ thuật do nhà sản xuất</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-gray-400 mt-0.5">•</span>
                                <span>Có hóa đơn hoặc phiếu bảo hành</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900">Không được bảo hành</h2>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex items-start gap-3">
                                <span class="text-gray-400 mt-0.5">•</span>
                                <span>Tem bảo hành bị rách, mất hoặc can thiệp</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-gray-400 mt-0.5">•</span>
                                <span>Hư hỏng do va đập, rơi, nước</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-gray-400 mt-0.5">•</span>
                                <span>Nguồn điện không ổn định, sét đánh</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-gray-400 mt-0.5">•</span>
                                <span>Đã sửa chữa bởi bên thứ ba</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Quy trình bảo hành -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Quy trình bảo hành</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div
                                class="w-10 h-10 bg-gray-900 text-white rounded-full flex items-center justify-center text-sm font-bold mx-auto mb-3">
                                1</div>
                            <h3 class="font-semibold text-gray-900 mb-1">Liên hệ</h3>
                            <p class="text-sm text-gray-500">Gọi hotline hoặc đến cửa hàng</p>
                        </div>
                        <div class="text-center">
                            <div
                                class="w-10 h-10 bg-gray-900 text-white rounded-full flex items-center justify-center text-sm font-bold mx-auto mb-3">
                                2</div>
                            <h3 class="font-semibold text-gray-900 mb-1">Kiểm tra</h3>
                            <p class="text-sm text-gray-500">Kỹ thuật viên xác định lỗi</p>
                        </div>
                        <div class="text-center">
                            <div
                                class="w-10 h-10 bg-gray-900 text-white rounded-full flex items-center justify-center text-sm font-bold mx-auto mb-3">
                                3</div>
                            <h3 class="font-semibold text-gray-900 mb-1">Xử lý</h3>
                            <p class="text-sm text-gray-500">Sửa chữa hoặc đổi mới</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chính sách 1 đổi 1 -->
            <div class="bg-gray-900 rounded-lg p-6">
                <div class="flex flex-col md:flex-row items-center gap-4 text-center md:text-left">
                    <div class="flex-1">
                        <h2 class="text-lg font-bold text-white mb-1">Chính sách 1 Đổi 1</h2>
                        <p class="text-gray-400 text-sm">Đổi sản phẩm mới 100% trong 30 ngày đầu nếu gặp lỗi từ nhà sản xuất
                        </p>
                    </div>
                    <a href="{{ route('page.show', 'faq') }}"
                        class="px-5 py-2 border border-white/30 text-white text-sm font-medium rounded-lg hover:bg-white/10 transition-colors whitespace-nowrap">
                        Xem FAQ
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-12 bg-white border-t border-gray-100">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="text-center mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-2">Liên hệ bảo hành</h2>
                <p class="text-gray-500">Chúng tôi sẵn sàng hỗ trợ bạn</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div>
                    <p class="font-semibold text-gray-900 mb-1">Hotline</p>
                    <p class="text-gray-500">1900 1234</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 mb-1">Email</p>
                    <p class="text-gray-500">warranty@uitech.vn</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 mb-1">Địa chỉ</p>
                    <p class="text-gray-500">Khu phố 6, Linh Trung, Thủ Đức</p>
                </div>
            </div>
        </div>
    </section>
@endsection