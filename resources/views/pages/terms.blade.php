@extends('layouts.app')

@section('title', 'Điều khoản dịch vụ - UITech Store')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4 max-w-4xl">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm mb-8 text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Trang chủ</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">Điều khoản dịch vụ</span>
            </nav>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 lg:p-12">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">Điều Khoản Dịch Vụ</h1>

                <div class="prose prose-blue max-w-none">
                    <p class="lead">
                        Chào mừng bạn đến với UITech Store. Khi sử dụng website và dịch vụ của chúng tôi,
                        bạn đồng ý tuân thủ các điều khoản và điều kiện dưới đây.
                    </p>

                    <h2>1. Điều khoản chung</h2>
                    <ul>
                        <li>Người dùng phải từ đủ 18 tuổi hoặc có sự đồng ý của phụ huynh/người giám hộ.</li>
                        <li>Tất cả thông tin đăng ký tài khoản phải chính xác và đầy đủ.</li>
                        <li>Bạn chịu trách nhiệm bảo mật thông tin tài khoản của mình.</li>
                        <li>UITech có quyền từ chối phục vụ bất kỳ ai vi phạm điều khoản.</li>
                    </ul>

                    <h2>2. Sản phẩm và giá cả</h2>
                    <ul>
                        <li>Tất cả giá niêm yết đã bao gồm VAT (nếu có).</li>
                        <li>Giá có thể thay đổi mà không cần thông báo trước.</li>
                        <li>Hình ảnh sản phẩm chỉ mang tính chất tham khảo.</li>
                        <li>UITech cam kết bán hàng chính hãng 100%.</li>
                    </ul>

                    <h2>3. Đặt hàng và thanh toán</h2>
                    <ul>
                        <li>Đơn hàng chỉ được xác nhận khi UITech gửi email/SMS xác nhận.</li>
                        <li>UITech có quyền từ chối hoặc hủy đơn hàng trong các trường hợp: thông tin sai, sản phẩm hết
                            hàng, nghi ngờ gian lận.</li>
                        <li>Các phương thức thanh toán được chấp nhận: COD, chuyển khoản, thẻ tín dụng, ví điện tử.</li>
                    </ul>

                    <h2>4. Giao hàng</h2>
                    <ul>
                        <li>Thời gian giao hàng dự kiến: 1-3 ngày (nội thành), 3-7 ngày (tỉnh).</li>
                        <li>Phí vận chuyển được tính dựa trên khoảng cách và trọng lượng đơn hàng.</li>
                        <li>Miễn phí giao hàng cho đơn hàng trên 500.000đ (nội thành TP.HCM).</li>
                    </ul>

                    <h2>5. Bảo mật thông tin</h2>
                    <ul>
                        <li>UITech cam kết bảo mật thông tin cá nhân của khách hàng.</li>
                        <li>Thông tin chỉ được sử dụng cho mục đích xử lý đơn hàng và chăm sóc khách hàng.</li>
                        <li>Không chia sẻ thông tin với bên thứ ba trừ khi có sự đồng ý của khách hàng hoặc yêu cầu từ cơ
                            quan pháp luật.</li>
                    </ul>

                    <h2>6. Quyền sở hữu trí tuệ</h2>
                    <ul>
                        <li>Tất cả nội dung trên website thuộc quyền sở hữu của UITech.</li>
                        <li>Không được sao chép, phân phối hoặc sử dụng vì mục đích thương mại mà không có sự cho phép.</li>
                    </ul>

                    <h2>7. Giới hạn trách nhiệm</h2>
                    <ul>
                        <li>UITech không chịu trách nhiệm cho các thiệt hại gián tiếp phát sinh từ việc sử dụng sản phẩm.
                        </li>
                        <li>Trách nhiệm tối đa của UITech không vượt quá giá trị đơn hàng.</li>
                    </ul>

                    <h2>8. Thay đổi điều khoản</h2>
                    <p>
                        UITech có quyền cập nhật điều khoản dịch vụ bất kỳ lúc nào.
                        Các thay đổi sẽ có hiệu lực ngay khi được đăng tải trên website.
                        Việc tiếp tục sử dụng dịch vụ đồng nghĩa với việc bạn chấp nhận các thay đổi này.
                    </p>

                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 mt-8">
                        <p class="text-gray-600 text-sm">
                            <strong>Cập nhật lần cuối:</strong> {{ date('d/m/Y') }}<br>
                            Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ: <strong>support@uitech.vn</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection