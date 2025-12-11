@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center space-x-4 mb-8">
        <a href="{{ route('admin.products.index') }}" class="text-cyber-white hover:text-gray-300 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <h1 class="text-3xl font-black text-cyber-white uppercase tracking-tighter">Edit Product</h1>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')

        <!-- Basic Information -->
        <div class="bg-cyber-black border border-cyber-border p-6">
            <h2 class="text-xl font-bold text-cyber-white mb-6 uppercase tracking-wider">Basic Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Product Name -->
                <div>
                    <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Product Name *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm @error('name') border-red-500 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">SKU *</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm @error('sku') border-red-500 @enderror">
                    @error('sku') <p class="text-red-500 text-xs mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Category *</label>
                    <select name="category_id" required class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm uppercase @error('category_id') border-red-500 @enderror">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-xs mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                </div>

                <!-- Brand -->
                <div>
                    <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Brand</label>
                    <select name="brand_id" class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm uppercase">
                        <option value="">Select Brand</option>
                        @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Price (VNĐ) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="1000" required class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm @error('price') border-red-500 @enderror">
                    @error('price') <p class="text-red-500 text-xs mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                </div>

                <!-- Sale Price -->
                <div>
                    <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Sale Price (VNĐ)</label>
                    <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" min="0" step="1000" class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm">
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Status -->
            <div class="flex items-center space-x-3 mt-6">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded-none border-cyber-border bg-cyber-gray text-cyber-white focus:ring-0 cursor-pointer">
                <label for="is_active" class="text-cyber-white text-sm font-bold uppercase tracking-wider cursor-pointer">Active</label>
            </div>
        </div>

        <!-- Current Images -->
        @if ($product->images->count() > 0)
        <div class="bg-cyber-black border border-cyber-border p-6">
            <h2 class="text-xl font-bold text-cyber-white mb-6 uppercase tracking-wider">Current Images</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($product->images as $image)
                <div class="relative group border border-cyber-border bg-cyber-gray p-2">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product image" class="w-full h-32 object-contain">
                    <form action="{{ route('admin.products.deleteImage', $image) }}" method="POST" class="absolute inset-0 bg-black bg-opacity-80 flex items-center justify-center opacity-0 group-hover:opacity-100 transition" onsubmit="return confirm('Delete this image?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition text-xs font-bold uppercase tracking-wider">
                            Delete
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- New Images -->
        <div class="bg-cyber-black border border-cyber-border p-6">
            <h2 class="text-xl font-bold text-cyber-white mb-6 uppercase tracking-wider">Add New Images</h2>
            <div class="border-2 border-dashed border-cyber-border p-6 text-center cursor-pointer hover:border-cyber-white transition bg-cyber-gray" id="imageDropZone">
                <svg class="w-12 h-12 text-cyber-text-muted mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <p class="text-cyber-white font-bold uppercase tracking-wider text-sm">Click to upload or drag and drop</p>
                <p class="text-cyber-text-muted text-xs font-mono mt-1">Max 2MB per image, PNG/JPG/WebP</p>
                <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden" />
            </div>
            @error('images') <p class="text-red-500 text-xs mt-2 font-bold uppercase">{{ $message }}</p> @enderror
        </div>

        <!-- Product Specifications -->
        <div class="bg-cyber-black border border-cyber-border p-6">
            <h2 class="text-xl font-bold text-cyber-white mb-6 uppercase tracking-wider">Specifications</h2>
            <div id="specs-container" class="space-y-4">
                @forelse ($product->specs as $index => $spec)
                <div class="flex gap-3">
                    <input type="text" name="specs[{{ $index }}][key]" value="{{ $spec->spec_key }}" placeholder="SPEC KEY (E.G. CPU)" class="flex-1 bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm uppercase placeholder-cyber-text-muted">
                    <input type="text" name="specs[{{ $index }}][value]" value="{{ $spec->spec_value }}" placeholder="SPEC VALUE" class="flex-1 bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm placeholder-cyber-text-muted">
                    <button type="button" class="px-4 py-2 border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition remove-spec">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                @empty
                <p class="text-cyber-text-muted text-sm font-mono uppercase">No specifications yet</p>
                @endforelse
            </div>
            <button type="button" id="add-spec" class="mt-4 px-4 py-2 border border-cyber-white text-cyber-white hover:bg-cyber-white hover:text-cyber-black transition font-bold uppercase tracking-wider text-sm">
                Add Specification
            </button>
        </div>

        <!-- Form Actions -->
        <div class="flex gap-4">
            <button type="submit" class="flex-1 px-6 py-3 bg-cyber-white text-cyber-black hover:bg-gray-800 transition font-bold uppercase tracking-wider text-sm">
                Update Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="flex-1 px-6 py-3 bg-transparent border border-cyber-white text-cyber-white hover:bg-cyber-white hover:text-cyber-black transition font-bold uppercase tracking-wider text-sm text-center">
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
        imageDropZone.classList.add('border-cyber-white');
    });
    imageDropZone.addEventListener('dragleave', () => {
        imageDropZone.classList.remove('border-cyber-white');
    });
    imageDropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        imageInput.files = e.dataTransfer.files;
        imageDropZone.classList.remove('border-cyber-white');
    });

    // Spec management
    let specCount = {{ $product->specs->count() }};
    document.getElementById('add-spec').addEventListener('click', () => {
        const container = document.getElementById('specs-container');
        const specDiv = document.createElement('div');
        specDiv.className = 'flex gap-3';
        specDiv.innerHTML = `
            <input type="text" name="specs[${specCount}][key]" placeholder="SPEC KEY" class="flex-1 bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm uppercase placeholder-cyber-text-muted">
            <input type="text" name="specs[${specCount}][value]" placeholder="SPEC VALUE" class="flex-1 bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm placeholder-cyber-text-muted">
            <button type="button" class="px-4 py-2 border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition remove-spec">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        `;
        container.appendChild(specDiv);
        specCount++;
        attachRemoveListeners();
    });

    function attachRemoveListeners() {
        document.querySelectorAll('.remove-spec').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.target.closest('.flex').remove();
            });
        });
    }

    attachRemoveListeners();
</script>
@endsection
