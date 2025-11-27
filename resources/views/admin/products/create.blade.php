@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center space-x-4 mb-8">
        <a href="{{ route('admin.products.index') }}" class="text-cyber-accent hover:text-cyan-300 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-cyber-accent">Create New Product</h1>
    </div>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-cyber-accent mb-6">Basic Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Name --}}
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Product Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition @error('name') border-cyber-error @enderror">
                    @error('name') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Slug --}}
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Slug *</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" required class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition @error('slug') border-cyber-error @enderror">
                    @error('slug') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Category *</label>
                    <select name="category_id" required class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition @error('category_id') border-cyber-error @enderror">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Manufacturer --}}
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Manufacturer</label>
                    <select name="manufacturer_id" class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">
                        <option value="">Select Manufacturer</option>
                        @foreach($manufacturers as $mfr)
                            <option value="{{ $mfr->id }}" {{ old('manufacturer_id') == $mfr->id ? 'selected' : '' }}>{{ $mfr->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Price --}}
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Price (VNĐ) *</label>
                    <input type="number" step="1000" name="price" value="{{ old('price') }}" required class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition @error('price') border-cyber-error @enderror">
                    @error('price') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Sale Price --}}
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Sale Price (Optional)</label>
                    <input type="number" step="1000" name="sale_price" value="{{ old('sale_price') }}" class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">
                </div>

                {{-- SKU --}}
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">SKU *</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" required class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition @error('sku') border-cyber-error @enderror">
                    @error('sku') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-cyber-accent text-sm font-medium mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">{{ old('description') }}</textarea>
            </div>

            {{-- Status --}}
            <div class="flex items-center space-x-3 mt-6">
                <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="w-4 h-4 rounded cursor-pointer">
                <span class="text-cyber-accent text-sm font-medium cursor-pointer">Active</span>
            </div>
        </div>

        {{-- Images --}}
        <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-cyber-accent mb-6">Product Images</h2>
            <div class="border-2 border-dashed border-cyber-accent border-opacity-30 rounded-lg p-6 text-center cursor-pointer hover:border-opacity-60 transition" id="imageDropZone">
                <svg class="w-12 h-12 text-cyber-accent mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <p class="text-cyber-accent font-medium">Click to upload or drag and drop</p>
                <p class="text-cyber-muted text-sm">Max 5 images, 2MB per image</p>
                <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden">
            </div>
            @error('images') <p class="text-cyber-error text-sm mt-2">{{ $message }}</p> @enderror
        </div>

        {{-- Buttons --}}
        <div class="flex gap-4">
            <button type="submit" class="flex-1 px-6 py-3 bg-cyber-accent text-cyber-dark rounded-lg hover:bg-cyan-400 transition font-semibold">
                Create Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="flex-1 px-6 py-3 bg-cyber-darker text-cyber-accent border border-cyber-accent rounded-lg hover:bg-cyber-accent hover:text-cyber-dark transition font-semibold text-center">
                Cancel
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
        imageDropZone.classList.add('border-cyber-accent');
    });
    imageDropZone.addEventListener('dragleave', () => {
        imageDropZone.classList.remove('border-cyber-accent');
    });
    imageDropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        imageInput.files = e.dataTransfer.files;
        imageDropZone.classList.remove('border-cyber-accent');
    });
</script>
@endsection
