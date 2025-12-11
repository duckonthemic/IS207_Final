{{-- Main Header --}}
<header class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm font-sans"
    x-data="{ mobileMenuOpen: false }">
    {{-- Top Header --}}
    <div class="bg-white text-gray-900">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4 gap-4 lg:gap-8">
                {{-- Mobile Menu Button --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 lg:gap-3 shrink-0 group">
                    <div class="relative">
                        <img src="{{ asset('images/logo/uitech-logo.png') }}" alt="UITech Store"
                            class="relative h-10 lg:h-16 w-auto object-contain">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg lg:text-xl font-bold tracking-tight text-gray-900">UITech Store</span>
                        <span class="text-xs text-gray-500 font-medium hidden sm:block">Premium PC & Gear</span>
                    </div>
                </a>

                {{-- Smart Search Bar (Desktop) --}}
                <div class="hidden lg:flex flex-1 max-w-2xl" x-data="smartSearch()" @click.away="showDropdown = false">
                    <div class="relative w-full">
                        <form action="{{ route('products.index') }}" method="GET" class="relative group w-full">
                            <input type="text" name="search" x-model="query" @input.debounce.300ms="search()"
                                @focus="if(query.length >= 2) showDropdown = true"
                                @keydown.escape="showDropdown = false"
                                @keydown.enter="if(selectedIndex >= 0) $event.preventDefault(); goToSelected()"
                                @keydown.arrow-down.prevent="navigateDown()" @keydown.arrow-up.prevent="navigateUp()"
                                value="{{ request('search') }}" placeholder="Tìm kiếm CPU, VGA, RAM, SSD..."
                                autocomplete="off"
                                class="w-full px-5 py-3 pl-12 pr-24 bg-white border-2 border-gray-900 text-gray-900 rounded-full focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-all placeholder-gray-400 text-sm">
                            <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-500 group-focus-within:text-gray-900 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <button type="submit"
                                class="absolute right-2 top-1.5 px-4 py-1.5 bg-gray-900 text-white text-sm font-medium rounded-full hover:bg-blue-600 transition-colors">
                                Tìm kiếm
                            </button>
                        </form>

                        {{-- Smart Search Dropdown --}}
                        <div x-show="showDropdown && (results.products.length > 0 || results.categories.length > 0 || results.brands.length > 0)"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden max-h-[500px] overflow-y-auto">

                            {{-- Loading --}}
                            <div x-show="loading" class="p-4 text-center">
                                <svg class="animate-spin h-6 w-6 mx-auto text-gray-900" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>

                            {{-- Products Section --}}
                            <template x-if="!loading && results.products.length > 0">
                                <div class="p-3">
                                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider px-2 mb-2">Sản
                                        phẩm</h3>
                                    <template x-for="(product, index) in results.products" :key="product.id">
                                        <a :href="product.url"
                                            class="flex items-center gap-3 p-2 rounded-xl hover:bg-gray-50 transition-colors"
                                            :class="{'bg-gray-100': selectedIndex === index}">
                                            <div
                                                class="w-14 h-14 bg-gray-50 rounded-lg border border-gray-100 flex-shrink-0 overflow-hidden">
                                                <img :src="product.image" :alt="product.name"
                                                    class="w-full h-full object-contain p-1">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 line-clamp-1"
                                                    x-text="product.name"></p>
                                                <p class="text-xs text-gray-500" x-text="product.category"></p>
                                            </div>
                                            <div class="text-right flex-shrink-0">
                                                <p class="text-sm font-bold text-gray-900"
                                                    x-text="product.formatted_price"></p>
                                                <template x-if="product.original_price">
                                                    <p class="text-xs text-gray-400 line-through"
                                                        x-text="formatPrice(product.original_price)"></p>
                                                </template>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </template>

                            {{-- Categories Section --}}
                            <template x-if="!loading && results.categories.length > 0">
                                <div class="p-3 border-t border-gray-100">
                                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider px-2 mb-2">Danh
                                        mục</h3>
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="category in results.categories" :key="category.id">
                                            <a :href="category.url"
                                                class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 hover:text-gray-900 transition-colors">
                                                <span x-text="category.name"></span>
                                                <span class="text-gray-400"
                                                    x-text="'(' + category.product_count + ')'"></span>
                                            </a>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            {{-- Brands Section --}}
                            <template x-if="!loading && results.brands.length > 0">
                                <div class="p-3 border-t border-gray-100">
                                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider px-2 mb-2">
                                        Thương hiệu</h3>
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="brand in results.brands" :key="brand.name">
                                            <a :href="brand.url"
                                                class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition-colors font-medium">
                                                <span x-text="brand.name"></span>
                                            </a>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            {{-- View All Results --}}
                            <template x-if="!loading && results.products.length > 0">
                                <div class="p-3 border-t border-gray-100 bg-gray-50">
                                    <a :href="'/products?search=' + encodeURIComponent(query)"
                                        class="flex items-center justify-center gap-2 w-full py-2 text-gray-900 hover:text-gray-700 font-medium text-sm">
                                        <span>Xem tất cả kết quả cho </span>
                                        <span class="font-bold" x-text="'\"' + query + ' \"'"></span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </a>
                                </div>
                            </template>
                        </div>

                        {{-- No Results --}}
                        <div x-show="showDropdown && !loading && query.length >= 2 && results.products.length === 0 && results.categories.length === 0"
                            class="absolute left-0 right-0 top-full mt-2 bg-white rounded-xl shadow-lg border border-gray-100 z-50 p-6 text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <p class="text-gray-500 text-sm">Không tìm thấy kết quả cho "<span class="font-medium"
                                    x-text="query"></span>"</p>
                        </div>
                    </div>
                </div>

                <script>
                    function smartSearch() {
                        return {
                            query: '{{ request("search", "") }}',
                            showDropdown: false,
                            loading: false,
                            selectedIndex: -1,
                            results: { products: [], categories: [], brands: [] },

                            async search() {
                                if (this.query.length < 2) {
                                    this.showDropdown = false;
                                    this.results = { products: [], categories: [], brands: [] };
                                    return;
                                }
                                this.loading = true;
                                this.showDropdown = true;
                                this.selectedIndex = -1;

                                try {
                                    const response = await fetch(`/api/search/suggestions?q=${encodeURIComponent(this.query)}`);
                                    this.results = await response.json();
                                } catch (error) {
                                    console.error('Search error:', error);
                                }
                                this.loading = false;
                            },

                            navigateDown() {
                                if (this.selectedIndex < this.results.products.length - 1) this.selectedIndex++;
                            },
                            navigateUp() {
                                if (this.selectedIndex > 0) this.selectedIndex--;
                            },
                            goToSelected() {
                                if (this.selectedIndex >= 0 && this.results.products[this.selectedIndex]) {
                                    window.location.href = this.results.products[this.selectedIndex].url;
                                }
                            },
                            formatPrice(price) {
                                return new Intl.NumberFormat('vi-VN').format(price) + '₫';
                            }
                        }
                    }
                </script>

                {{-- Actions --}}
                <div class="flex items-center gap-3 lg:gap-6 text-gray-600">
                    {{-- Language Switcher (Desktop) --}}
                    <div class="hidden lg:block">
                        @include('components.language-switcher')
                    </div>

                    {{-- Mobile Search Button --}}
                    <a href="{{ route('products.index') }}"
                        class="lg:hidden p-2 rounded-full hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </a>

                    {{-- Cart Icon --}}
                    <a href="{{ route('cart.index') }}"
                        class="relative hover:text-blue-600 transition-colors p-2 rounded-full hover:bg-gray-50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        @auth
                            @php
                                $cart = auth()->user()->getActiveCart();
                                $itemCount = $cart ? $cart->items->sum('qty') : 0;
                            @endphp
                            @if($itemCount > 0)
                                <span
                                    class="absolute top-0 right-0 bg-gray-900 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center ring-2 ring-white">
                                    {{ $itemCount }}
                                </span>
                            @endif
                        @endauth
                    </a>

                    {{-- Auth Links (Desktop) --}}
                    @auth
                        <div x-data="{ open: false }" class="relative hidden lg:block">
                            <button @click="open = !open"
                                class="flex items-center gap-2 hover:text-blue-600 transition-colors p-1 pr-3 rounded-full hover:bg-gray-50 border border-transparent hover:border-gray-200">
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-900 flex items-center justify-center text-white font-bold text-xs">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-sm hidden lg:inline">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-56 bg-white border border-gray-100 rounded-xl shadow-lg py-2 z-50">
                                <div class="px-4 py-2 border-b border-gray-100 mb-2">
                                    <p class="text-sm font-medium text-gray-900">Tài khoản của tôi</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                @if(auth()->user()->isAdmin() || auth()->user()->isModerator())
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                            </path>
                                        </svg>
                                        Admin Dashboard
                                    </a>
                                    <div class="border-t border-gray-100 my-2"></div>
                                @endif
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600">Cài
                                    đặt tài khoản</a>
                                <a href="{{ route('orders.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600">Đơn
                                    hàng của tôi</a>
                                <div class="border-t border-gray-100 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                        {{-- Mobile User Icon --}}
                        <a href="{{ route('profile.edit') }}" class="lg:hidden">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-900 flex items-center justify-center text-white font-bold text-xs">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </a>
                    @else
                        <div class="hidden lg:flex items-center gap-4 text-sm font-medium">
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 transition-colors">Đăng
                                nhập</a>
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 bg-black text-white rounded-full hover:bg-gray-800 transition-colors shadow-sm hover:shadow">Đăng
                                ký</a>
                        </div>
                        {{-- Mobile Login --}}
                        <a href="{{ route('login') }}" class="lg:hidden p-2 rounded-full hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2" class="lg:hidden bg-white border-t border-gray-100 shadow-lg"
        style="display: none;">
        <div class="container mx-auto px-4 py-4">
            {{-- Mobile Search --}}
            <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm sản phẩm..."
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 text-sm">
            </form>

            {{-- Mobile Navigation Links --}}
            <div class="space-y-1">
                <a href="{{ route('products.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl font-medium">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Tất cả sản phẩm
                </a>
                <a href="{{ route('pc-gaming.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl font-medium">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                        </path>
                    </svg>
                    PC Gaming
                </a>
                <a href="{{ route('build-pc') }}"
                    class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl font-medium">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                        </path>
                    </svg>
                    Build PC
                </a>

                {{-- Categories --}}
                <div class="border-t border-gray-100 my-2 pt-2">
                    <p class="px-4 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Danh mục</p>
                    <a href="{{ route('products.index', ['category' => 'cpu']) }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:bg-gray-50 rounded-xl">CPU - Vi
                        xử lý</a>
                    <a href="{{ route('products.index', ['category' => 'vga']) }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:bg-gray-50 rounded-xl">VGA - Card
                        màn hình</a>
                    <a href="{{ route('products.index', ['category' => 'ram']) }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:bg-gray-50 rounded-xl">RAM - Bộ
                        nhớ</a>
                    <a href="{{ route('products.index', ['category' => 'mainboard']) }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:bg-gray-50 rounded-xl">Mainboard</a>
                    <a href="{{ route('products.index', ['category' => 'ssd']) }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:bg-gray-50 rounded-xl">SSD - Ổ
                        cứng</a>
                </div>

                {{-- Auth Links Mobile --}}
                @guest
                    <div class="border-t border-gray-100 my-2 pt-2">
                        <a href="{{ route('login') }}"
                            class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl font-medium">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Đăng nhập
                        </a>
                        <a href="{{ route('register') }}"
                            class="flex items-center gap-3 px-4 py-3 text-blue-600 hover:bg-blue-50 rounded-xl font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                            Đăng ký tài khoản
                        </a>
                    </div>
                @else
                    <div class="border-t border-gray-100 my-2 pt-2">
                        @if(auth()->user()->isAdmin() || auth()->user()->isModerator())
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center gap-3 px-4 py-3 text-blue-600 hover:bg-blue-50 rounded-xl font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                                Admin Dashboard
                            </a>
                        @endif
                        <a href="{{ route('orders.index') }}"
                            class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl font-medium">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Đơn hàng của tôi
                        </a>
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl font-medium">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Tài khoản
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl font-medium w-full">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </div>

    {{-- Navigation Bar --}}
    <nav class="bg-black text-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center" x-data="{ openMenu: null, subMenu: null }">
                {{-- Category Mega Menu --}}
                <div class="relative" @mouseenter="openMenu = 'categories'"
                    @mouseleave="openMenu = null; subMenu = null">
                    <button
                        class="flex items-center gap-2 px-0 py-4 mr-8 font-semibold text-sm text-white hover:text-blue-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <span>Danh mục sản phẩm</span>
                    </button>

                    {{-- Mega Menu Dropdown --}}
                    <div x-show="openMenu === 'categories'" x-transition:enter="transition ease-out duration-200"
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- VGA --}}
                                <a href="{{ route('products.index', ['category' => 'vga']) }}"
                                    @mouseenter="subMenu = 'vga'"
                                    class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                    :class="subMenu === 'vga' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>VGA - Card màn hình</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- RAM --}}
                                <a href="{{ route('products.index', ['category' => 'ram']) }}"
                                    @mouseenter="subMenu = 'ram'"
                                    class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                    :class="subMenu === 'ram' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>RAM - Bộ nhớ trong</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- Mainboard --}}
                                <a href="{{ route('products.index', ['category' => 'mainboard']) }}"
                                    @mouseenter="subMenu = 'mainboard'"
                                    class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                    :class="subMenu === 'mainboard' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>Mainboard</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- SSD --}}
                                <a href="{{ route('products.index', ['category' => 'ssd']) }}"
                                    @mouseenter="subMenu = 'ssd'"
                                    class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                    :class="subMenu === 'ssd' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>SSD - Lưu trữ</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- Monitor --}}
                                <a href="{{ route('products.index', ['category' => 'monitor']) }}"
                                    @mouseenter="subMenu = 'monitor'"
                                    class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                    :class="subMenu === 'monitor' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>Màn hình</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- PSU --}}
                                <a href="{{ route('products.index', ['category' => 'psu']) }}"
                                    @mouseenter="subMenu = 'psu'"
                                    class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                    :class="subMenu === 'psu' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>Nguồn máy tính</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- Case --}}
                                <a href="{{ route('products.index', ['category' => 'case']) }}"
                                    @mouseenter="subMenu = 'case'"
                                    class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                    :class="subMenu === 'case' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>Vỏ máy tính</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                {{-- Cooling --}}
                                <a href="{{ route('products.index', ['category' => 'tan-nhiet']) }}"
                                    @mouseenter="subMenu = 'cooling'"
                                    class="flex items-center justify-between px-4 py-3 mx-2 rounded-lg transition-colors cursor-pointer"
                                    :class="subMenu === 'cooling' ? 'bg-white text-blue-600 shadow-sm font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                    <span>Tản nhiệt</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>

                            {{-- Right: Filter Panel --}}
                            <div class="col-span-9 p-8 bg-white">
                                {{-- CPU Filters --}}
                                <div x-show="subMenu === 'cpu'" x-transition class="grid grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Hãng
                                            sản xuất</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'cpu', 'brand' => ['Intel']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Intel</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu', 'brand' => ['AMD']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">AMD</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Socket
                                        </h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'cpu', 'socket' => ['LGA1700']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">LGA
                                                    1700 (Intel Gen 12-14)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu', 'socket' => ['AM5']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">AM5
                                                    (Ryzen 7000)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu', 'socket' => ['AM4']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">AM4
                                                    (Ryzen 5000)</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Dòng
                                            Core</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'cpu']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Intel
                                                    Core i9</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Intel
                                                    Core i7</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Intel
                                                    Core i5</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">AMD
                                                    Ryzen 9</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'cpu']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">AMD
                                                    Ryzen 7</a></li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- VGA Filters --}}
                                <div x-show="subMenu === 'vga'" x-transition class="grid grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Hãng
                                            sản xuất</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'vga-asus']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">ASUS</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-msi']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">MSI</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-gigabyte']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">GIGABYTE</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga-asrock']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">ASROCK</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">NVIDIA
                                            Series</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'vga', 'chip' => 'RTX 50']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">RTX
                                                    50 Series</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga', 'chip' => 'RTX 40']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">RTX
                                                    40 Series</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga', 'chip' => 'RTX 30']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">RTX
                                                    30 Series</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">AMD
                                            Series</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'vga', 'chip' => 'RX 7900']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">RX
                                                    7900 Series</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga', 'chip' => 'RX 7800']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">RX
                                                    7800 Series</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'vga', 'chip' => 'RX 7700']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">RX
                                                    7700 Series</a></li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- RAM Filters --}}
                                <div x-show="subMenu === 'ram'" x-transition class="grid grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Loại
                                            RAM</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'ram', 'type' => ['DDR5']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">DDR5</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram', 'type' => ['DDR4']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">DDR4</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Dung
                                            lượng</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'ram', 'capacity' => ['64GB']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">64GB
                                                    (32GB x2)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram', 'capacity' => ['32GB']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">32GB
                                                    (16GB x2)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram', 'capacity' => ['16GB']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">16GB
                                                    (8GB x2)</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Thương
                                            hiệu</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'ram']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Corsair</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">G.Skill</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'ram']) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Kingston</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Monitor Filters --}}
                                <div x-show="subMenu === 'monitor'" x-transition class="grid grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Kích
                                            thước</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'size' => ['24\"']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">24
                                                    inch</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'size' => ['27\"']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">27
                                                    inch</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'size' => ['32\"']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">32
                                                    inch</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Độ
                                            phân giải</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'resolution' => ['Full HD']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Full
                                                    HD</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'resolution' => ['2K']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">2K
                                                    QHD</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'resolution' => ['4K']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">4K
                                                    UHD</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Tần số
                                            quét</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'refresh' => ['144Hz']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">144Hz</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'refresh' => ['165Hz']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">165Hz</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'monitor', 'refresh' => ['240Hz']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">240Hz+</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Mainboard Filters --}}
                                <div x-show="subMenu === 'mainboard'" x-transition class="grid grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Hãng
                                            sản xuất</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'brand' => ['ASUS']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">ASUS</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'brand' => ['MSI']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">MSI</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'brand' => ['Gigabyte']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">GIGABYTE</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Socket
                                        </h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'mb_cpu_socket' => ['LGA1700']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">LGA
                                                    1700 (Intel)</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'mb_cpu_socket' => ['AM5']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">AM5
                                                    (AMD)</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">
                                            Chipset</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'mb_chipset' => ['Z790']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Z790</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'mb_chipset' => ['B760']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">B760</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'mainboard', 'mb_chipset' => ['X670E']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">X670E</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- SSD Filters --}}
                                <div x-show="subMenu === 'ssd'" x-transition class="grid grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Hãng
                                            sản xuất</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'brand' => ['Samsung']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Samsung</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'brand' => ['Kingston']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Kingston</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'brand' => ['WD']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">WD</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Dung
                                            lượng</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'ssd_capacity_gb' => ['2000']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">2TB</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'ssd_capacity_gb' => ['1000']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">1TB</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'ssd_capacity_gb' => ['500']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">500GB</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Giao
                                            tiếp</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'ssd_interface' => ['PCIe 5.0']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">NVMe
                                                    PCIe 5.0</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'ssd', 'ssd_interface' => ['PCIe 4.0']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">NVMe
                                                    PCIe 4.0</a></li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Default message when no submenu --}}
                                <div x-show="!subMenu"
                                    class="flex flex-col items-center justify-center h-full text-gray-400">
                                    <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                        </path>
                                    </svg>
                                    <p class="text-sm font-medium">Di chuột vào danh mục để xem chi tiết</p>
                                </div>

                                {{-- PSU Filters --}}
                                <div x-show="subMenu === 'psu'" x-transition class="grid grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Hãng
                                            sản xuất</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'psu', 'psu_brand' => ['Corsair']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Corsair</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'psu', 'psu_brand' => ['Cooler Master']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Cooler
                                                    Master</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'psu', 'psu_brand' => ['ASUS']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">ASUS</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Công
                                            suất</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'psu', 'psu_wattage' => ['650W']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">650W</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'psu', 'psu_wattage' => ['750W']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">750W</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'psu', 'psu_wattage' => ['850W']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">850W</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'psu', 'psu_wattage' => ['1000W']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">1000W+</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Chuẩn
                                            nguồn</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'psu', 'psu_efficiency' => ['80 Plus Gold']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">80
                                                    Plus Gold</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'psu', 'psu_efficiency' => ['80 Plus Bronze']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">80
                                                    Plus Bronze</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'psu', 'psu_efficiency' => ['80 Plus Platinum']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">80
                                                    Plus Platinum</a></li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Case Filters --}}
                                <div x-show="subMenu === 'case'" x-transition class="grid grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Hãng
                                            sản xuất</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'case', 'case_brand' => ['NZXT']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">NZXT</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'case', 'case_brand' => ['Corsair']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Corsair</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'case', 'case_brand' => ['Lian Li']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Lian
                                                    Li</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Kích
                                            thước</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'case', 'case_form_factor' => ['Mid Tower']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Mid
                                                    Tower</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'case', 'case_form_factor' => ['Full Tower']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Full
                                                    Tower</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'case', 'case_form_factor' => ['Mini ITX']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Mini
                                                    ITX</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Màu
                                            sắc</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'case', 'case_color' => ['Black']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Đen</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'case', 'case_color' => ['White']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Trắng</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Cooling Filters --}}
                                <div x-show="subMenu === 'cooling'" x-transition class="grid grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Hãng
                                            sản xuất</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'tan-nhiet', 'cooling_brand' => ['Corsair']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Corsair</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'tan-nhiet', 'cooling_brand' => ['NZXT']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">NZXT</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'tan-nhiet', 'cooling_brand' => ['Deepcool']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Deepcool</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Loại
                                            tản nhiệt</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'tan-nhiet', 'cooling_type' => ['AIO Liquid']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Tản
                                                    nhiệt nước AIO</a></li>
                                            <li><a href="{{ route('products.index', ['category' => 'tan-nhiet', 'cooling_type' => ['Air Cooler']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">Tản
                                                    nhiệt khí</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs tracking-wider text-gray-400 mb-4 uppercase">Kích
                                            thước Radiator</h4>
                                        <ul class="space-y-3 text-sm">
                                            <li><a href="{{ route('products.index', ['category' => 'tan-nhiet', 'cooling_radiator_size' => ['360']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">360mm</a>
                                            </li>
                                            <li><a href="{{ route('products.index', ['category' => 'tan-nhiet', 'cooling_radiator_size' => ['240']]) }}"
                                                    class="text-gray-700 hover:text-blue-600 hover:translate-x-1 transition-all inline-block">240mm</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="flex items-center gap-8">
                    <a href="{{ route('products.index') }}"
                        class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
                        Tất cả sản phẩm
                    </a>

                    {{-- PC Build Dropdown --}}
                    <div class="relative group" @mouseenter="openMenu = 'pcbuild'" @mouseleave="openMenu = null">
                        <button
                            class="flex items-center gap-1 text-sm font-medium text-gray-300 hover:text-white transition-colors">
                            PC Build
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        {{-- PC Build Dropdown Menu --}}
                        <div x-show="openMenu === 'pcbuild'" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute left-0 top-full w-64 bg-white rounded-xl shadow-xl border border-gray-100 z-50 mt-1 overflow-hidden">
                            <div class="py-2">
                                <a href="{{ route('pc-gaming.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-900">PC Gaming</div>
                                        <div class="text-xs text-gray-500">Hiệu năng cao cho game thủ</div>
                                    </div>
                                </a>
                                <a href="{{ route('pc-ai.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-900">PC AI Workstation</div>
                                        <div class="text-xs text-gray-500">Deep Learning & AI</div>
                                    </div>
                                </a>
                                <a href="{{ route('pc-design.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-900">PC Design</div>
                                        <div class="text-xs text-gray-500">Đồ họa & Render</div>
                                    </div>
                                </a>
                                <a href="{{ route('pc-office.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-900">PC Office</div>
                                        <div class="text-xs text-gray-500">Văn phòng & Học tập</div>
                                    </div>
                                </a>
                                <div class="border-t border-gray-100 my-2"></div>
                                <a href="{{ route('build-pc') }}"
                                    class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors group/build">
                                    <div class="flex-1">
                                        <div class="font-medium text-blue-600 group-hover/build:text-blue-700">Tự Build
                                            PC</div>
                                        <div class="text-xs text-gray-500">Tùy chỉnh cấu hình theo ý muốn</div>
                                    </div>
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
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