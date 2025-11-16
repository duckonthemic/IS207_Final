<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — UITech</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100">
<div class="grid grid-cols-12 gap-0 min-h-screen">
    <aside class="col-span-3 md:col-span-2 bg-white border-r">
        <div class="p-4 font-bold text-lg">Admin</div>
        <nav class="px-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Sản phẩm</a>
            {{-- Thêm: Orders, Users, Stats --}}
            <a href="{{ route('admin.orders.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Đơn hàng</a>
            <a href=" " class="block px-3 py-2 rounded hover:bg-gray-100">Người dùng</a>
            <a href=" " class="block px-3 py-2 rounded hover:bg-gray-100">Thống kê</a>
            <a href="/logout" class="block px-3 py-2 rounded hover:bg-gray-100">Đăng xuất</a>
        </nav>
    </aside>

    <section class="col-span-9 md:col-span-10 p-6">
        @yield('content')
    </section>
</div>
</body>
</html>
