@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Quản Lý Thông Số Kỹ Thuật</h1>
            <p class="text-gray-600 mt-2">Cấu hình template thông số cho từng loại linh kiện</p>
        </div>
        <a href="{{ route('admin.spec-definitions.create', ['component_type_id' => request('component_type_id')]) }}" 
           class="mt-4 sm:mt-0 inline-flex items-center px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Thêm Thông Số
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
        <p class="text-green-700">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Filter by Component Type -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
        <form action="{{ route('admin.spec-definitions.index') }}" method="GET">
            <div class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Lọc theo loại linh kiện</label>
                    <select name="component_type_id" 
                            class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-2 focus:border-black focus:outline-none transition"
                            onchange="this.form.submit()">
                        <option value="">-- Tất cả loại linh kiện --</option>
                        @foreach($componentTypes as $type)
                        <option value="{{ $type->id }}" {{ request('component_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <a href="{{ route('admin.spec-definitions.index') }}" 
                   class="px-6 py-2 bg-gray-100 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-800 transition font-medium">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Loại linh kiện</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tên thông số</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Đơn vị</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Kiểu input</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Thứ tự</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Bắt buộc</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($specDefinitions as $spec)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $spec->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($spec->componentType)
                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium border border-gray-200">
                            {{ $spec->componentType->name }}
                        </span>
                        @else
                        <span class="text-gray-400">--</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $spec->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">{{ $spec->code }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $spec->unit ?: '--' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        <span class="px-2 py-1 bg-black text-white rounded text-xs font-medium">{{ $spec->input_type }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $spec->sort_order }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($spec->is_required)
                        <span class="text-red-600 font-semibold">✓</span>
                        @else
                        <span class="text-gray-400">--</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.spec-definitions.edit', $spec) }}" 
                               class="px-3 py-1 bg-black text-white rounded hover:bg-gray-800 transition text-xs font-medium">
                                Edit
                            </a>
                            <form action="{{ route('admin.spec-definitions.destroy', $spec) }}" method="POST" 
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa thông số này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-xs font-medium">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                        <div class="text-4xl mb-4">📋</div>
                        <p class="text-lg font-medium">Chưa có thông số nào</p>
                        <p class="text-sm mt-1">Hãy tạo thông số đầu tiên cho loại linh kiện</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($specDefinitions->hasPages())
    <div class="mt-6">
        {{ $specDefinitions->links() }}
    </div>
    @endif
</div>
@endsection
