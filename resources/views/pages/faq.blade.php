@extends('layouts.app')

@section('title', 'Câu hỏi thường gặp - UITech Store')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4 max-w-4xl">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm mb-8 text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Trang chủ</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">Câu hỏi thường gặp</span>
            </nav>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 lg:p-12">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">Câu Hỏi Thường Gặp (FAQ)</h1>

                <div class="space-y-4" x-data="{ openFaq: null }">
                    {{-- FAQ Item 1 --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="openFaq = openFaq === 1 ? null : 1"
                            class="w-full flex items-center justify-between p-5 text-left bg-white hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-gray-900">Làm thế nào để đặt hàng tại UITech?</span>
                            <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': openFaq === 1 }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 1" x-collapse class="px-5 pb-5 text-gray-600">
                            <p>Bạn có thể đặt hàng theo các bước sau:</p>
                            <ol class="list-decimal list-inside mt-2 space-y-1">
                                <li>Tìm kiếm sản phẩm cần mua</li>
                                <li>Thêm vào giỏ hàng</li>
                                <li>Kiểm tra giỏ hàng và nhấn "Thanh toán"</li>
                                <li>Điền thông tin giao hàng</li>
                                <li>Chọn phương thức thanh toán</li>
                                <li>Xác nhận đơn hàng</li>
                            </ol>
                        </div>
                    </div>

                    {{-- FAQ Item 2 --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="openFaq = openFaq === 2 ? null : 2"
                            class="w-full flex items-center justify-between p-5 text-left bg-white hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-gray-900">Thời gian giao hàng là bao lâu?</span>
                            <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': openFaq === 2 }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 2" x-collapse class="px-5 pb-5 text-gray-600">
                            <ul class="list-disc list-inside space-y-1">
                                <li><strong>Nội thành TP.HCM:</strong> 1-2 ngày làm việc</li>
                                <li><strong>Các tỉnh lân cận:</strong> 2-3 ngày làm việc</li>
                                <li><strong>Các tỉnh xa:</standard> 3-5 ngày làm việc</li>
                            </ul>
                            <p class="mt-2 text-sm">Thời gian có thể thay đổi tùy vào tình hình vận chuyển.</p>
                        </div>
                    </div>

                    {{-- FAQ Item 3 --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="openFaq = openFaq === 3 ? null : 3"
                            class="w-full flex items-center justify-between p-5 text-left bg-white hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-gray-900">Phí vận chuyển được tính như thế nào?</span>
                            <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': openFaq === 3 }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 3" x-collapse class="px-5 pb-5 text-gray-600">
                            <ul class="list-disc list-inside space-y-1">
                                <li><strong>Miễn phí:</strong> Đơn hàng từ 500.000đ (nội thành TP.HCM)</li>
                                <li><strong>30.000đ:</strong> Đơn hàng dưới 500.000đ (nội thành TP.HCM)</li>
                                <li><strong>Theo cước GHTK:</strong> Đơn hàng giao tỉnh</li>
                            </ul>
                        </div>
                    </div>

                    {{-- FAQ Item 4 --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="openFaq = openFaq === 4 ? null : 4"
                            class="w-full flex items-center justify-between p-5 text-left bg-white hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-gray-900">Sản phẩm có được bảo hành không?</span>
                            <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': openFaq === 4 }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 4" x-collapse class="px-5 pb-5 text-gray-600">
                            <p>Tất cả sản phẩm tại UITech đều được bảo hành chính hãng. Thời hạn bảo hành từ 12-36 tháng tùy
                                loại sản phẩm và hãng sản xuất.</p>
                            <p class="mt-2">Xem chi tiết tại <a href="{{ route('page.show', 'bao-hanh') }}"
                                    class="text-blue-600 hover:underline">Chính sách bảo hành</a>.</p>
                        </div>
                    </div>

                    {{-- FAQ Item 5 --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="openFaq = openFaq === 5 ? null : 5"
                            class="w-full flex items-center justify-between p-5 text-left bg-white hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-gray-900">Làm sao để kiểm tra đơn hàng?</span>
                            <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': openFaq === 5 }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 5" x-collapse class="px-5 pb-5 text-gray-600">
                            <p>Nếu bạn đã có tài khoản, hãy đăng nhập và vào mục "Đơn hàng của tôi" để xem trạng thái đơn
                                hàng.</p>
                            <p class="mt-2">Hoặc liên hệ hotline <strong>0243 123 456</strong> với mã đơn hàng để được hỗ
                                trợ.</p>
                        </div>
                    </div>

                    {{-- FAQ Item 6 --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="openFaq = openFaq === 6 ? null : 6"
                            class="w-full flex items-center justify-between p-5 text-left bg-white hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-gray-900">Tôi có thể hủy đơn hàng được không?</span>
                            <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': openFaq === 6 }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 6" x-collapse class="px-5 pb-5 text-gray-600">
                            <p>Bạn có thể hủy đơn hàng khi đơn hàng chưa được xử lý (trạng thái "Chờ xác nhận"). Sau khi đơn
                                hàng đã được xác nhận và đang trong quá trình giao hàng, bạn không thể hủy trực tiếp.</p>
                            <p class="mt-2">Liên hệ CSKH để được hỗ trợ nếu cần hủy đơn hàng đã xác nhận.</p>
                        </div>
                    </div>

                    {{-- FAQ Item 7 --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="openFaq = openFaq === 7 ? null : 7"
                            class="w-full flex items-center justify-between p-5 text-left bg-white hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-gray-900">UITech có hỗ trợ trả góp không?</span>
                            <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': openFaq === 7 }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 7" x-collapse class="px-5 pb-5 text-gray-600">
                            <p>Có, UITech hỗ trợ trả góp 0% lãi suất qua thẻ tín dụng các ngân hàng liên kết:</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li>Visa, Mastercard, JCB</li>
                                <li>Kỳ hạn: 3, 6, 9, 12 tháng</li>
                                <li>Đơn hàng tối thiểu: 3.000.000đ</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Contact CTA --}}
                <div class="mt-10 bg-blue-50 border border-blue-100 rounded-xl p-6 text-center">
                    <h3 class="font-bold text-blue-900 mb-2">Không tìm thấy câu trả lời?</h3>
                    <p class="text-blue-700 text-sm mb-4">Liên hệ với chúng tôi để được hỗ trợ trực tiếp.</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="tel:0243123456"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            0243 123 456
                        </a>
                        <a href="mailto:support@uitech.vn"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-blue-600 font-bold rounded-xl border border-blue-200 hover:bg-blue-50 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            support@uitech.vn
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection