{{-- Main Header --}}
<header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
    {{-- Top Header --}}
    <div class="bg-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4 gap-4">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('images/logo/uitech-logo.png') }}" alt="UITech Store" class="h-16">
                    <div class="flex flex-col">
                        <span class="text-2xl font-black tracking-tight text-gray-900">UITech Store</span>
                        <span class="text-xs text-gray-500">PC Parts & Gaming Solutions</span>
                    </div>
                </a>

                {{-- Search Bar --}}
                <div class="flex-1 max-w-2xl">
                    <form action="{{ route('products.index') }}" method="GET" class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Tìm kiếm sản phẩm..." 
                               class="w-full px-4 py-2.5 pl-10 pr-4 border-2 border-gray-900 rounded-lg focus:outline-none focus:border-black">
                        <svg class="absolute left-3 top-3 w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-6">
                    {{-- Cart Icon --}}
                    <a href="{{ route('cart.index') }}" class="relative hover:opacity-70 transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        @auth
                            @php
                                $itemCount = auth()->user()->cartItems()->sum('quantity');
                            @endphp
                            @if($itemCount > 0)
                                <span class="absolute -top-2 -right-2 bg-black text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ $itemCount }}
                                </span>
                            @endif
                        @endauth
                    </a>
                    
                    {{-- Auth Links --}}
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 hover:opacity-70">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-medium hidden lg:inline">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-10">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Tài khoản</a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 hover:bg-gray-100">Đơn hàng</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                        Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3">
                            <a href="{{ route('login') }}" class="font-medium hover:opacity-70">Đăng nhập</a>
                            <span class="text-gray-300">|</span>
                            <a href="{{ route('register') }}" class="font-medium hover:opacity-70">Đăng ký</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- Navigation Bar --}}
    <nav class="bg-black text-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center" x-data="{ openMenu: null, subMenu: null }">
                {{-- Category Mega Menu --}}
                <div class="relative" @mouseenter="openMenu = 'categories'" @mouseleave="openMenu = null; subMenu = null">
                    <button class="flex items-center gap-2 px-6 py-3 font-bold text-sm hover:bg-gray-900 transition uppercase">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <span>Danh mục sản phẩm</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    {{-- Mega Menu Dropdown --}}
                    <div x-show="openMenu === 'categories'" 
                         x-transition
                         class="absolute left-0 top-full w-[900px] bg-white text-gray-900 shadow-2xl border-t-2 border-black z-50">
                        <div class="grid grid-cols-12">
                            {{-- Left: Category List --}}
                            <div class="col-span-3 bg-gray-50 border-r border-gray-200">
                                <div class="py-2">
                                    {{-- CPU --}}
                                    <a href="{{ route('products.index', ['category' => 'cpu-processor']) }}" 
                                       @mouseenter="subMenu = 'cpu'"
                                       class="flex items-center justify-between px-4 py-3 hover:bg-white hover:text-black transition cursor-pointer"
                                       :class="subMenu === 'cpu' ? 'bg-white text-black font-semibold' : ''">
                                        <span>CPU - Bộ vi xử lý</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>

                                    {{-- VGA --}}
                                    <a href="{{ route('products.index', ['category' => 'vga-card-man-hinh']) }}"
                                       @mouseenter="subMenu = 'vga'"
                                       class="flex items-center justify-between px-4 py-3 hover:bg-white hover:text-black transition cursor-pointer"
                                       :class="subMenu === 'vga' ? 'bg-white text-black font-semibold' : ''">
                                        <span>VGA - Card màn hình</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>

                                    {{-- RAM --}}
                                    <a href="{{ route('products.index', ['category' => 'ram-bo-nho']) }}"
                                       @mouseenter="subMenu = 'ram'"
                                       class="flex items-center justify-between px-4 py-3 hover:bg-white hover:text-black transition cursor-pointer"
                                       :class="subMenu === 'ram' ? 'bg-white text-black font-semibold' : ''">
                                        <span>RAM - Bộ nhớ</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>

                                    {{-- Mainboard --}}
                                    <a href="{{ route('products.index', ['category' => 'mainboard-mainboard']) }}"
                                       @mouseenter="subMenu = 'mainboard'"
                                       class="flex items-center justify-between px-4 py-3 hover:bg-white hover:text-black transition cursor-pointer"
                                       :class="subMenu === 'mainboard' ? 'bg-white text-black font-semibold' : ''">
                                        <span>Mainboard</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>

                                    {{-- SSD --}}
                                    <a href="{{ route('products.index', ['category' => 'ssd-o-cung']) }}"
                                       @mouseenter="subMenu = 'ssd'"
                                       class="flex items-center justify-between px-4 py-3 hover:bg-white hover:text-black transition cursor-pointer"
                                       :class="subMenu === 'ssd' ? 'bg-white text-black font-semibold' : ''">
                                        <span>SSD - Ổ cứng</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>

                                    {{-- Monitor --}}
                                    <a href="{{ route('products.index', ['category' => 'monitor-man-hinh']) }}"
                                       @mouseenter="subMenu = 'monitor'"
                                       class="flex items-center justify-between px-4 py-3 hover:bg-white hover:text-black transition cursor-pointer"
                                       :class="subMenu === 'monitor' ? 'bg-white text-black font-semibold' : ''">
                                        <span>Màn hình</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>

                                    {{-- PSU --}}
                                    <a href="{{ route('products.index', ['category' => 'psu-nguon']) }}"
                                       @mouseenter="subMenu = 'psu'"
                                       class="flex items-center justify-between px-4 py-3 hover:bg-white hover:text-black transition cursor-pointer"
                                       :class="subMenu === 'psu' ? 'bg-white text-black font-semibold' : ''">
                                        <span>PSU - Nguồn</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>

                                    {{-- Case --}}
                                    <a href="{{ route('products.index', ['category' => 'case-vo-may']) }}"
                                       @mouseenter="subMenu = 'case'"
                                       class="flex items-center justify-between px-4 py-3 hover:bg-white hover:text-black transition cursor-pointer"
                                       :class="subMenu === 'case' ? 'bg-white text-black font-semibold' : ''">
                                        <span>Case - Vỏ máy</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>

                                    {{-- Cooling --}}
                                    <a href="{{ route('products.index', ['category' => 'fan-cooler-quat-tan-nhiet']) }}"
                                       @mouseenter="subMenu = 'cooling'"
                                       class="flex items-center justify-between px-4 py-3 hover:bg-white hover:text-black transition cursor-pointer"
                                       :class="subMenu === 'cooling' ? 'bg-white text-black font-semibold' : ''">
                                        <span>Tản nhiệt</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            {{-- Right: Filter Panel --}}
                            <div class="col-span-9 p-6">
                                {{-- CPU Filters --}}
                                <div x-show="subMenu === 'cpu'" x-transition class="grid grid-cols-3 gap-6">
                                    <div>
                                        <h4 class="font-bold text-sm mb-3 pb-2 border-b border-gray-200">HÃNG SẢN XUẤT</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'cpu-processor', 'brand' => ['Intel']]) }}" class="hover:text-black hover:underline">Intel</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu-processor', 'brand' => ['AMD']]) }}" class="hover:text-black hover:underline">AMD</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm mb-3 pb-2 border-b border-gray-200">SOCKET</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'cpu-processor', 'socket' => ['LGA1700']]) }}" class="hover:text-black hover:underline">LGA 1700 (Intel Gen 12-14)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu-processor', 'socket' => ['AM5']]) }}" class="hover:text-black hover:underline">AM5 (Ryzen 7000)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu-processor', 'socket' => ['AM4']]) }}" class="hover:text-black hover:underline">AM4 (Ryzen 5000)</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm mb-3 pb-2 border-b border-gray-200">DÒNG CORE</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'cpu-processor']) }}" class="hover:text-black hover:underline">Intel Core i9</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu-processor']) }}" class="hover:text-black hover:underline">Intel Core i7</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu-processor']) }}" class="hover:text-black hover:underline">Intel Core i5</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu-processor']) }}" class="hover:text-black hover:underline">Intel Core i3</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu-processor']) }}" class="hover:text-black hover:underline">AMD Ryzen 9</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu-processor']) }}" class="hover:text-black hover:underline">AMD Ryzen 7</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu-processor']) }}" class="hover:text-black hover:underline">AMD Ryzen 5</a></li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- VGA Filters --}}
                                <div x-show="subMenu === 'vga'" x-transition class="grid grid-cols-3 gap-6">
                                    <div>
                                        <h4 class="font-bold text-sm mb-3 pb-2 border-b border-gray-200">HÃNG SẢN XUẤT</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'vga-card-man-hinh', 'brand' => ['ASUS']]) }}" class="hover:text-black hover:underline">ASUS</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-card-man-hinh', 'brand' => ['MSI']]) }}" class="hover:text-black hover:underline">MSI</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-card-man-hinh', 'brand' => ['Gigabyte']]) }}" class="hover:text-black hover:underline">Gigabyte</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-card-man-hinh', 'brand' => ['ASUS']]) }}" class="hover:text-black hover:underline">ASUS</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm mb-3 pb-2 border-b border-gray-200">SERIES GPU</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'vga-card-man-hinh', 'series' => ['RTX 5090']]) }}" class="hover:text-black hover:underline">NVIDIA RTX 5090</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-card-man-hinh', 'series' => ['RTX 5080']]) }}" class="hover:text-black hover:underline">NVIDIA RTX 5080</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-card-man-hinh', 'series' => ['RTX 5070']]) }}" class="hover:text-black hover:underline">NVIDIA RTX 5070</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-card-man-hinh', 'series' => ['RTX 5060']]) }}" class="hover:text-black hover:underline">NVIDIA RTX 5060</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-card-man-hinh']) }}" class="hover:text-black hover:underline">AMD Radeon RX 7000</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm mb-3 pb-2 border-b border-gray-200">VRAM</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'vga-card-man-hinh', 'vram' => ['24GB']]) }}" class="hover:text-black hover:underline">24GB</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-card-man-hinh', 'vram' => ['16GB']]) }}" class="hover:text-black hover:underline">16GB</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-card-man-hinh', 'vram' => ['12GB']]) }}" class="hover:text-black hover:underline">12GB</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-card-man-hinh', 'vram' => ['8GB']]) }}" class="hover:text-black hover:underline">8GB</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-card-man-hinh', 'vram' => ['6GB']]) }}" class="hover:text-black hover:underline">6GB</a></li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- RAM Filters --}}
                                <div x-show="subMenu === 'ram'" x-transition class="grid grid-cols-3 gap-6">
                                    <div>
                                        <h4 class="font-bold text-sm mb-3 pb-2 border-b border-gray-200">KIỂU BỘ NHỚ</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'ram-bo-nho', 'type' => ['DDR5']]) }}" class="hover:text-black hover:underline">DDR5</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram-bo-nho', 'type' => ['DDR4']]) }}" class="hover:text-black hover:underline">DDR4</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm mb-3 pb-2 border-b border-gray-200">DUNG LƯỢNG</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'ram-bo-nho', 'capacity' => ['64GB']]) }}" class="hover:text-black hover:underline">64GB (32GB x2)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram-bo-nho', 'capacity' => ['32GB']]) }}" class="hover:text-black hover:underline">32GB (16GB x2)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram-bo-nho', 'capacity' => ['16GB']]) }}" class="hover:text-black hover:underline">16GB (8GB x2)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram-bo-nho', 'capacity' => ['8GB']]) }}" class="hover:text-black hover:underline">8GB</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm mb-3 pb-2 border-b border-gray-200">HÃNG</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'ram-bo-nho']) }}" class="hover:text-black hover:underline">Corsair</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram-bo-nho']) }}" class="hover:text-black hover:underline">G.Skill</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram-bo-nho']) }}" class="hover:text-black hover:underline">Kingston</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram-bo-nho']) }}" class="hover:text-black hover:underline">TeamGroup</a></li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Monitor Filters --}}
                                <div x-show="subMenu === 'monitor'" x-transition class="grid grid-cols-3 gap-6">
                                    <div>
                                        <h4 class="font-bold text-sm mb-3 pb-2 border-b border-gray-200">KÍCH THƯỚC</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'monitor-man-hinh', 'size' => ['24\"']]) }}" class="hover:text-black hover:underline">24 inch</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor-man-hinh', 'size' => ['27\"']]) }}" class="hover:text-black hover:underline">27 inch</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor-man-hinh', 'size' => ['32\"']]) }}" class="hover:text-black hover:underline">32 inch</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm mb-3 pb-2 border-b border-gray-200">ĐỘ PHÂN GIẢI</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'monitor-man-hinh', 'resolution' => ['Full HD']]) }}" class="hover:text-black hover:underline">Full HD (1920x1080)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor-man-hinh', 'resolution' => ['2K']]) }}" class="hover:text-black hover:underline">2K (2560x1440)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor-man-hinh', 'resolution' => ['4K']]) }}" class="hover:text-black hover:underline">4K (3840x2160)</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm mb-3 pb-2 border-b border-gray-200">TẦN SỐ QUÉT</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'monitor-man-hinh', 'refresh' => ['60Hz']]) }}" class="hover:text-black hover:underline">60Hz</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor-man-hinh', 'refresh' => ['144Hz']]) }}" class="hover:text-black hover:underline">144Hz</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor-man-hinh', 'refresh' => ['165Hz']]) }}" class="hover:text-black hover:underline">165Hz</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor-man-hinh', 'refresh' => ['240Hz']]) }}" class="hover:text-black hover:underline">240Hz</a></li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Default message when no submenu --}}
                                <div x-show="!subMenu" class="text-center py-12 text-gray-400">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                    </svg>
                                    <p>Di chuột vào danh mục để xem bộ lọc chi tiết</p>
                                </div>

                                {{-- Other categories (SSD, Mainboard, PSU, Case, Cooling) --}}
                                <div x-show="subMenu === 'ssd' || subMenu === 'mainboard' || subMenu === 'psu' || subMenu === 'case' || subMenu === 'cooling'" x-transition class="text-center py-12">
                                    <p class="text-gray-600 mb-4">Đang phát triển bộ lọc cho danh mục này</p>
                                    <a :href="subMenu === 'ssd' ? '{{ route('products.index', ['category' => 'ssd-o-cung']) }}' :
                                              subMenu === 'mainboard' ? '{{ route('products.index', ['category' => 'mainboard-mainboard']) }}' :
                                              subMenu === 'psu' ? '{{ route('products.index', ['category' => 'psu-nguon']) }}' :
                                              subMenu === 'case' ? '{{ route('products.index', ['category' => 'case-vo-may']) }}' :
                                              '{{ route('products.index', ['category' => 'fan-cooler-quat-tan-nhiet']) }}'"
                                       class="inline-block bg-black text-white px-6 py-2 rounded hover:bg-gray-800">
                                        Xem tất cả sản phẩm
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="flex items-center gap-1 ml-4">
                    <a href="{{ route('products.index') }}" class="px-4 py-3 hover:bg-gray-900 transition font-medium text-sm uppercase">
                        Tất cả sản phẩm
                    </a>
                    
                    {{-- PC Build Dropdown --}}
                    <div class="relative" @mouseenter="openMenu = 'pcbuild'" @mouseleave="openMenu = null">
                        <button class="flex items-center gap-2 px-4 py-3 hover:bg-gray-900 transition font-medium text-sm uppercase">
                            PC Build
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        {{-- PC Build Dropdown Menu --}}
                        <div x-show="openMenu === 'pcbuild'" 
                             x-transition
                             class="absolute left-0 top-full w-64 bg-white text-gray-900 shadow-xl border-t-2 border-black z-50 mt-0">
                            <div class="py-2">
                                <a href="{{ route('pc-gaming.index') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 transition">
                                    <div>
                                        <div class="font-semibold">PC Gaming</div>
                                        <div class="text-xs text-gray-500">Gaming cao cấp</div>
                                    </div>
                                </a>
                                <a href="{{ route('pc-ai.index') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 transition">
                                    <div>
                                        <div class="font-semibold">PC AI Workstation</div>
                                        <div class="text-xs text-gray-500">Machine Learning</div>
                                    </div>
                                </a>
                                <a href="{{ route('pc-design.index') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 transition">
                                    <div>
                                        <div class="font-semibold">PC Design</div>
                                        <div class="text-xs text-gray-500">Đồ họa & Video</div>
                                    </div>
                                </a>
                                <a href="{{ route('pc-office.index') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 transition">
                                    <div>
                                        <div class="font-semibold">PC Office</div>
                                        <div class="text-xs text-gray-500">Văn phòng hiệu quả</div>
                                    </div>
                                </a>
                                <div class="border-t my-2"></div>
                                <a href="{{ route('build-pc') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 transition">
                                    <div>
                                        <div class="font-semibold">Tự Build PC</div>
                                        <div class="text-xs text-gray-500">Tùy chỉnh linh kiện</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

