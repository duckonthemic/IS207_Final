<x-auth-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sửa Địa Chỉ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form action="{{ route('addresses.update', $address) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Label --}}
                    <div class="mb-6">
                        <label for="label" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nhãn địa chỉ
                        </label>
                        <select name="label" id="label"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:text-gray-200">
                            <option value="Home" {{ old('label', $address->label) == 'Home' ? 'selected' : '' }}>🏠 Nhà
                                riêng</option>
                            <option value="Office" {{ old('label', $address->label) == 'Office' ? 'selected' : '' }}>🏢
                                Văn phòng</option>
                            <option value="Other" {{ old('label', $address->label) == 'Other' ? 'selected' : '' }}>📍 Khác
                            </option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Recipient Name --}}
                        <div>
                            <label for="recipient_name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Họ và tên người nhận <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="recipient_name" id="recipient_name"
                                value="{{ old('recipient_name', $address->recipient_name) }}" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:text-gray-200">
                            @error('recipient_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Số điện thoại <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $address->phone) }}"
                                required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:text-gray-200">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Address Line --}}
                    <div class="mt-6">
                        <label for="address_line"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Địa chỉ đầy đủ <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address_line" id="address_line" rows="3" required
                            placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:text-gray-200">{{ old('address_line', $address->address_line) }}</textarea>
                        @error('address_line')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Default Checkbox --}}
                    <div class="mt-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_default" value="1" {{ old('is_default', $address->is_default) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-cyan-500 focus:ring-cyan-500">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                Đặt làm địa chỉ mặc định
                            </span>
                        </label>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-4 mt-8">
                        <button type="submit"
                            class="bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-2 rounded-lg transition">
                            Cập Nhật
                        </button>
                        <a href="{{ route('addresses.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-200 px-6 py-2 rounded-lg transition">
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-auth-layout>