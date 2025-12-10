@extends('layouts.app')

@section('title', 'Chỉnh sửa địa chỉ - UITech')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm mb-8 text-gray-500">
                <a href="{{ route('profile.edit') }}" class="hover:text-gray-900 transition-colors">Hồ sơ cá nhân</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="{{ route('addresses.index') }}" class="hover:text-gray-900 transition-colors">Địa chỉ giao hàng</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">Chỉnh sửa</span>
            </nav>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100">
                    <h1 class="text-xl font-bold text-gray-900">Chỉnh sửa địa chỉ</h1>
                    <p class="text-sm text-gray-500 mt-1">Cập nhật thông tin địa chỉ giao hàng</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('addresses.update', $address) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Label Selection --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Loại địa chỉ</label>
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="label" value="Home" {{ old('label', $address->label) == 'Home' ? 'checked' : '' }} class="hidden peer">
                                    <div
                                        class="p-4 border-2 border-gray-200 rounded-xl text-center peer-checked:border-gray-900 peer-checked:bg-gray-50 transition-all">
                                        <span class="text-2xl mb-2 block">🏠</span>
                                        <span class="font-medium text-gray-700">Nhà riêng</span>
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="label" value="Office" {{ old('label', $address->label) == 'Office' ? 'checked' : '' }} class="hidden peer">
                                    <div
                                        class="p-4 border-2 border-gray-200 rounded-xl text-center peer-checked:border-gray-900 peer-checked:bg-gray-50 transition-all">
                                        <span class="text-2xl mb-2 block">🏢</span>
                                        <span class="font-medium text-gray-700">Văn phòng</span>
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="label" value="Other" {{ old('label', $address->label) == 'Other' ? 'checked' : '' }} class="hidden peer">
                                    <div
                                        class="p-4 border-2 border-gray-200 rounded-xl text-center peer-checked:border-gray-900 peer-checked:bg-gray-50 transition-all">
                                        <span class="text-2xl mb-2 block">📍</span>
                                        <span class="font-medium text-gray-700">Khác</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Recipient Name --}}
                            <div>
                                <label for="recipient_name" class="block text-sm font-bold text-gray-700 mb-2">
                                    Họ và tên người nhận <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="recipient_name" id="recipient_name"
                                    value="{{ old('recipient_name', $address->fullname) }}" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all"
                                    placeholder="Nhập họ và tên">
                                @error('recipient_name')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">
                                    Số điện thoại <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', $address->phone) }}"
                                    required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all"
                                    placeholder="0xxx xxx xxx">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- City --}}
                            <div>
                                <label for="city" class="block text-sm font-bold text-gray-700 mb-2">
                                    Tỉnh/Thành phố <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="city" id="city" value="{{ old('city', $address->city) }}" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all"
                                    placeholder="Ví dụ: Hồ Chí Minh">
                                @error('city')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- District --}}
                            <div>
                                <label for="district" class="block text-sm font-bold text-gray-700 mb-2">
                                    Quận/Huyện <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="district" id="district"
                                    value="{{ old('district', $address->district) }}" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all"
                                    placeholder="Ví dụ: Quận 1">
                                @error('district')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Ward --}}
                            <div>
                                <label for="ward" class="block text-sm font-bold text-gray-700 mb-2">
                                    Phường/Xã
                                </label>
                                <input type="text" name="ward" id="ward" value="{{ old('ward', $address->ward) }}"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all"
                                    placeholder="Ví dụ: Phường Bến Nghé">
                                @error('ward')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Postal Code --}}
                            <div>
                                <label for="postal_code" class="block text-sm font-bold text-gray-700 mb-2">
                                    Mã bưu điện
                                </label>
                                <input type="text" name="postal_code" id="postal_code"
                                    value="{{ old('postal_code', $address->postal_code) }}"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all"
                                    placeholder="Ví dụ: 70000">
                                @error('postal_code')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Address Line --}}
                        <div>
                            <label for="address_line" class="block text-sm font-bold text-gray-700 mb-2">
                                Địa chỉ chi tiết <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address_line" id="address_line" rows="3" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all resize-none"
                                placeholder="Số nhà, tên đường, tòa nhà, căn hộ...">{{ old('address_line', $address->address) }}</textarea>
                            @error('address_line')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Default Checkbox --}}
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <label class="flex items-center cursor-pointer gap-3">
                                <input type="checkbox" name="is_default" value="1" {{ old('is_default', $address->is_default) ? 'checked' : '' }}
                                    class="w-5 h-5 rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                                <div>
                                    <span class="font-medium text-gray-900">Đặt làm địa chỉ mặc định</span>
                                    <p class="text-sm text-gray-500">Địa chỉ này sẽ được tự động chọn khi bạn đặt hàng</p>
                                </div>
                            </label>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <button type="submit"
                                class="flex-1 px-6 py-4 bg-gray-900 text-white rounded-xl font-bold hover:bg-gray-800 transition-all shadow-lg hover:shadow-gray-900/20">
                                Cập nhật địa chỉ
                            </button>
                            <a href="{{ route('addresses.index') }}"
                                class="flex-1 px-6 py-4 border-2 border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition-all text-center">
                                Hủy bỏ
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection