<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            {{ __('Hồ sơ cá nhân') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                {{-- Sidebar Navigation --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                        {{-- User Avatar & Name --}}
                        <div class="p-6 border-b border-gray-100 text-center">
                            <div
                                class="w-20 h-20 bg-gray-900 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-3">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <h3 class="font-bold text-gray-900 text-lg">{{ auth()->user()->name }}</h3>
                            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        </div>

                        {{-- Navigation Links --}}
                        <nav class="p-4 space-y-1">
                            <a href="#profile-info"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors font-medium group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-900" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Thông tin cá nhân
                            </a>
                            <a href="{{ route('addresses.index') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors font-medium group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-900" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Địa chỉ giao hàng
                            </a>
                            <a href="{{ route('orders.index') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors font-medium group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-900" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Đơn hàng của tôi
                            </a>
                            <a href="#security"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors font-medium group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-900" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                Bảo mật
                            </a>
                        </nav>
                    </div>
                </div>

                {{-- Main Content --}}
                <div class="lg:col-span-3 space-y-6">
                    {{-- Profile Information Section --}}
                    <div id="profile-info"
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-gray-900">Thông tin cá nhân</h2>
                            <p class="text-sm text-gray-500 mt-1">Cập nhật thông tin hồ sơ và địa chỉ email của bạn</p>
                        </div>
                        <div class="p-8">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    {{-- Phone & Additional Info Section --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-gray-900">Thông tin liên hệ</h2>
                            <p class="text-sm text-gray-500 mt-1">Thêm số điện thoại để nhận thông báo đơn hàng</p>
                        </div>
                        <div class="p-8">
                            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                                @csrf
                                @method('patch')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Số điện
                                            thoại</label>
                                        <input type="tel" id="phone" name="phone"
                                            value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all"
                                            placeholder="0xxx xxx xxx">
                                    </div>
                                    <div>
                                        <label for="birthday" class="block text-sm font-bold text-gray-700 mb-2">Ngày
                                            sinh</label>
                                        <input type="date" id="birthday" name="birthday"
                                            value="{{ old('birthday', auth()->user()->birthday ?? '') }}"
                                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Giới tính</label>
                                    <div class="flex gap-6">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="gender" value="male" {{ (old('gender', auth()->user()->gender ?? '') == 'male') ? 'checked' : '' }}
                                                class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900">
                                            <span class="text-gray-700">Nam</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="gender" value="female" {{ (old('gender', auth()->user()->gender ?? '') == 'female') ? 'checked' : '' }}
                                                class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900">
                                            <span class="text-gray-700">Nữ</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="gender" value="other" {{ (old('gender', auth()->user()->gender ?? '') == 'other') ? 'checked' : '' }}
                                                class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900">
                                            <span class="text-gray-700">Khác</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <button type="submit"
                                        class="px-6 py-3 bg-gray-900 text-white rounded-xl font-bold hover:bg-gray-800 transition-all shadow-lg hover:shadow-gray-900/20">
                                        Cập nhật thông tin
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Addresses Quick View --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">Địa chỉ giao hàng</h2>
                                <p class="text-sm text-gray-500 mt-1">Quản lý các địa chỉ nhận hàng của bạn</p>
                            </div>
                            <a href="{{ route('addresses.create') }}"
                                class="px-4 py-2 bg-gray-900 text-white rounded-xl font-bold text-sm hover:bg-gray-800 transition-all">
                                + Thêm địa chỉ
                            </a>
                        </div>
                        <div class="p-8">
                            @php
                                $addresses = auth()->user()->addresses ?? collect();
                            @endphp

                            @if($addresses->isEmpty())
                                <div class="text-center py-8">
                                    <div
                                        class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 mb-4">Bạn chưa có địa chỉ giao hàng nào</p>
                                    <a href="{{ route('addresses.create') }}"
                                        class="inline-block px-6 py-3 bg-gray-900 text-white rounded-xl font-bold hover:bg-gray-800 transition-all">
                                        Thêm địa chỉ đầu tiên
                                    </a>
                                </div>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($addresses->take(2) as $address)
                                        <div
                                            class="p-4 border-2 {{ $address->is_default ? 'border-gray-900' : 'border-gray-100' }} rounded-xl relative">
                                            @if($address->is_default)
                                                <span
                                                    class="absolute top-3 right-3 px-2 py-1 bg-gray-900 text-white text-xs font-bold rounded-full">
                                                    Mặc định
                                                </span>
                                            @endif
                                            <p class="font-bold text-gray-900">{{ $address->fullname }}</p>
                                            <p class="text-sm text-gray-500 mt-1">{{ $address->phone }}</p>
                                            <p class="text-sm text-gray-600 mt-2">
                                                {{ $address->address }}
                                                @if($address->ward), {{ $address->ward }}@endif
                                                @if($address->district), {{ $address->district }}@endif
                                                @if($address->city), {{ $address->city }}@endif
                                            </p>
                                            <a href="{{ route('addresses.edit', $address) }}"
                                                class="inline-block mt-3 text-sm font-medium text-gray-900 hover:text-gray-700">
                                                Chỉnh sửa →
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                @if($addresses->count() > 2)
                                    <div class="mt-4 text-center">
                                        <a href="{{ route('addresses.index') }}"
                                            class="text-sm font-medium text-gray-900 hover:text-gray-700">
                                            Xem tất cả {{ $addresses->count() }} địa chỉ →
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    {{-- Security Section --}}
                    <div id="security" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100">
                            <h2 class="text-xl font-bold text-gray-900">Bảo mật tài khoản</h2>
                            <p class="text-sm text-gray-500 mt-1">Đảm bảo tài khoản của bạn luôn được an toàn</p>
                        </div>
                        <div class="p-8">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    {{-- Delete Account Section --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-red-100">
                            <h2 class="text-xl font-bold text-red-600">Xóa tài khoản</h2>
                            <p class="text-sm text-gray-500 mt-1">Hành động này không thể hoàn tác</p>
                        </div>
                        <div class="p-8">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>