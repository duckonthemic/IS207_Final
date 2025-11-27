@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-cyber-white uppercase tracking-tighter">Manage Products</h1>
            <p class="text-cyber-text-muted font-mono text-sm mt-1">// PRODUCT_CATALOG_SYSTEM</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-6 py-3 bg-cyber-white text-cyber-black hover:bg-gray-800 transition font-bold uppercase tracking-wider text-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Product
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="bg-cyber-black border border-cyber-border p-6 mb-6">
        <form action="{{ route('admin.products.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="SEARCH BY NAME OR SKU..." class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm">
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Category</label>
                    <select name="category" class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm uppercase">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Status</label>
                    <select name="status" class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-2 focus:border-cyber-white focus:outline-none transition font-mono text-sm uppercase">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-2 pt-2">
                <button type="submit" class="px-6 py-2 bg-cyber-white text-cyber-black rounded-none hover:bg-gray-800 transition font-bold uppercase tracking-wider text-sm">
                    Search
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-6 py-2 bg-transparent border border-cyber-white text-cyber-white rounded-none hover:bg-cyber-white hover:text-cyber-black transition font-bold uppercase tracking-wider text-sm">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-cyber-black border border-cyber-border overflow-hidden">
        @if ($products->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-cyber-gray text-cyber-text-muted text-xs uppercase tracking-wider border-b border-cyber-border">
                        <th class="px-6 py-4 text-left font-bold">Product Name</th>
                        <th class="px-6 py-4 text-left font-bold">SKU</th>
                        <th class="px-6 py-4 text-left font-bold">Category</th>
                        <th class="px-6 py-4 text-right font-bold">Price</th>
                        <th class="px-6 py-4 text-center font-bold">Stock</th>
                        <th class="px-6 py-4 text-center font-bold">Status</th>
                        <th class="px-6 py-4 text-right font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-cyber-border">
                    @foreach ($products as $product)
                    <tr class="hover:bg-cyber-gray transition group">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 bg-cyber-gray border border-cyber-border flex-shrink-0 p-1">
                                    @if ($product->images->first())
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center text-cyber-text-muted text-xs">IMG</div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-cyber-white font-bold uppercase text-sm line-clamp-1">{{ $product->name }}</p>
                                    <p class="text-cyber-text-muted text-xs font-mono line-clamp-1">{{ Str::limit($product->description, 50) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-cyber-white text-sm">{{ $product->sku }}</span>
                        </td>
                        <td class="px-6 py-4 text-cyber-text uppercase text-sm font-bold">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 text-right text-cyber-white font-mono font-bold">{{ number_format($product->price, 0, ',', '.') }}₫</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-block {{ $product->stock > 0 ? 'bg-green-900 text-green-200 border-green-700' : 'bg-red-900 text-red-200 border-red-700' }} border px-2 py-1 text-xs font-bold uppercase tracking-wider">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-block {{ $product->is_active ? 'bg-green-900 text-green-200 border-green-700' : 'bg-gray-800 text-gray-300 border-gray-600' }} border px-2 py-1 text-xs font-bold uppercase tracking-wider">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex gap-2 justify-end">
                                <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-3 py-1 border border-cyber-white text-cyber-white hover:bg-cyber-white hover:text-cyber-black transition text-xs font-bold uppercase tracking-wider">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition text-xs font-bold uppercase tracking-wider">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-cyber-border bg-cyber-gray">
            {{ $products->links() }}
        </div>
        @else
        <div class="px-6 py-12 text-center border-t border-cyber-border">
            <div class="text-4xl mb-4 opacity-50">📦</div>
            <p class="text-cyber-text-muted uppercase tracking-widest text-sm">No products found</p>
        </div>
        @endif
    </div>
</div>
@endsection
