@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto px-4">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Chỉnh sửa người dùng</h1>
            <p class="text-gray-600 mt-1">Sửa thông tin và vai trò người dùng</p>
        </div>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Họ và tên</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Vai trò</label>
            <select name="role" class="mt-1 block w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="{{ \App\Models\User::ROLE_USER }}" {{ $user->role==\App\Models\User::ROLE_USER ? 'selected' : '' }}>User</option>
                <option value="{{ \App\Models\User::ROLE_ADMIN }}" {{ $user->role==\App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>Admin</option>
                <option value="{{ \App\Models\User::ROLE_MODERATOR }}" {{ $user->role==\App\Models\User::ROLE_MODERATOR ? 'selected' : '' }}>Moderator</option>
            </select>
            @error('role')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 mr-2 border border-gray-300 rounded hover:bg-gray-50">Hủy</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Lưu</button>
        </div>
    </form>
</div>
@endsection
