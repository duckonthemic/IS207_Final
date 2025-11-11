@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Quản lý sản phẩm</h1>
    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 rounded-lg bg-black text-white">Thêm mới</a>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phân loại</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tồn kho</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($products as $p)
                <tr>
                    <td class="px-4 py-3">{{ $p->id }}</td>
                    <td class="px-4 py-3 font-medium">{{ $p->name }}</td>
                    <td class="px-4 py-3">{{ $p->category->name ?? '-' }}</td>
                    <td class="px-4 py-3">{{ number_format($p->price, 0, ',', '.') }} đ</td>
                    <td class="px-4 py-3">{{ $p->stock }}</td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('admin.products.edit', $p) }}" class="px-3 py-1 border rounded-lg">Sửa</a>
                        <form action="{{ route('admin.products.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xoá sản phẩm này?');">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-600 text-white rounded-lg">Xoá</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $products->links() }}</div>
@endsection
