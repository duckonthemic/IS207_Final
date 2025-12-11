<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — UITech</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-cyber-black font-sans text-cyber-text antialiased">
    <div class="grid grid-cols-12 gap-0 min-h-screen">
        <aside class="col-span-3 md:col-span-2 bg-cyber-black border-r border-cyber-border">
            <a href="{{ route('home') }}"
                class="block p-6 font-black text-xl text-cyber-white uppercase tracking-tighter border-b border-cyber-border mb-4 hover:bg-cyber-gray transition-colors">
                UITech<span class="text-cyber-text-muted">.Admin</span>
            </a>
            <nav class="px-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-3 rounded-none text-sm font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-cyber-white text-cyber-black' : 'text-cyber-text hover:bg-cyber-gray hover:text-cyber-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}"
                    class="block px-4 py-3 rounded-none text-sm font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-cyber-white text-cyber-black' : 'text-cyber-text hover:bg-cyber-gray hover:text-cyber-white' }}">
                    Sản phẩm
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="block px-4 py-3 rounded-none text-sm font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-cyber-white text-cyber-black' : 'text-cyber-text hover:bg-cyber-gray hover:text-cyber-white' }}">
                    Danh mục
                </a>
                <a href="{{ route('admin.orders.index') }}"
                    class="block px-4 py-3 rounded-none text-sm font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-cyber-white text-cyber-black' : 'text-cyber-text hover:bg-cyber-gray hover:text-cyber-white' }}">
                    Đơn hàng
                </a>
                <a href="{{ route('admin.reviews.index') }}"
                    class="block px-4 py-3 rounded-none text-sm font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('admin.reviews.*') ? 'bg-cyber-white text-cyber-black' : 'text-cyber-text hover:bg-cyber-gray hover:text-cyber-white' }}">
                    Đánh giá
                </a>
                <a href="{{ route('admin.promotions.index') }}"
                    class="block px-4 py-3 rounded-none text-sm font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('admin.promotions.*') ? 'bg-cyber-white text-cyber-black' : 'text-cyber-text hover:bg-cyber-gray hover:text-cyber-white' }}">
                    Mã giảm giá
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="block px-4 py-3 rounded-none text-sm font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-cyber-white text-cyber-black' : 'text-cyber-text hover:bg-cyber-gray hover:text-cyber-white' }}">
                    Người dùng
                </a>
                <a href="{{ route('admin.audit-logs.index') }}"
                    class="block px-4 py-3 rounded-none text-sm font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('admin.audit-logs.*') ? 'bg-cyber-white text-cyber-black' : 'text-cyber-text hover:bg-cyber-gray hover:text-cyber-white' }}">
                    Audit Logs
                </a>
                <a href="#"
                    class="block px-4 py-3 rounded-none text-sm font-bold uppercase tracking-wider transition-colors text-cyber-text hover:bg-cyber-gray hover:text-cyber-white">
                    Thống kê
                </a>

                <div class="pt-4 mt-4 border-t border-cyber-border">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-3 rounded-none text-sm font-bold uppercase tracking-wider transition-colors text-red-500 hover:bg-cyber-gray">
                            Đăng xuất
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <section class="col-span-9 md:col-span-10 bg-cyber-black">
            @yield('content')
        </section>
    </div>
</body>

</html>