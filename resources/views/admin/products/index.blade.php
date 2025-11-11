@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-cyber-accent">Manage Products</h1>
            <p class="text-cyber-muted mt-2">Manage and edit your product catalog</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-6 py-3 bg-cyber-accent text-cyber-dark rounded-lg hover:bg-cyan-400 transition font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Product
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg p-6 mb-6">
        <form action="{{ route('admin.products.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or SKU..." class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white placeholder-cyber-muted rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Category</label>
                    <select name="category" class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">
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
                    <label class="block text-cyber-accent text-sm font-medium mb-2">Status</label>
                    <select name="status" class="w-full bg-cyber-dark border border-cyber-accent border-opacity-30 text-white rounded-lg px-4 py-2 focus:border-cyber-accent focus:outline-none transition">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-cyber-accent text-cyber-dark rounded-lg hover:bg-cyan-400 transition font-medium">
                    Search
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-6 py-2 bg-cyber-darker border border-cyber-accent text-cyber-accent rounded-lg hover:border-cyan-400 transition font-medium">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-cyber-darker border border-cyber-accent border-opacity-20 rounded-lg overflow-hidden">
        @if ($products->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-cyber-dark text-cyber-accent text-sm uppercase tracking-wide border-b border-cyber-accent border-opacity-20">
                        <th class="px-6 py-4 text-left">Product Name</th>
                        <th class="px-6 py-4 text-left">SKU</th>
                        <th class="px-6 py-4 text-left">Category</th>
                        <th class="px-6 py-4 text-right">Price</th>
                        <th class="px-6 py-4 text-center">Stock</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-cyber-accent divide-opacity-10">
                    @foreach ($products as $product)
                    <tr class="hover:bg-cyber-dark hover:bg-opacity-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 bg-cyber-accent bg-opacity-10 rounded overflow-hidden flex-shrink-0">
                                    @if ($product->images->first())
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center text-cyber-muted text-xs">No Image</div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-white font-medium">{{ $product->name }}</p>
                                    <p class="text-cyber-muted text-sm">{{ Str::limit($product->description, 50) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block bg-cyber-accent bg-opacity-10 text-cyber-accent px-3 py-1 rounded text-sm font-mono">{{ $product->sku }}</span>
                        </td>
                        <td class="px-6 py-4 text-white">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 text-right text-white font-semibold">{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $totalStock = $product->inventory->sum('quantity');
                            @endphp
                            <span class="inline-block {{ $totalStock > 0 ? 'bg-green-900 text-green-200' : 'bg-red-900 text-cyber-error' }} px-3 py-1 rounded text-sm font-medium">
                                {{ $totalStock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-block {{ $product->is_active ? 'bg-cyber-success bg-opacity-20 text-cyber-success' : 'bg-cyber-error bg-opacity-20 text-cyber-error' }} px-3 py-1 rounded text-sm font-medium">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex gap-2 justify-end">
                                <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-3 py-1 bg-cyber-accent bg-opacity-20 text-cyber-accent rounded hover:bg-opacity-40 transition text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-cyber-error bg-opacity-20 text-cyber-error rounded hover:bg-opacity-40 transition text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <div class="px-6 py-4 border-t border-cyber-accent border-opacity-20">
            {{ $products->links() }}
        </div>
        @else
        <div class="px-6 py-12 text-center">
            <svg class="w-12 h-12 text-cyber-muted mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
            </svg>
            <p class="text-cyber-muted">No products found</p>
        </div>
        @endif
    </div>
</div>
@endsection
