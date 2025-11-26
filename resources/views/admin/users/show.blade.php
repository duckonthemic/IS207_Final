@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="text-gray-600">{{ $user->email }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition font-medium">Sửa</a>
                @if(!$user->email_verified_at)
                <form action="{{ route('admin.users.verify', $user) }}" method="POST" onsubmit="return confirm('Đánh dấu email là đã xác minh cho người dùng này?');">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-50 text-green-600 rounded hover:bg-green-100 transition font-medium">Đánh dấu là đã xác minh</button>
                </form>
                @endif
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Xóa người dùng này?');">
                    @csrf
                    @method('DELETE')
                    <button class="inline-flex items-center px-4 py-2 bg-red-50 text-red-600 rounded hover:bg-red-100 transition font-medium">Xóa</button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-xs text-gray-600">Vai trò</p>
                <p class="font-semibold text-gray-900">{{ $user->role }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-xs text-gray-600">Ngày tạo</p>
                <p class="font-semibold text-gray-900">{{ $user->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-xs text-gray-600">Xác minh email</p>
                <p class="font-semibold text-gray-900">
                    @if($user->email_verified_at)
                        {{ $user->email_verified_at->format('Y-m-d H:i') }}
                    @else
                        <span class="text-red-600">Chưa xác minh</span>
                    @endif
                </p>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-xs text-gray-600">Email</p>
                <p class="font-semibold text-gray-900">{{ $user->email }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
