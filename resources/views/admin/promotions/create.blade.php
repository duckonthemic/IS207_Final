@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.promotions.index') }}"
                class="text-cyber-text-muted hover:text-cyber-white transition text-sm font-mono mb-4 inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Quay lại danh sách
            </a>
            <h1 class="text-3xl font-black text-cyber-white uppercase tracking-tighter">Tạo Mã Giảm Giá</h1>
            <p class="text-cyber-text-muted font-mono text-sm mt-1">// NEW_PROMOTION_ENTRY</p>
        </div>

        <!-- Form -->
        <div class="bg-cyber-black border border-cyber-border p-6">
            <form action="{{ route('admin.promotions.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Code -->
                    <div>
                        <label for="code"
                            class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                            Mã giảm giá <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="code" id="code" value="{{ old('code') }}" required
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono uppercase"
                            placeholder="VD: SALE2024">
                        <p class="text-cyber-text-muted text-xs mt-1 font-mono">Mã sẽ tự động chuyển thành chữ hoa</p>
                        @error('code')
                            <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name"
                            class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                            Tên mã <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono"
                            placeholder="VD: Giảm 10% cuối năm">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description"
                        class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                        Mô tả
                    </label>
                    <textarea name="description" id="description" rows="2"
                        class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono resize-none"
                        placeholder="Mô tả chi tiết về mã giảm giá...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type -->
                    <div>
                        <label for="type"
                            class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                            Loại giảm giá <span class="text-red-500">*</span>
                        </label>
                        <select name="type" id="type" required
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono">
                            <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Phần trăm (%)
                            </option>
                            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Số tiền cố định (₫)</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Value -->
                    <div>
                        <label for="value"
                            class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                            Giá trị <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="value" id="value" value="{{ old('value') }}" required min="0" step="0.01"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono"
                            placeholder="VD: 10">
                        <p class="text-cyber-text-muted text-xs mt-1 font-mono">10 = 10% hoặc 10,000₫ tùy loại</p>
                        @error('value')
                            <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Min Order Value -->
                    <div>
                        <label for="min_order_value"
                            class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                            Đơn hàng tối thiểu (₫)
                        </label>
                        <input type="number" name="min_order_value" id="min_order_value"
                            value="{{ old('min_order_value') }}" min="0"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono"
                            placeholder="VD: 500000">
                        @error('min_order_value')
                            <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Discount -->
                    <div>
                        <label for="max_discount"
                            class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                            Giảm tối đa (₫)
                        </label>
                        <input type="number" name="max_discount" id="max_discount" value="{{ old('max_discount') }}" min="0"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono"
                            placeholder="VD: 100000">
                        <p class="text-cyber-text-muted text-xs mt-1 font-mono">Chỉ áp dụng cho loại %</p>
                        @error('max_discount')
                            <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Usage Limit -->
                    <div>
                        <label for="usage_limit"
                            class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                            Tổng lượt dùng tối đa
                        </label>
                        <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit') }}" min="1"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono"
                            placeholder="Để trống = Không giới hạn">
                        @error('usage_limit')
                            <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Usage Per User -->
                    <div>
                        <label for="usage_per_user"
                            class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                            Mỗi user dùng tối đa
                        </label>
                        <input type="number" name="usage_per_user" id="usage_per_user"
                            value="{{ old('usage_per_user', 1) }}" min="1"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono"
                            placeholder="1">
                        @error('usage_per_user')
                            <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Starts At -->
                    <div>
                        <label for="starts_at"
                            class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                            Bắt đầu từ
                        </label>
                        <input type="datetime-local" name="starts_at" id="starts_at" value="{{ old('starts_at') }}"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono">
                        @error('starts_at')
                            <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Expires At -->
                    <div>
                        <label for="expires_at"
                            class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                            Hết hạn lúc
                        </label>
                        <input type="datetime-local" name="expires_at" id="expires_at" value="{{ old('expires_at') }}"
                            class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono">
                        @error('expires_at')
                            <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Is Active -->
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="w-5 h-5 bg-cyber-gray border-2 border-cyber-border text-cyber-white focus:ring-0 focus:ring-offset-0 cursor-pointer">
                    <label for="is_active"
                        class="text-cyber-white text-sm font-bold uppercase tracking-wider cursor-pointer">
                        Kích hoạt ngay
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-4 pt-4 border-t border-cyber-border">
                    <button type="submit"
                        class="px-8 py-3 bg-cyber-white text-cyber-black hover:bg-gray-800 transition font-bold uppercase tracking-wider text-sm">
                        Tạo mã giảm giá
                    </button>
                    <a href="{{ route('admin.promotions.index') }}"
                        class="px-8 py-3 bg-transparent border border-cyber-white text-cyber-white hover:bg-cyber-white hover:text-cyber-black transition font-bold uppercase tracking-wider text-sm">
                        Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection