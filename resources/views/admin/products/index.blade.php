@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Quản Lý Sản Phẩm</h1>
            <p class="text-gray-600 mt-2">Quản lý và chỉnh sửa danh sách sản phẩm</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Thêm Sản Phẩm
        </a>
    </div>

    {{-- Search and Filter --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
        <form action="{{ route('admin.products.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Search --}}
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Tìm Kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo tên hoặc SKU..." class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:border-blue-500 focus:outline-none transition">
                </div>

                {{-- Category Filter --}}
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Danh Mục</label>
                    <select name="category" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:border-blue-500 focus:outline-none transition">
                        <option value="">Tất Cả Danh Mục</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status Filter --}}
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Trạng Thái</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:border-blue-500 focus:outline-none transition">
                        <option value="">Tất Cả Trạng Thái</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tắt</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    Tìm Kiếm
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-200 transition font-medium">
                    Xóa Bộ Lọc
                </a>
            </div>
        </form>
    </div>

    {{-- Products Table --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
        @if ($products->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tên Sản Phẩm</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">SKU</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Danh Mục</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-900">Giá</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Kho</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Trạng Thái</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-900">Hành Động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if ($product->image)
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-10 h-10 rounded object-cover bg-gray-100">
                                @else
                                    <div class="w-10 h-10 rounded bg-gray-100 flex items-center justify-center text-gray-400 text-xs">📦</div>
                                @endif
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ Str::limit($product->description, 40) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded text-sm font-mono">{{ $product->sku }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 text-right text-sm font-semibold text-gray-900">{{ number_format($product->price, 0, ',', '.') }}₫</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-block {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} px-3 py-1 rounded text-sm font-medium">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-block {{ $product->is_active ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700' }} px-3 py-1 rounded text-sm font-medium">
                                {{ $product->is_active ? 'Active' : 'Tắt' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex gap-2 justify-end">
                                <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-3 py-2 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-sm font-medium" title="Chỉnh sửa">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <span class="ml-1">Sửa</span>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-50 text-red-600 rounded hover:bg-red-100 transition text-sm font-medium" title="Xóa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        <span class="ml-1">Xóa</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $products->links() }}
        </div>
        @else
        <div class="px-6 py-12 text-center">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
            </svg>
            <p class="text-gray-500">Không tìm thấy sản phẩm nào</p>
        </div>
        @endif
    </div>
</div>
@endsection
