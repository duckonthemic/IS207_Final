@extends('layouts.admin')

@section('title', 'Tạo sản phẩm - Admin')

@section('content')
<div class="min-h-screen bg-cyber-dark py-8">
    <div class="max-w-4xl mx-auto px-4">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.products.index') }}" class="text-cyber-accent hover:text-cyan-300 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-cyber-accent">Tạo Sản Phẩm Mới</h1>
                <p class="text-cyber-muted text-sm mt-1">Thêm sản phẩm mới vào kho</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Basic Information --}}
            <div class="bg-cyber-darker border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-accent mb-6">Thông Tin Cơ Bản</h2>

                {{-- Name & SKU --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-cyber-text text-sm font-semibold mb-2">Tên sản phẩm *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full bg-cyber-card border border-cyber-border rounded px-4 py-2 text-cyber-text focus:border-cyber-accent focus:outline-none transition @error('name') border-cyber-error @enderror">
                        @error('name') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-cyber-text text-sm font-semibold mb-2">SKU *</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" required
                            class="w-full bg-cyber-card border border-cyber-border rounded px-4 py-2 text-cyber-text focus:border-cyber-accent focus:outline-none transition @error('sku') border-cyber-error @enderror">
                        @error('sku') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Slug --}}
                <div class="mb-6">
                    <label class="block text-cyber-text text-sm font-semibold mb-2">Slug *</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" required
                        class="w-full bg-cyber-card border border-cyber-border rounded px-4 py-2 text-cyber-text focus:border-cyber-accent focus:outline-none transition @error('slug') border-cyber-error @enderror">
                    @error('slug') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Category & Brand --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-cyber-text text-sm font-semibold mb-2">Danh Mục *</label>
                        <select name="category_id" required
                            class="w-full bg-cyber-card border border-cyber-border rounded px-4 py-2 text-cyber-text focus:border-cyber-accent focus:outline-none transition @error('category_id') border-cyber-error @enderror">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-cyber-text text-sm font-semibold mb-2">Nhà Sản Xuất</label>
                        <select name="brand_id"
                            class="w-full bg-cyber-card border border-cyber-border rounded px-4 py-2 text-cyber-text focus:border-cyber-accent focus:outline-none transition @error('brand_id') border-cyber-error @enderror">
                            <option value="">-- Chọn nhà sản xuất --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Component Type (for specs) --}}
                <div class="mb-6">
                    <label class="block text-cyber-text text-sm font-semibold mb-2">Loại Linh Kiện</label>
                    <select name="component_type_id" id="component_type_id"
                        class="w-full bg-cyber-card border border-cyber-border rounded px-4 py-2 text-cyber-text focus:border-cyber-accent focus:outline-none transition">
                        <option value="">-- Chọn loại linh kiện --</option>
                        @foreach($componentTypes as $type)
                            <option value="{{ $type->id }}" {{ old('component_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('component_type_id') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-cyber-text text-sm font-semibold mb-2">Mô Tả</label>
                    <textarea name="description" rows="4"
                        class="w-full bg-cyber-card border border-cyber-border rounded px-4 py-2 text-cyber-text focus:border-cyber-accent focus:outline-none transition">{{ old('description') }}</textarea>
                </div>
            </div>

            {{-- Pricing --}}
            <div class="bg-cyber-darker border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-accent mb-6">Giá Bán</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-cyber-text text-sm font-semibold mb-2">Giá Bán *</label>
                        <input type="number" name="price" value="{{ old('price') }}" required min="0" step="1"
                            class="w-full bg-cyber-card border border-cyber-border rounded px-4 py-2 text-cyber-text focus:border-cyber-accent focus:outline-none transition @error('price') border-cyber-error @enderror">
                        @error('price') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-cyber-text text-sm font-semibold mb-2">Giá Sale</label>
                        <input type="number" name="sale_price" value="{{ old('sale_price') }}" min="0" step="1"
                            class="w-full bg-cyber-card border border-cyber-border rounded px-4 py-2 text-cyber-text focus:border-cyber-accent focus:outline-none transition @error('sale_price') border-cyber-error @enderror">
                        @error('sale_price') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-cyber-text text-sm font-semibold mb-2">Số Lượng Kho *</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0" step="1"
                            class="w-full bg-cyber-card border border-cyber-border rounded px-4 py-2 text-cyber-text focus:border-cyber-accent focus:outline-none transition @error('stock') border-cyber-error @enderror">
                        @error('stock') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-cyber-text text-sm font-semibold mb-2">Thời Gian Bảo Hành (tháng)</label>
                    <input type="number" name="warranty_months" value="{{ old('warranty_months', 12) }}" min="0" step="1"
                        class="w-full bg-cyber-card border border-cyber-border rounded px-4 py-2 text-cyber-text focus:border-cyber-accent focus:outline-none transition">
                </div>
            </div>

            {{-- Features --}}
            <div class="bg-cyber-darker border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-accent mb-6">Tính Năng</h2>

                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                            class="w-4 h-4 rounded bg-cyber-card border border-cyber-border cursor-pointer">
                        <span class="text-cyber-text font-semibold">Sản Phẩm Nổi Bật</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-4 h-4 rounded bg-cyber-card border border-cyber-border cursor-pointer">
                        <span class="text-cyber-text font-semibold">Kích Hoạt</span>
                    </label>
                </div>
            </div>

            {{-- Image --}}
            <div class="bg-cyber-darker border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-accent mb-6">Hình Ảnh</h2>

                <div>
                    <label class="block text-cyber-text text-sm font-semibold mb-2">URL Hình Ảnh</label>
                    <input type="text" name="image" value="{{ old('image') }}"
                        class="w-full bg-cyber-card border border-cyber-border rounded px-4 py-2 text-cyber-text focus:border-cyber-accent focus:outline-none transition"
                        placeholder="https://example.com/image.jpg">
                    @error('image') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-4">
                <button type="submit" class="px-8 py-3 bg-cyber-accent text-cyber-darker rounded-lg font-bold hover:shadow-lg shadow-cyan-500/50 transition-all">
                    Tạo Sản Phẩm
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-8 py-3 border border-cyber-border text-cyber-text rounded-lg hover:border-cyber-accent transition-all">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Load spec definitions when component type changes
    const componentTypeSelect = document.getElementById('component_type_id');
    if (componentTypeSelect) {
        componentTypeSelect.addEventListener('change', function() {
            // TODO: Load specs dynamically
        });
    }
</script>
@endsection
