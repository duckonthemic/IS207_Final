@extends('layouts.app')

@section('title', 'Chính sách bảo mật - UITech Store')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4 max-w-4xl">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm mb-8 text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Trang chủ</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">Chính sách bảo mật</span>
            </nav>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 lg:p-12">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">Chính Sách Bảo Mật</h1>

                <div class="prose prose-blue max-w-none">
                    <p class="lead">
                        UITech Store cam kết bảo vệ quyền riêng tư và thông tin cá nhân của khách hàng.
                        Chính sách này mô tả cách chúng tôi thu thập, sử dụng và bảo vệ dữ liệu của bạn.
                    </p>

                    <h2>1. Thông tin chúng tôi thu thập</h2>
                    <ul>
                        <li><strong>Thông tin cá nhân:</strong> Họ tên, email, số điện thoại, địa chỉ giao hàng.</li>
                        <li><strong>Thông tin tài khoản:</strong> Tên đăng nhập, mật khẩu (được mã hóa).</li>
                        <li><strong>Thông tin giao dịch:</strong> Lịch sử đặt hàng, phương thức thanh toán.</li>
                        <li><strong>Thông tin kỹ thuật:</strong> Địa chỉ IP, loại trình duyệt, thiết bị sử dụng.</li>
                    </ul>

                    <h2>2. Mục đích sử dụng thông tin</h2>
                    <ul>
                        <li>Xử lý và giao đơn hàng.</li>
                        <li>Liên hệ hỗ trợ và chăm sóc khách hàng.</li>
                        <li>Gửi thông tin khuyến mãi và cập nhật sản phẩm (nếu đồng ý).</li>
                        <li>Cải thiện chất lượng dịch vụ và trải nghiệm người dùng.</li>
                        <li>Ngăn chặn gian lận và bảo vệ tài khoản.</li>
                    </ul>

                    <h2>3. Bảo mật thông tin</h2>
                    <ul>
                        <li>Sử dụng mã hóa SSL/TLS cho tất cả giao dịch.</li>
                        <li>Mật khẩu được mã hóa bằng thuật toán bcrypt.</li>
                        <li>Hệ thống firewall và giám sát 24/7.</li>
                        <li>Hạn chế quyền truy cập dữ liệu theo nguyên tắc need-to-know.</li>
                    </ul>

                    <h2>4. Chia sẻ thông tin</h2>
                    <p>Chúng tôi <strong>KHÔNG</strong> bán hoặc cho thuê thông tin cá nhân. Thông tin chỉ được chia sẻ
                        trong các trường hợp:</p>
                    <ul>
                        <li>Đối tác vận chuyển để giao hàng.</li>
                        <li>Cổng thanh toán để xử lý giao dịch.</li>
                        <li>Yêu cầu từ cơ quan pháp luật có thẩm quyền.</li>
                    </ul>

                    <h2>5. Cookie và tracking</h2>
                    <ul>
                        <li>Sử dụng cookie để cải thiện trải nghiệm duyệt web.</li>
                        <li>Cookie giỏ hàng để lưu sản phẩm đã chọn.</li>
                        <li>Cookie phân tích để hiểu hành vi người dùng.</li>
                        <li>Bạn có thể tắt cookie trong cài đặt trình duyệt.</li>
                    </ul>

                    <h2>6. Quyền của khách hàng</h2>
                    <ul>
                        <li><strong>Quyền truy cập:</strong> Xem thông tin cá nhân đã lưu.</li>
                        <li><strong>Quyền chỉnh sửa:</strong> Cập nhật thông tin không chính xác.</li>
                        <li><strong>Quyền xóa:</strong> Yêu cầu xóa tài khoản và dữ liệu.</li>
                        <li><strong>Quyền từ chối:</strong> Hủy đăng ký nhận email marketing.</li>
                    </ul>

                    <h2>7. Bảo mật trẻ em</h2>
                    <p>
                        Website của chúng tôi không dành cho người dưới 16 tuổi.
                        Chúng tôi không cố ý thu thập thông tin từ trẻ em.
                    </p>

                    <h2>8. Thay đổi chính sách</h2>
                    <p>
                        Chính sách bảo mật có thể được cập nhật định kỳ.
                        Mọi thay đổi sẽ được thông báo qua email hoặc đăng trên website.
                    </p>

                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 mt-8">
                        <p class="text-gray-600 text-sm">
                            <strong>Cập nhật lần cuối:</strong> {{ date('d/m/Y') }}<br>
                            Nếu có bất kỳ thắc mắc nào về chính sách bảo mật, vui lòng liên hệ:
                            <strong>privacy@uitech.vn</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection