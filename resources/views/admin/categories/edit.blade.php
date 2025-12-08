@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.categories.index') }}" class="text-cyber-text-muted hover:text-cyber-white transition text-sm font-mono mb-4 inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Categories
        </a>
        <h1 class="text-3xl font-black text-cyber-white uppercase tracking-tighter">Edit Category</h1>
        <p class="text-cyber-text-muted font-mono text-sm mt-1">// EDIT: {{ strtoupper($category->name) }}</p>
    </div>

    <!-- Form -->
    <div class="bg-cyber-black border border-cyber-border p-6">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                       class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono"
                       placeholder="Nhập tên danh mục...">
                @error('name')
                    <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                    Slug <span class="text-cyber-text-muted font-normal">(để trống để tự tạo)</span>
                </label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}"
                       class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono"
                       placeholder="vd: cpu-vi-xu-ly">
                @error('slug')
                    <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parent Category -->
            <div>
                <label for="parent_id" class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                    Parent Category
                </label>
                <select name="parent_id" id="parent_id"
                        class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono">
                    <option value="">-- Không có (Danh mục gốc) --</option>
                    @foreach ($parentCategories as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                    Description
                </label>
                <textarea name="description" id="description" rows="3"
                          class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono resize-none"
                          placeholder="Mô tả ngắn về danh mục...">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sort Order -->
            <div>
                <label for="sort_order" class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">
                    Sort Order
                </label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0"
                       class="w-32 bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono">
                @error('sort_order')
                    <p class="text-red-500 text-xs mt-1 font-mono">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Active -->
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" 
                       {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                       class="w-5 h-5 bg-cyber-gray border-2 border-cyber-border text-cyber-white focus:ring-0 focus:ring-offset-0 cursor-pointer">
                <label for="is_active" class="text-cyber-white text-sm font-bold uppercase tracking-wider cursor-pointer">
                    Active
                </label>
            </div>

            <!-- Category Stats -->
            <div class="bg-cyber-gray border border-cyber-border p-4 space-y-2">
                <p class="text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-3">Category Stats</p>
                <div class="flex justify-between text-sm">
                    <span class="text-cyber-text-muted">Products:</span>
                    <span class="text-cyber-white font-mono font-bold">{{ $category->products()->count() }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-cyber-text-muted">Created:</span>
                    <span class="text-cyber-white font-mono">{{ $category->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-cyber-text-muted">Updated:</span>
                    <span class="text-cyber-white font-mono">{{ $category->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4 pt-4 border-t border-cyber-border">
                <button type="submit" class="px-8 py-3 bg-cyber-white text-cyber-black hover:bg-gray-800 transition font-bold uppercase tracking-wider text-sm">
                    Update Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="px-8 py-3 bg-transparent border border-cyber-white text-cyber-white hover:bg-cyber-white hover:text-cyber-black transition font-bold uppercase tracking-wider text-sm">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
