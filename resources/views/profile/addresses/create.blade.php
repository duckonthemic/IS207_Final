<x-auth-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Thêm Địa Chỉ Mới') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form action="{{ route('addresses.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Fullname --}}
                        <div>
                            <label for="fullname" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Họ và tên <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="fullname" id="fullname" value="{{ old('fullname') }}" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:text-gray-200">
                            @error('fullname')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Số điện thoại <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:text-gray-200">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="mt-6">
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Địa chỉ <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" required
                            placeholder="Số nhà, tên đường..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:text-gray-200">
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                        {{-- Ward --}}
                        <div>
                            <label for="ward" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Phường/Xã
                            </label>
                            <input type="text" name="ward" id="ward" value="{{ old('ward') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:text-gray-200">
                        </div>

                        {{-- District --}}
                        <div>
                            <label for="district" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Quận/Huyện
                            </label>
                            <input type="text" name="district" id="district" value="{{ old('district') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:text-gray-200">
                        </div>

                        {{-- City --}}
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tỉnh/Thành phố <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="city" id="city" value="{{ old('city') }}" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:text-gray-200">
                            @error('city')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Postal Code --}}
                    <div class="mt-6">
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mã bưu điện (tùy chọn)
                        </label>
                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:text-gray-200">
                    </div>

                    {{-- Default Checkbox --}}
                    <div class="mt-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}
                                class="rounded border-gray-300 text-cyan-500 focus:ring-cyan-500">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                Đặt làm địa chỉ mặc định
                            </span>
                        </label>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-4 mt-8">
                        <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-2 rounded-lg transition">
                            Lưu Địa Chỉ
                        </button>
                        <a href="{{ route('addresses.index') }}" class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-200 px-6 py-2 rounded-lg transition">
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-auth-layout>
