@extends('layouts.app')

@section('title', 'Tạo sản phẩm - Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-cyber-text mb-2">Tạo sản phẩm mới</h1>
        <a href="{{ route('admin.products.index') }}" class="text-cyber-accent hover:text-cyber-glow">← Quay lại danh sách</a>
    </div>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="max-w-2xl">
        @csrf

        {{-- Name --}}
        <div class="mb-6">
            <label class="block text-cyber-text font-semibold mb-2">Tên sản phẩm</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none" required>
            @error('name') <span class="text-cyber-error text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Slug --}}
        <div class="mb-6">
            <label class="block text-cyber-text font-semibold mb-2">Slug</label>
            <input type="text" name="slug" value="{{ old('slug') }}" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none" required>
            @error('slug') <span class="text-cyber-error text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Category & Manufacturer --}}
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-cyber-text font-semibold mb-2">Danh mục</label>
                <select name="category_id" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-cyber-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-cyber-text font-semibold mb-2">Nhà sản xuất</label>
                <select name="manufacturer_id" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none">
                    <option value="">-- Chọn nhà sản xuất --</option>
                    @foreach($manufacturers as $mfr)
                        <option value="{{ $mfr->id }}" {{ old('manufacturer_id') == $mfr->id ? 'selected' : '' }}>{{ $mfr->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Price --}}
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-cyber-text font-semibold mb-2">Giá</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none" required>
                @error('price') <span class="text-cyber-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-cyber-text font-semibold mb-2">Giá sale (tùy chọn)</label>
                <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none">
            </div>
        </div>

        {{-- SKU --}}
        <div class="mb-6">
            <label class="block text-cyber-text font-semibold mb-2">SKU</label>
            <input type="text" name="sku" value="{{ old('sku') }}" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none" required>
            @error('sku') <span class="text-cyber-error text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Description --}}
        <div class="mb-6">
            <label class="block text-cyber-text font-semibold mb-2">Mô tả</label>
            <textarea name="description" rows="4" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none">{{ old('description') }}</textarea>
        </div>

        {{-- Images --}}
        <div class="mb-6">
            <label class="block text-cyber-text font-semibold mb-2">Hình ảnh (tối đa 5)</label>
            <input type="file" name="images[]" multiple accept="image/*" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text">
            @error('images') <span class="text-cyber-error text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Status --}}
        <div class="mb-8">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="rounded">
                <span class="text-cyber-text font-semibold">Kích hoạt</span>
            </label>
        </div>

        {{-- Buttons --}}
        <div class="flex gap-4">
            <button type="submit" class="px-6 py-2 bg-cyber-accent text-cyber-darker rounded-lg font-bold hover:shadow-glow-cyan transition-all">
                Tạo sản phẩm
            </button>
            <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border border-cyber-border text-cyber-text rounded-lg hover:border-cyber-accent transition-all">
                Hủy
            </a>
        </div>
    </form>
</div>
@endsection
