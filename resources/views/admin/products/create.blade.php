@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center space-x-4 mb-8">
            <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-900 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Thêm sản phẩm mới</h1>
        </div>

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Basic Information -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Thông tin cơ bản</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Name --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Tên sản phẩm *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2.5 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none transition @error('name') border-red-500 @enderror">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Slug *</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" required
                            class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2.5 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none transition @error('slug') border-red-500 @enderror">
                        @error('slug') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Danh mục *</label>
                        <select name="category_id" required
                            class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2.5 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none transition @error('category_id') border-red-500 @enderror">
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Brand --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Thương hiệu</label>
                        <select name="brand_id"
                            class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2.5 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none transition">
                            <option value="">Chọn thương hiệu</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Price --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Giá (VNĐ) *</label>
                        <input type="number" step="1000" name="price" value="{{ old('price') }}" required
                            class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2.5 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none transition @error('price') border-red-500 @enderror">
                        @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Sale Price --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Giá khuyến mãi</label>
                        <input type="number" step="1000" name="sale_price" value="{{ old('sale_price') }}"
                            class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2.5 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none transition">
                    </div>

                    {{-- SKU --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">SKU *</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" required
                            class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2.5 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none transition @error('sku') border-red-500 @enderror">
                        @error('sku') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Mô tả</label>
                    <textarea name="description" rows="4"
                        class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2.5 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none transition">{{ old('description') }}</textarea>
                </div>

                {{-- Status --}}
                <div class="flex items-center space-x-3 mt-6">
                    <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-gray-900 focus:ring-gray-900 cursor-pointer">
                    <span class="text-gray-700 text-sm font-medium cursor-pointer">Hiển thị sản phẩm</span>
                </div>
            </div>

            {{-- Images --}}
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Hình ảnh sản phẩm</h2>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-gray-400 transition"
                    id="imageDropZone">
                    <svg class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <p class="text-gray-700 font-medium">Nhấn để tải lên hoặc kéo thả</p>
                    <p class="text-gray-400 text-sm mt-1">Tối đa 5 ảnh, mỗi ảnh 2MB</p>
                    <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden">
                </div>
                @error('images') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition font-medium">
                    Tạo sản phẩm
                </button>
                <a href="{{ route('admin.products.index') }}"
                    class="flex-1 px-6 py-3 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium text-center">
                    Hủy
                </a>
            </div>
        </form>
    </div>

    <script>
        // Image upload handler
        const imageDropZone = document.getElementById('imageDropZone');
        const imageInput = document.getElementById('images');

        imageDropZone.addEventListener('click', () => imageInput.click());
        imageDropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            imageDropZone.classList.add('border-gray-400');
        });
        imageDropZone.addEventListener('dragleave', () => {
            imageDropZone.classList.remove('border-gray-400');
        });
        imageDropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            imageInput.files = e.dataTransfer.files;
            imageDropZone.classList.remove('border-gray-400');
        });
    </script>
@endsection