@extends('layouts.app')

@section('title', 'Giới thiệu - UITech')

@section('content')
    <!-- Hero Section -->
    <div class="bg-gray-900 py-20">
        <div class="container mx-auto px-4 max-w-4xl text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Về UITech</h1>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto">Đơn vị tiên phong trong lĩnh vực phân phối linh kiện máy tính
                và thiết bị công nghệ chính hãng tại Việt Nam</p>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-white border-b border-gray-100">
        <div class="container mx-auto px-4 max-w-4xl py-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">5000+</p>
                    <p class="text-sm text-gray-500">Sản phẩm</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">50K+</p>
                    <p class="text-sm text-gray-500">Khách hàng</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">10+</p>
                    <p class="text-sm text-gray-500">Năm kinh nghiệm</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">99%</p>
                    <p class="text-sm text-gray-500">Hài lòng</p>
                </div>
            </div>
        </div>
    </div>

    <!-- About Content -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="bg-white rounded-lg border border-gray-200 p-8 md:p-12">
                <div class="mb-8">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Câu chuyện của chúng tôi</p>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900">UITech - Nơi Đam mê Công nghệ Bắt đầu</h2>
                </div>

                <div class="space-y-4 text-gray-600 leading-relaxed">
                    <p>
                        <strong class="text-gray-900">UITech</strong> được thành lập với sứ mệnh mang đến những sản phẩm
                        công nghệ chất lượng cao nhất cho người dùng Việt Nam. Chúng tôi tin rằng mọi người đều xứng đáng
                        được sử dụng những thiết bị tốt nhất với giá cả hợp lý.
                    </p>
                    <p>
                        Từ những ngày đầu tiên, UITech đã xây dựng mối quan hệ đối tác vững chắc với các thương hiệu hàng
                        đầu thế giới như <strong class="text-gray-900">Intel, AMD, NVIDIA, ASUS, MSI, Corsair</strong> và
                        nhiều hơn nữa. Điều này cho phép chúng tôi cung cấp sản phẩm chính hãng với chế độ bảo hành tốt
                        nhất.
                    </p>
                    <p>
                        Đội ngũ nhân viên của chúng tôi không chỉ là những người bán hàng - họ là những người đam mê công
                        nghệ thực sự, sẵn sàng tư vấn và hỗ trợ bạn xây dựng hệ thống PC hoàn hảo.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-900">Sứ mệnh & Tầm nhìn</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="border border-gray-200 rounded-lg p-6">
                    <h3 class="font-bold text-gray-900 mb-3">Sứ mệnh</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Mang công nghệ tiên tiến nhất đến tay người dùng Việt
                        Nam với giá cả cạnh tranh và dịch vụ chuyên nghiệp.</p>
                </div>

                <div class="border border-gray-200 rounded-lg p-6">
                    <h3 class="font-bold text-gray-900 mb-3">Tầm nhìn</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Trở thành đơn vị phân phối linh kiện máy tính và thiết
                        bị gaming hàng đầu Việt Nam vào năm 2030.</p>
                </div>

                <div class="border border-gray-200 rounded-lg p-6">
                    <h3 class="font-bold text-gray-900 mb-3">Giá trị cốt lõi</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Chất lượng - Uy tín - Chuyên nghiệp - Đổi mới. Luôn đặt
                        khách hàng làm trung tâm.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-900">Tại sao chọn UITech?</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="font-bold text-gray-900 mb-2">100% Chính hãng</h3>
                    <p class="text-sm text-gray-500">Cam kết sản phẩm chính hãng, có tem nhập khẩu và bảo hành đầy đủ.</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="font-bold text-gray-900 mb-2">Giao hàng nhanh</h3>
                    <p class="text-sm text-gray-500">Giao hàng trong 2-4h tại nội thành. Miễn phí ship toàn quốc.</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="font-bold text-gray-900 mb-2">Bảo hành 3 năm</h3>
                    <p class="text-sm text-gray-500">1 đổi 1 trong 30 ngày đầu. Bảo hành tại chỗ, không cần chờ.</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="font-bold text-gray-900 mb-2">Trả góp 0%</h3>
                    <p class="text-sm text-gray-500">Hỗ trợ trả góp 0% lãi suất qua thẻ tín dụng. Duyệt nhanh 15 phút.</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="font-bold text-gray-900 mb-2">Hỗ trợ 24/7</h3>
                    <p class="text-sm text-gray-500">Đội ngũ tư vấn chuyên nghiệp sẵn sàng hỗ trợ mọi lúc.</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="font-bold text-gray-900 mb-2">Build PC miễn phí</h3>
                    <p class="text-sm text-gray-500">Miễn phí lắp ráp, cài đặt hệ điều hành khi mua combo linh kiện.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16 bg-white border-t border-gray-100">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Liên hệ</h2>

                    <div class="space-y-4">
                        <div>
                            <p class="font-medium text-gray-900 mb-1">Địa chỉ</p>
                            <p class="text-gray-500">Khu phố 6, Phường Linh Trung, Thủ Đức, TP. HCM</p>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 mb-1">Hotline</p>
                            <p class="text-gray-500">1900 1234 (8:00 - 22:00)</p>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 mb-1">Email</p>
                            <p class="text-gray-500">support@uitech.vn</p>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 mb-1">Giờ làm việc</p>
                            <p class="text-gray-500">8:00 - 21:00 (Thứ 2 - Chủ nhật)</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg overflow-hidden border border-gray-200">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.2145967890126!2d106.80085971474899!3d10.870014892257464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317527587e9ad5bf%3A0xafa66f9c8be3c91!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2jhu4cgVGjDtG5nIHRpbiAtIMSQSFFHIFRQLkhDTQ!5e0!3m2!1svi!2s!4v1629795025997!5m2!1svi!2s"
                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 bg-gray-900">
        <div class="container mx-auto px-4 max-w-4xl text-center">
            <h2 class="text-2xl font-bold text-white mb-3">Sẵn sàng trải nghiệm?</h2>
            <p class="text-gray-400 mb-6">Khám phá hàng ngàn sản phẩm công nghệ chính hãng tại UITech</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('products.index') }}"
                    class="px-6 py-3 bg-white text-gray-900 font-medium rounded-lg hover:bg-gray-100 transition-colors">
                    Xem sản phẩm
                </a>
                <a href="{{ route('build-pc') }}"
                    class="px-6 py-3 border border-white/30 text-white font-medium rounded-lg hover:bg-white/10 transition-colors">
                    Build PC
                </a>
            </div>
        </div>
    </section>
@endsection