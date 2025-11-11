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
        <h1 class="text-3xl font-bold text-cyber-accent">Edit Product</h1>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')

        <!-- Basic Information -->
        <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-cyber-accent mb-6">Basic Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Product Name -->
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Product Name *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition @error('name') border-cyber-error @enderror">
                    @error('name') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">SKU *</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition @error('sku') border-cyber-error @enderror">
                    @error('sku') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Category *</label>
                    <select name="category_id" required class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition @error('category_id') border-cyber-error @enderror">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Manufacturer -->
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Manufacturer</label>
                    <select name="manufacturer_id" class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">
                        <option value="">Select Manufacturer</option>
                        @foreach ($manufacturers as $manufacturer)
                        <option value="{{ $manufacturer->id }}" {{ old('manufacturer_id', $product->manufacturer_id) == $manufacturer->id ? 'selected' : '' }}>
                            {{ $manufacturer->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Price (VNĐ) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="1000" required class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition @error('price') border-cyber-error @enderror">
                    @error('price') <p class="text-cyber-error text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Sale Price -->
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Sale Price (VNĐ)</label>
                    <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" min="0" step="1000" class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-cyber-accent text-sm font-medium mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Status -->
            <div class="flex items-center space-x-3 mt-6">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded cursor-pointer">
                <label for="is_active" class="text-cyber-accent text-sm font-medium cursor-pointer">Active</label>
            </div>
        </div>

        <!-- Current Images -->
        @if ($product->images->count() > 0)
        <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-cyber-accent mb-6">Current Images</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($product->images as $image)
                <div class="relative group">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product image" class="w-full h-40 object-cover rounded-lg">
                    <form action="{{ route('admin.products.deleteImage', $image) }}" method="POST" class="absolute inset-0 bg-cyber-dark bg-opacity-0 group-hover:bg-opacity-70 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition" onsubmit="return confirm('Delete this image?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-cyber-error text-white rounded hover:bg-red-600 transition text-sm font-medium">
                            Delete
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- New Images -->
        <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-cyber-accent mb-6">Add New Images</h2>
            <div class="border-2 border-dashed border-cyber-accent border-opacity-30 rounded-lg p-6 text-center cursor-pointer hover:border-opacity-60 transition" id="imageDropZone">
                <svg class="w-12 h-12 text-cyber-accent mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <p class="text-cyber-accent font-medium">Click to upload or drag and drop</p>
                <p class="text-cyber-muted text-sm">Max 2MB per image, PNG/JPG/WebP</p>
                <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden" />
            </div>
            @error('images') <p class="text-cyber-error text-sm mt-2">{{ $message }}</p> @enderror
        </div>

        <!-- Product Specifications -->
        <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-cyber-accent mb-6">Specifications</h2>
            <div id="specs-container" class="space-y-4">
                @forelse ($product->specs as $index => $spec)
                <div class="flex gap-3">
                    <input type="text" name="specs[{{ $index }}][key]" value="{{ $spec->spec_key }}" placeholder="Spec key (e.g., CPU, RAM)" class="flex-1 bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">
                    <input type="text" name="specs[{{ $index }}][value]" value="{{ $spec->spec_value }}" placeholder="Spec value" class="flex-1 bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">
                    <button type="button" class="px-4 py-2 bg-cyber-error bg-opacity-20 text-cyber-error rounded-lg hover:bg-opacity-40 transition remove-spec">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                @empty
                <p class="text-cyber-muted text-sm">No specifications yet</p>
                @endforelse
            </div>
            <button type="button" id="add-spec" class="mt-4 px-4 py-2 bg-cyber-accent bg-opacity-20 text-cyber-accent rounded-lg hover:bg-opacity-40 transition font-medium">
                Add Specification
            </button>
        </div>

        <!-- Form Actions -->
        <div class="flex gap-4">
            <button type="submit" class="flex-1 px-6 py-3 bg-cyber-accent text-cyber-dark rounded-lg hover:bg-cyan-400 transition font-semibold">
                Update Product
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

    // Spec management
    let specCount = {{ $product->specs->count() }};
    document.getElementById('add-spec').addEventListener('click', () => {
        const container = document.getElementById('specs-container');
        const specDiv = document.createElement('div');
        specDiv.className = 'flex gap-3';
        specDiv.innerHTML = `
            <input type="text" name="specs[${specCount}][key]" placeholder="Spec key" class="flex-1 bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">
            <input type="text" name="specs[${specCount}][value]" placeholder="Spec value" class="flex-1 bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">
            <button type="button" class="px-4 py-2 bg-cyber-error bg-opacity-20 text-cyber-error rounded-lg hover:bg-opacity-40 transition remove-spec">
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
