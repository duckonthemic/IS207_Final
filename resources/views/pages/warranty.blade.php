@extends('layouts.app')

@section('title', 'Chính sách bảo hành - UITech Store')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4 max-w-4xl">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm mb-8 text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Trang chủ</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">Chính sách bảo hành</span>
            </nav>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 lg:p-12">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">Chính Sách Bảo Hành</h1>

                <div class="prose prose-blue max-w-none">
                    <h2>1. Điều kiện bảo hành</h2>
                    <ul>
                        <li>Sản phẩm còn trong thời hạn bảo hành được ghi trên phiếu bảo hành hoặc hóa đơn mua hàng.</li>
                        <li>Tem bảo hành, serial number còn nguyên vẹn và khớp với thông tin trên phiếu bảo hành.</li>
                        <li>Sản phẩm hư hỏng do lỗi của nhà sản xuất (lỗi kỹ thuật, lỗi linh kiện...).</li>
                        <li>Sản phẩm được sử dụng đúng hướng dẫn của nhà sản xuất.</li>
                    </ul>

                    <h2>2. Các trường hợp không bảo hành</h2>
                    <ul>
                        <li>Sản phẩm đã hết thời hạn bảo hành.</li>
                        <li>Tem bảo hành, serial number bị rách, mờ, hoặc có dấu hiệu bị tác động.</li>
                        <li>Sản phẩm bị hư hỏng do nguyên nhân bên ngoài: va đập, rơi vỡ, cháy nổ, thiên tai, điện áp không
                            ổn định...</li>
                        <li>Sản phẩm bị hư hỏng do sử dụng sai quy cách hoặc tự ý sửa chữa.</li>
                        <li>Linh kiện lắp đặt không đúng cách hoặc không tương thích.</li>
                        <li>Sản phẩm bị hư hỏng do virus, phần mềm độc hại hoặc cài đặt phần mềm không chính hãng.</li>
                    </ul>

                    <h2>3. Thời gian bảo hành</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Loại sản phẩm</th>
                                <th>Thời gian bảo hành</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>CPU, Mainboard</td>
                                <td>36 tháng</td>
                            </tr>
                            <tr>
                                <td>VGA (Card đồ họa)</td>
                                <td>36 tháng</td>
                            </tr>
                            <tr>
                                <td>RAM</td>
                                <td>Trọn đời (Lifetime)</td>
                            </tr>
                            <tr>
                                <td>SSD</td>
                                <td>36-60 tháng (tùy hãng)</td>
                            </tr>
                            <tr>
                                <td>HDD</td>
                                <td>24 tháng</td>
                            </tr>
                            <tr>
                                <td>Nguồn máy tính (PSU)</td>
                                <td>36-120 tháng (tùy hãng)</td>
                            </tr>
                            <tr>
                                <td>Case, Tản nhiệt</td>
                                <td>12-24 tháng</td>
                            </tr>
                            <tr>
                                <td>Màn hình</td>
                                <td>24-36 tháng</td>
                            </tr>
                        </tbody>
                    </table>

                    <h2>4. Quy trình bảo hành</h2>
                    <ol>
                        <li><strong>Bước 1:</strong> Liên hệ bộ phận CSKH qua hotline <strong>0243 123 456</strong> hoặc
                            email <strong>support@uitech.vn</strong>.</li>
                        <li><strong>Bước 2:</strong> Mang sản phẩm đến trực tiếp cửa hàng hoặc gửi qua đường bưu điện (khách
                            hàng chịu phí vận chuyển chiều đi).</li>
                        <li><strong>Bước 3:</strong> Kỹ thuật viên kiểm tra và xác nhận tình trạng sản phẩm.</li>
                        <li><strong>Bước 4:</strong> Tiến hành sửa chữa hoặc đổi mới (nếu không thể sửa chữa).</li>
                        <li><strong>Bước 5:</strong> Thông báo khách hàng đến nhận hoặc gửi lại qua đường bưu điện (UITech
                            chịu phí vận chuyển chiều về).</li>
                    </ol>

                    <h2>5. Thời gian xử lý bảo hành</h2>
                    <ul>
                        <li>Bảo hành tại chỗ: 1-3 ngày làm việc.</li>
                        <li>Bảo hành chuyển hãng: 7-21 ngày làm việc (tùy theo chính sách của hãng).</li>
                    </ul>

                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mt-8">
                        <h3 class="text-blue-900 font-bold mb-2">Cam kết của UITech</h3>
                        <p class="text-blue-800 text-sm">
                            Chúng tôi cam kết mang đến dịch vụ bảo hành nhanh chóng, minh bạch và chuyên nghiệp.
                            Mọi thắc mắc xin liên hệ hotline <strong>0243 123 456</strong> để được hỗ trợ 24/7.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection