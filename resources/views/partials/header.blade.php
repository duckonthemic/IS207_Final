{{-- Main Header --}}
<header class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm font-sans">
    {{-- Top Header --}}
    <div class="bg-white text-gray-900">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4 gap-8">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 group">
                    <div class="relative">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg blur opacity-25 group-hover:opacity-50 transition duration-200"></div>
                        <img src="{{ asset('images/logo/uitech-logo.png') }}" alt="UITech Store" class="relative h-12 w-auto object-contain">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-bold tracking-tight text-gray-900">UITech Store</span>
                        <span class="text-xs text-gray-500 font-medium">Premium PC & Gear</span>
                    </div>
                </a>

                {{-- Search Bar --}}
                <div class="flex-1 max-w-2xl">
                    <form action="{{ route('products.index') }}" method="GET" class="relative group">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Tìm kiếm sản phẩm..." 
                               class="w-full px-5 py-3 pl-12 bg-gray-50 border border-gray-200 text-gray-900 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder-gray-400 text-sm">
                        <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-6 text-gray-600">
                    {{-- Cart Icon --}}
                    <a href="{{ route('cart.index') }}" class="relative hover:text-blue-600 transition-colors p-2 rounded-full hover:bg-gray-50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        @auth
                            @php
                                $itemCount = auth()->user()->cartItems()->sum('qty');
                            @endphp
                            @if($itemCount > 0)
                                <span class="absolute top-0 right-0 bg-blue-600 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center ring-2 ring-white">
                                    {{ $itemCount }}
                                </span>
                            @endif
                        @endauth
                    </a>
                    
                    {{-- Auth Links --}}
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 hover:text-blue-600 transition-colors p-1 pr-3 rounded-full hover:bg-gray-50 border border-transparent hover:border-gray-200">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-sm hidden lg:inline">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-56 bg-white border border-gray-100 rounded-xl shadow-lg py-2 z-50">
                                <div class="px-4 py-2 border-b border-gray-100 mb-2">
                                    <p class="text-sm font-medium text-gray-900">Tài khoản của tôi</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600">Cài đặt tài khoản</a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600">Đơn hàng của tôi</a>
                                <div class="border-t border-gray-100 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-4 text-sm font-medium">
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 transition-colors">Đăng nhập</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-black text-white rounded-full hover:bg-gray-800 transition-colors shadow-sm hover:shadow">Đăng ký</a>
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
                    <button class="flex items-center gap-2 px-0 py-4 mr-8 font-semibold text-sm text-white hover:text-blue-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <span>Danh mục sản phẩm</span>
                    </button>
                    
                    {{-- Mega Menu Dropdown --}}
                    <div x-show="openMenu === 'categories'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute left-0 top-full w-[900px] bg-white text-gray-900 rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden mt-1">
                        <div class="grid grid-cols-12 h-[500px]">
                            {{-- Left: Category List --}}
                            <div class="col-span-3 bg-gray-50 border-r border-gray-100 py-2">
                                {{-- CPU --}}
                                <a href="{{ route('products.index', ['category' => 'cpu']) }}" 
                                   @mouseenter="subMenu = 'cpu'"
                                   class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                   :class="subMenu === 'cpu' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>CPU - Vi xử lý</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- VGA --}}
                                <a href="{{ route('products.index', ['category' => 'vga']) }}"
                                   @mouseenter="subMenu = 'vga'"
                                   class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                   :class="subMenu === 'vga' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>VGA - Card màn hình</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- RAM --}}
                                <a href="{{ route('products.index', ['category' => 'ram']) }}"
                                   @mouseenter="subMenu = 'ram'"
                                   class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                   :class="subMenu === 'ram' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>RAM - Bộ nhớ trong</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- Mainboard --}}
                                <a href="{{ route('products.index', ['category' => 'mainboard']) }}"
                                   @mouseenter="subMenu = 'mainboard'"
                                   class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                   :class="subMenu === 'mainboard' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>Mainboard</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- SSD --}}
                                <a href="{{ route('products.index', ['category' => 'ssd']) }}"
                                   @mouseenter="subMenu = 'ssd'"
                                   class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                   :class="subMenu === 'ssd' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>SSD - Lưu trữ</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- Monitor --}}
                                <a href="{{ route('products.index', ['category' => 'monitor']) }}"
                                   @mouseenter="subMenu = 'monitor'"
                                   class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                   :class="subMenu === 'monitor' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>Màn hình</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- PSU --}}
                                <a href="{{ route('products.index', ['category' => 'psu']) }}"
                                   @mouseenter="subMenu = 'psu'"
                                   class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                   :class="subMenu === 'psu' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>Nguồn máy tính</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- Case --}}
                                <a href="{{ route('products.index', ['category' => 'case']) }}"
                                   @mouseenter="subMenu = 'case'"
                                   class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                   :class="subMenu === 'case' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>Vỏ máy tính</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- Cooling --}}
                                <a href="{{ route('products.index', ['category' => 'fan-cooler-quat-tan-nhiet']) }}"
                                   @mouseenter="subMenu = 'cooling'"
                                   class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                   :class="subMenu === 'cooling' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>Tản nhiệt</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>

                            {{-- Right: Filter Panel --}}
                            <div class="col-span-9 p-8 bg-white">
                                {{-- CPU Filters --}}
                                <div x-show="subMenu === 'cpu'" x-transition class="grid grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Hãng sản xuất</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'cpu', 'brand' => ['Intel']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Intel</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu', 'brand' => ['AMD']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">AMD</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Socket</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'cpu', 'socket' => ['LGA1700']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">LGA 1700 (Intel Gen 12-14)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu', 'socket' => ['AM5']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">AM5 (Ryzen 7000)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu', 'socket' => ['AM4']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">AM4 (Ryzen 5000)</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Dòng Core</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'cpu']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Intel Core i9</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Intel Core i7</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Intel Core i5</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">AMD Ryzen 9</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">AMD Ryzen 7</a></li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- VGA Filters --}}
                                <div x-show="subMenu === 'vga'" x-transition class="grid grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Hãng sản xuất</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'vga-asus']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">ASUS</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-msi']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">MSI</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-gigabyte']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">GIGABYTE</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-asrock']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">ASROCK</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">NVIDIA Series</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'vga', 'chip' => 'RTX 50']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">RTX 50 Series</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga', 'chip' => 'RTX 40']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">RTX 40 Series</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga', 'chip' => 'RTX 30']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">RTX 30 Series</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">AMD Series</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'vga', 'chip' => 'RX 7900']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">RX 7900 Series</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga', 'chip' => 'RX 7800']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">RX 7800 Series</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga', 'chip' => 'RX 7700']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">RX 7700 Series</a></li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- RAM Filters --}}
                                <div x-show="subMenu === 'ram'" x-transition class="grid grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Loại RAM</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'ram', 'type' => ['DDR5']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">DDR5</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram', 'type' => ['DDR4']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">DDR4</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Dung lượng</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'ram', 'capacity' => ['64GB']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">64GB (32GB x2)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram', 'capacity' => ['32GB']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">32GB (16GB x2)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram', 'capacity' => ['16GB']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">16GB (8GB x2)</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Thương hiệu</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'ram']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Corsair</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">G.Skill</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram']) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Kingston</a></li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Monitor Filters --}}
                                <div x-show="subMenu === 'monitor'" x-transition class="grid grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Kích thước</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'size' => ['24\"']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">24 inch</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'size' => ['27\"']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">27 inch</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'size' => ['32\"']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">32 inch</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Độ phân giải</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'resolution' => ['Full HD']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Full HD</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'resolution' => ['2K']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">2K QHD</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'resolution' => ['4K']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">4K UHD</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Tần số quét</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'refresh' => ['144Hz']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">144Hz</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'refresh' => ['165Hz']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">165Hz</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'refresh' => ['240Hz']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">240Hz+</a></li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Mainboard Filters --}}
                                <div x-show="subMenu === 'mainboard'" x-transition class="grid grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Hãng sản xuất</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'brand' => ['ASUS']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">ASUS</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'brand' => ['MSI']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">MSI</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'brand' => ['Gigabyte']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">GIGABYTE</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Socket</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'mb_cpu_socket' => ['LGA1700']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">LGA 1700 (Intel)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'mb_cpu_socket' => ['AM5']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">AM5 (AMD)</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Chipset</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'mb_chipset' => ['Z790']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Z790</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'mb_chipset' => ['B760']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">B760</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'mb_chipset' => ['X670E']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">X670E</a></li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- SSD Filters --}}
                                <div x-show="subMenu === 'ssd'" x-transition class="grid grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Hãng sản xuất</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'brand' => ['Samsung']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Samsung</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'brand' => ['Kingston']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Kingston</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'brand' => ['WD']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">WD</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Dung lượng</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'ssd_capacity_gb' => ['2000']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">2TB</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'ssd_capacity_gb' => ['1000']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">1TB</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'ssd_capacity_gb' => ['500']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">500GB</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Giao tiếp</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'ssd_interface' => ['PCIe 5.0']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">NVMe PCIe 5.0</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'ssd_interface' => ['PCIe 4.0']]) }}" class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">NVMe PCIe 4.0</a></li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Default message when no submenu --}}
                                <div x-show="!subMenu" class="flex flex-col items-center justify-center h-full text-gray-400">
                                    <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                    </svg>
                                    <p class="text-sm font-medium">Di chuột vào danh mục để xem chi tiết</p>
                                </div>

                                {{-- Other categories (PSU, Case, Cooling) --}}
                                <div x-show="subMenu === 'psu' || subMenu === 'case' || subMenu === 'cooling'" x-transition class="flex flex-col items-center justify-center h-full">
                                    <p class="text-gray-500 mb-6">Khám phá các sản phẩm chất lượng cao</p>
                                    <a :href="subMenu === 'psu' ? '{{ route('products.index', ['category' => 'psu']) }}' :
                                              subMenu === 'case' ? '{{ route('products.index', ['category' => 'case']) }}' :
                                              '{{ route('products.index') }}'"
                                       class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-sm font-medium rounded-full text-white bg-black hover:bg-gray-800 transition-colors shadow-lg hover:shadow-xl">
                                        Xem tất cả sản phẩm
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="flex items-center gap-8">
                    <a href="{{ route('products.index') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
                        Tất cả sản phẩm
                    </a>
                    
                    {{-- PC Build Dropdown --}}
                    <div class="relative group" @mouseenter="openMenu = 'pcbuild'" @mouseleave="openMenu = null">
                        <button class="flex items-center gap-1 text-sm font-medium text-gray-300 hover:text-white transition-colors">
                            PC Build
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        {{-- PC Build Dropdown Menu --}}
                        <div x-show="openMenu === 'pcbuild'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-0 top-full w-64 bg-white rounded-xl shadow-xl border border-gray-100 z-50 mt-1 overflow-hidden">
                            <div class="py-2">
                                <a href="{{ route('pc-gaming.index') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-900">PC Gaming</div>
                                        <div class="text-xs text-gray-500">Hiệu năng cao cho game thủ</div>
                                    </div>
                                </a>
                                <a href="{{ route('pc-ai.index') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-900">PC AI Workstation</div>
                                        <div class="text-xs text-gray-500">Deep Learning & AI</div>
                                    </div>
                                </a>
                                <a href="{{ route('pc-design.index') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-900">PC Design</div>
                                        <div class="text-xs text-gray-500">Đồ họa & Render</div>
                                    </div>
                                </a>
                                <a href="{{ route('pc-office.index') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-900">PC Office</div>
                                        <div class="text-xs text-gray-500">Văn phòng & Học tập</div>
                                    </div>
                                </a>
                                <div class="border-t border-gray-100 my-2"></div>
                                <a href="{{ route('build-pc') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors group/build">
                                    <div class="flex-1">
                                        <div class="font-medium text-blue-600 group-hover/build:text-blue-700">Tự Build PC</div>
                                        <div class="text-xs text-gray-500">Tùy chỉnh cấu hình theo ý muốn</div>
                                    </div>
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

