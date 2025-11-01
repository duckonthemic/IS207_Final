@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold text-gray-900 mb-8">Liên hệ chúng tôi</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Contact Info -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Thông tin liên hệ</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Địa chỉ</h3>
                    <p class="text-gray-600">123 Đường ABC, Quận XYZ, Thành phố HCM, Việt Nam</p>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Email</h3>
                    <p class="text-gray-600">
                        <a href="mailto:info@pcparts.vn" class="text-indigo-600 hover:text-indigo-700">
                            info@pcparts.vn
                        </a>
                    </p>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Điện thoại</h3>
                    <p class="text-gray-600">
                        <a href="tel:0123456789" class="text-indigo-600 hover:text-indigo-700">
                            0123 456 789
                        </a>
                    </p>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Giờ làm việc</h3>
                    <p class="text-gray-600">Thứ Hai - Thứ Sáu: 08:00 - 18:00</p>
                    <p class="text-gray-600">Thứ Bảy - Chủ Nhật: 10:00 - 16:00</p>
                </div>
            </div>
        </div>
        
        <!-- Contact Form -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Gửi tin nhắn</h2>
            
            <form class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Họ tên
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                        required
                    >
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                        required
                    >
                </div>
                
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                        Tin nhắn
                    </label>
                    <textarea 
                        id="message" 
                        name="message" 
                        rows="5"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                        required
                    ></textarea>
                </div>
                
                <button 
                    type="submit" 
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200"
                >
                    Gửi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
