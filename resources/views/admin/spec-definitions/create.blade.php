@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.spec-definitions.index', ['component_type_id' => request('component_type_id')]) }}" 
               class="mr-4 text-gray-600 hover:text-black transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Thêm Thông Số Kỹ Thuật</h1>
                <p class="text-gray-600 mt-1">Tạo thông số mới cho loại linh kiện</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <form action="{{ route('admin.spec-definitions.store') }}" method="POST">
            @csrf

            <!-- Component Type -->
            <div class="mb-6">
                <label class="block text-gray-900 text-sm font-bold mb-2">
                    Loại linh kiện <span class="text-red-500">*</span>
                </label>
                <select name="component_type_id" 
                        class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2 focus:border-black focus:outline-none transition @error('component_type_id') border-red-500 @enderror">
                    <option value="">-- Chọn loại linh kiện --</option>
                    @foreach($componentTypes as $type)
                    <option value="{{ $type->id }}" {{ old('component_type_id', $selectedComponentTypeId) == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                    @endforeach
                </select>
                @error('component_type_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-600 text-xs mt-1">Để trống nếu thông số này áp dụng cho tất cả loại linh kiện</p>
            </div>

            <!-- Name -->
            <div class="mb-6">
                <label class="block text-gray-900 text-sm font-bold mb-2">
                    Tên thông số <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       placeholder="VD: Số nhân, Dung lượng RAM, Tốc độ xung nhịp..."
                       class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2 focus:border-black focus:outline-none transition @error('name') border-red-500 @enderror">
                @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Code -->
            <div class="mb-6">
                <label class="block text-gray-900 text-sm font-bold mb-2">
                    Code (mã nội bộ) <span class="text-red-500">*</span>
                </label>
                <input type="text" name="code" value="{{ old('code') }}" 
                       placeholder="VD: core_count, ram_capacity, clock_speed..."
                       class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2 focus:border-black focus:outline-none transition font-mono @error('code') border-red-500 @enderror">
                @error('code')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-600 text-xs mt-1">Dùng chữ thường, gạch dưới, không dấu. VD: core_count</p>
            </div>

            <!-- Unit -->
            <div class="mb-6">
                <label class="block text-gray-900 text-sm font-bold mb-2">
                    Đơn vị
                </label>
                <input type="text" name="unit" value="{{ old('unit') }}" 
                       placeholder="VD: core, GB, GHz, W, inch..."
                       class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2 focus:border-black focus:outline-none transition @error('unit') border-red-500 @enderror">
                @error('unit')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Type -->
            <div class="mb-6">
                <label class="block text-gray-900 text-sm font-bold mb-2">
                    Kiểu nhập liệu <span class="text-red-500">*</span>
                </label>
                <select name="input_type" 
                        class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2 focus:border-black focus:outline-none transition @error('input_type') border-red-500 @enderror">
                    <option value="text" {{ old('input_type') == 'text' ? 'selected' : '' }}>Text</option>
                    <option value="number" {{ old('input_type') == 'number' ? 'selected' : '' }}>Number</option>
                    <option value="textarea" {{ old('input_type') == 'textarea' ? 'selected' : '' }}>Textarea</option>
                    <option value="select" {{ old('input_type') == 'select' ? 'selected' : '' }}>Select (dropdown)</option>
                </select>
                @error('input_type')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Options (for select) -->
            <div class="mb-6">
                <label class="block text-gray-900 text-sm font-bold mb-2">
                    Options (JSON - chỉ dành cho kiểu Select)
                </label>
                <textarea name="options" rows="4" 
                          placeholder='["Intel", "AMD"] hoặc {"intel": "Intel Core", "amd": "AMD Ryzen"}'
                          class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2 focus:border-black focus:outline-none transition font-mono text-sm @error('options') border-red-500 @enderror">{{ old('options') }}</textarea>
                @error('options')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-600 text-xs mt-1">Nhập JSON array hoặc object. VD: ["Option 1", "Option 2"]</p>
            </div>

            <!-- Sort Order -->
            <div class="mb-6">
                <label class="block text-gray-900 text-sm font-bold mb-2">
                    Thứ tự hiển thị
                </label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                       class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2 focus:border-black focus:outline-none transition @error('sort_order') border-red-500 @enderror">
                @error('sort_order')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-600 text-xs mt-1">Số nhỏ hơn sẽ hiển thị trước</p>
            </div>

            <!-- Checkboxes -->
            <div class="mb-6 space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" name="is_required" value="1" {{ old('is_required') ? 'checked' : '' }}
                           class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black">
                    <span class="ml-2 text-gray-900 text-sm font-medium">Bắt buộc nhập</span>
                </label>

                <label class="flex items-center">
                    <input type="checkbox" name="is_filterable" value="1" {{ old('is_filterable') ? 'checked' : '' }}
                           class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black">
                    <span class="ml-2 text-gray-900 text-sm font-medium">Có thể dùng để lọc sản phẩm</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex gap-4 pt-4 border-t border-gray-200">
                <button type="submit" 
                        class="px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition font-bold">
                    Tạo Thông Số
                </button>
                <a href="{{ route('admin.spec-definitions.index', ['component_type_id' => request('component_type_id')]) }}" 
                   class="px-6 py-3 bg-gray-100 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
