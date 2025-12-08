@extends('layouts.app')

@section('title', 'Chính sách đổi trả - UITech Store')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4 max-w-4xl">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm mb-8 text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Trang chủ</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">Chính sách đổi trả</span>
            </nav>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 lg:p-12">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">Chính Sách Đổi Trả</h1>

                <div class="prose prose-blue max-w-none">
                    <h2>1. Điều kiện đổi trả</h2>
                    <ul>
                        <li>Sản phẩm còn nguyên tem, seal, hộp và phụ kiện đi kèm.</li>
                        <li>Sản phẩm không có dấu hiệu đã qua sử dụng hoặc lắp đặt.</li>
                        <li>Còn trong thời hạn đổi trả theo quy định.</li>
                        <li>Có hóa đơn mua hàng hoặc phiếu giao hàng.</li>
                    </ul>

                    <h2>2. Thời hạn đổi trả</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Hình thức</th>
                                <th>Thời hạn</th>
                                <th>Điều kiện</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Đổi mới 1-1</td>
                                <td>7 ngày</td>
                                <td>Lỗi từ nhà sản xuất</td>
                            </tr>
                            <tr>
                                <td>Trả hàng hoàn tiền</td>
                                <td>7 ngày</td>
                                <td>Sản phẩm chưa khui seal</td>
                            </tr>
                            <tr>
                                <td>Đổi sản phẩm khác</td>
                                <td>15 ngày</td>
                                <td>Sản phẩm còn nguyên vẹn</td>
                            </tr>
                        </tbody>
                    </table>

                    <h2>3. Các trường hợp không đổi trả</h2>
                    <ul>
                        <li>Sản phẩm đã qua sử dụng hoặc đã khui seal.</li>
                        <li>Sản phẩm bị hư hỏng do lỗi của người dùng.</li>
                        <li>Không còn hóa đơn hoặc chứng từ mua hàng.</li>
                        <li>Sản phẩm khuyến mãi, giảm giá đặc biệt, clearance sale.</li>
                        <li>Phần mềm, license key đã được kích hoạt.</li>
                    </ul>

                    <h2>4. Quy trình đổi trả</h2>
                    <ol>
                        <li><strong>Bước 1:</strong> Liên hệ CSKH để đăng ký đổi trả qua hotline hoặc email.</li>
                        <li><strong>Bước 2:</strong> Chuẩn bị sản phẩm cùng đầy đủ hộp, phụ kiện và hóa đơn.</li>
                        <li><strong>Bước 3:</strong> Gửi sản phẩm về địa chỉ cửa hàng hoặc mang trực tiếp.</li>
                        <li><strong>Bước 4:</strong> UITech kiểm tra và xác nhận tình trạng sản phẩm (1-2 ngày).</li>
                        <li><strong>Bước 5:</strong> Hoàn tiền hoặc đổi sản phẩm mới theo yêu cầu.</li>
                    </ol>

                    <h2>5. Phí đổi trả</h2>
                    <ul>
                        <li><strong>Lỗi từ nhà sản xuất:</strong> UITech chịu toàn bộ chi phí.</li>
                        <li><strong>Đổi ý, đổi sản phẩm khác:</strong> Khách hàng chịu phí vận chuyển 2 chiều.</li>
                        <li><strong>Trả hàng hoàn tiền:</strong> Khấu trừ 5% giá trị đơn hàng cho phí xử lý.</li>
                    </ul>

                    <h2>6. Hoàn tiền</h2>
                    <ul>
                        <li>Hoàn tiền qua tài khoản ngân hàng trong vòng 3-5 ngày làm việc.</li>
                        <li>Hoàn tiền mặt tại cửa hàng (nếu thanh toán tiền mặt khi mua).</li>
                    </ul>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mt-8">
                        <h3 class="text-yellow-900 font-bold mb-2">Lưu ý quan trọng</h3>
                        <p class="text-yellow-800 text-sm">
                            Quý khách vui lòng kiểm tra kỹ sản phẩm trước khi nhận hàng. Việc ký nhận đồng nghĩa với việc
                            xác nhận sản phẩm còn nguyên vẹn và đúng như đơn đặt hàng.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection