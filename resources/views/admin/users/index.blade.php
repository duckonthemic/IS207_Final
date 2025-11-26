@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Quản lý Người Dùng</h1>
            <p class="text-gray-600 mt-2">Danh sách người dùng và quản lý vai trò</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <!-- no create button for users by default -->
        </div>
    </div>

    {{-- Search and Filter --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
        <form action="{{ route('admin.users.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tên hoặc email..." class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Vai trò</label>
                    <select name="role" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:border-blue-500 focus:outline-none">
                        <option value="">Tất cả vai trò</option>
                        <option value="{{ \App\Models\User::ROLE_USER }}" {{ request('role')==\App\Models\User::ROLE_USER ? 'selected' : '' }}>User</option>
                        <option value="{{ \App\Models\User::ROLE_ADMIN }}" {{ request('role')==\App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>Admin</option>
                        <option value="{{ \App\Models\User::ROLE_MODERATOR }}" {{ request('role')==\App\Models\User::ROLE_MODERATOR ? 'selected' : '' }}>Moderator</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <div class="w-full flex gap-2">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">Lọc</button>
                        <a href="{{ route('admin.users.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-200 transition font-medium">Xóa</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Users Table --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
        @if ($users->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tên</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Xác minh</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Vai trò</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Ngày tạo</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-900">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            @if($user->email_verified_at)
                                <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded text-sm">{{ $user->email_verified_at->format('Y-m-d') }}</span>
                            @else
                                <span class="inline-block bg-red-100 text-red-700 px-3 py-1 rounded text-sm">Chưa</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->role }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex gap-2 justify-end">
                                <a href="{{ route('admin.users.show', $user) }}" class="inline-flex items-center px-3 py-2 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-sm font-medium" title="Xem">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-3 py-2 bg-blue-50 text-green-600 rounded hover:bg-blue-100 transition text-sm font-medium" title="Sửa">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-50 text-red-600 rounded hover:bg-red-100 transition text-sm font-medium" title="Xóa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6"></path>
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

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        @else
        <div class="px-6 py-12 text-center">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
            </svg>
            <p class="text-gray-500">Không tìm thấy người dùng nào</p>
        </div>
        @endif
    </div>
    
</div>
@endsection
