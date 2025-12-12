@extends('layouts.app')

@section('title', 'Câu hỏi thường gặp - UITech')

@section('content')
    <!-- Hero Section -->
    <div class="bg-gray-900 py-16">
        <div class="container mx-auto px-4 max-w-4xl text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Câu Hỏi Thường Gặp</h1>
            <p class="text-gray-400">Giải đáp thắc mắc về sản phẩm và dịch vụ tại UITech</p>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-100">
        <div class="container mx-auto px-4 max-w-4xl py-4">
            <nav class="flex items-center gap-2 text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-gray-900 transition-colors">Trang chủ</a>
                <span class="text-gray-300">/</span>
                <span class="text-gray-900 font-medium">FAQ</span>
            </nav>
        </div>
    </div>

    <!-- FAQ Content -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">

            <div class="space-y-6" x-data="{ openFaq: null }">

                <!-- Đặt hàng & Thanh toán -->
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900">Đặt hàng & Thanh toán</h2>
                    </div>

                    <div class="divide-y divide-gray-100">
                        <div>
                            <button @click="openFaq = openFaq === 1 ? null : 1"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-800">Tôi có thể đặt hàng như thế nào?</span>
                                <svg :class="openFaq === 1 ? 'rotate-180' : ''"
                                    class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="openFaq === 1" x-collapse class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">
                                <ol class="list-decimal list-inside space-y-2">
                                    <li>Chọn sản phẩm và thêm vào giỏ hàng</li>
                                    <li>Kiểm tra giỏ hàng và nhấn "Thanh toán"</li>
                                    <li>Điền thông tin giao hàng</li>
                                    <li>Chọn phương thức thanh toán</li>
                                    <li>Xác nhận đơn hàng</li>
                                </ol>
                            </div>
                        </div>

                        <div>
                            <button @click="openFaq = openFaq === 2 ? null : 2"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-800">UITech hỗ trợ những phương thức thanh toán
                                    nào?</span>
                                <svg :class="openFaq === 2 ? 'rotate-180' : ''"
                                    class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="openFaq === 2" x-collapse class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">
                                <ul class="space-y-2">
                                    <li><span class="font-medium text-gray-800">COD</span> — Thanh toán khi nhận hàng</li>
                                    <li><span class="font-medium text-gray-800">Chuyển khoản</span> — Techcombank,
                                        Vietcombank, MB Bank</li>
                                    <li><span class="font-medium text-gray-800">Ví điện tử</span> — MoMo, ZaloPay, VNPay
                                    </li>
                                    <li><span class="font-medium text-gray-800">Trả góp 0%</span> — Qua thẻ tín dụng Visa,
                                        Mastercard</li>
                                </ul>
                            </div>
                        </div>

                        <div>
                            <button @click="openFaq = openFaq === 3 ? null : 3"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-800">Có thể hủy đơn hàng sau khi đặt không?</span>
                                <svg :class="openFaq === 3 ? 'rotate-180' : ''"
                                    class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="openFaq === 3" x-collapse class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">
                                <p>Có thể hủy đơn hàng trước khi đơn được xử lý và giao cho đơn vị vận chuyển. Liên hệ
                                    hotline <span class="font-medium text-gray-900">1900 1234</span> để được hỗ trợ.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Giao hàng -->
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900">Giao hàng</h2>
                    </div>

                    <div class="divide-y divide-gray-100">
                        <div>
                            <button @click="openFaq = openFaq === 4 ? null : 4"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-800">Thời gian giao hàng là bao lâu?</span>
                                <svg :class="openFaq === 4 ? 'rotate-180' : ''"
                                    class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="openFaq === 4" x-collapse class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">
                                <ul class="space-y-2">
                                    <li><span class="font-medium text-gray-800">Nội thành HCM, Hà Nội:</span> 2-4 giờ (giao
                                        nhanh)</li>
                                    <li><span class="font-medium text-gray-800">Ngoại thành:</span> 1-2 ngày</li>
                                    <li><span class="font-medium text-gray-800">Các tỉnh khác:</span> 2-5 ngày</li>
                                </ul>
                            </div>
                        </div>

                        <div>
                            <button @click="openFaq = openFaq === 5 ? null : 5"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-800">Phí giao hàng là bao nhiêu?</span>
                                <svg :class="openFaq === 5 ? 'rotate-180' : ''"
                                    class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="openFaq === 5" x-collapse class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">
                                <ul class="space-y-2">
                                    <li><span class="font-medium text-gray-800">Miễn phí</span> cho đơn hàng từ 500.000đ
                                    </li>
                                    <li><span class="font-medium text-gray-800">25.000đ - 50.000đ</span> cho đơn dưới
                                        500.000đ (tùy khu vực)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bảo hành & Đổi trả -->
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900">Bảo hành & Đổi trả</h2>
                    </div>

                    <div class="divide-y divide-gray-100">
                        <div>
                            <button @click="openFaq = openFaq === 6 ? null : 6"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-800">Chính sách bảo hành như thế nào?</span>
                                <svg :class="openFaq === 6 ? 'rotate-180' : ''"
                                    class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="openFaq === 6" x-collapse class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">
                                <ul class="space-y-2">
                                    <li>Bảo hành chính hãng 12 - 36 tháng tùy sản phẩm</li>
                                    <li>1 đổi 1 trong 30 ngày đầu nếu lỗi từ NSX</li>
                                    <li>Bảo hành tại chỗ, không cần chờ đợi</li>
                                    <li>Hỗ trợ kỹ thuật trọn đời sản phẩm</li>
                                </ul>
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <a href="{{ route('page.show', 'chinh-sach-bao-hanh') }}"
                                        class="text-gray-900 font-medium hover:underline">
                                        Xem chi tiết chính sách bảo hành →
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button @click="openFaq = openFaq === 7 ? null : 7"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-800">Làm sao để đổi/trả sản phẩm?</span>
                                <svg :class="openFaq === 7 ? 'rotate-180' : ''"
                                    class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="openFaq === 7" x-collapse class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">
                                <ol class="list-decimal list-inside space-y-2">
                                    <li>Liên hệ hotline 1900 1234 hoặc email support@uitech.vn</li>
                                    <li>Cung cấp mã đơn hàng và lý do đổi/trả</li>
                                    <li>Đóng gói sản phẩm nguyên vẹn, đầy đủ phụ kiện</li>
                                    <li>Nhận sản phẩm mới hoặc hoàn tiền trong 3-5 ngày</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Build PC -->
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900">Build PC</h2>
                    </div>

                    <div class="divide-y divide-gray-100">
                        <div>
                            <button @click="openFaq = openFaq === 8 ? null : 8"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-800">UITech có hỗ trợ lắp ráp PC không?</span>
                                <svg :class="openFaq === 8 ? 'rotate-180' : ''"
                                    class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="openFaq === 8" x-collapse class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">
                                <p class="mb-3">Miễn phí lắp ráp PC khi mua combo linh kiện. Dịch vụ bao gồm:</p>
                                <ul class="space-y-1">
                                    <li>• Cài đặt Windows và driver miễn phí</li>
                                    <li>• Test burn-in 24h trước khi giao</li>
                                    <li>• Cáp gút gọn gàng, chuyên nghiệp</li>
                                    <li>• Overclock theo yêu cầu</li>
                                </ul>
                            </div>
                        </div>

                        <div>
                            <button @click="openFaq = openFaq === 9 ? null : 9"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-800">Làm sao biết linh kiện nào tương thích?</span>
                                <svg :class="openFaq === 9 ? 'rotate-180' : ''"
                                    class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="openFaq === 9" x-collapse class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">
                                <p>Sử dụng công cụ <span class="font-medium text-gray-900">Build PC</span> trên website - hệ
                                    thống tự động kiểm tra và cảnh báo nếu linh kiện không tương thích.</p>
                                <div class="mt-3">
                                    <a href="{{ route('build-pc') }}"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                                        Bắt đầu Build PC
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="py-12 bg-white border-t border-gray-100">
        <div class="container mx-auto px-4 max-w-4xl text-center">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Không tìm thấy câu trả lời?</h2>
            <p class="text-gray-500 mb-6">Liên hệ đội ngũ hỗ trợ để được giải đáp</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="tel:19001234"
                    class="px-6 py-3 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition-colors">
                    Gọi 1900 1234
                </a>
                <a href="mailto:support@uitech.vn"
                    class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    support@uitech.vn
                </a>
            </div>
        </div>
    </section>
@endsection