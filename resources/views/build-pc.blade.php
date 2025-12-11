@extends('layouts.app')

@section('title', 'Tự Build PC - Tùy chỉnh linh kiện')

@section('content')
    <div class="bg-gray-50 min-h-screen" x-data="pcBuilder()">
        <div class="container mx-auto px-4 py-8 max-w-7xl">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm mb-6">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-900">Trang chủ</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">Build PC</span>
            </nav>

            {{-- Header --}}
            <div class="mb-10 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">
                    🖥️ Tự Build PC
                </h1>
                <p class="text-gray-500 text-lg">Chọn từng linh kiện để tạo nên bộ PC hoàn hảo của bạn</p>
            </div>

            <!-- Compatibility Alerts -->
            <template x-if="compatibilityMessages.length > 0">
                <div class="mb-6 space-y-2">
                    <template x-for="msg in compatibilityMessages" :key="msg.text">
                        <div :class="msg.type === 'error' ? 'bg-red-50 border-red-400 text-red-700' : (msg.type === 'warning' ? 'bg-yellow-50 border-yellow-400 text-yellow-700' : 'bg-blue-50 border-blue-400 text-blue-700')"
                            class="border-l-4 px-4 py-3 rounded-r-lg flex items-center gap-3" role="alert">
                            <span class="text-xl"
                                x-text="msg.type === 'error' ? '❌' : (msg.type === 'warning' ? '⚠️' : 'ℹ️')"></span>
                            <span x-text="msg.text"></span>
                        </div>
                    </template>
                </div>
            </template>

            <!-- Compatibility Info (when filtering active) -->
            <template x-if="getActiveFilter()">
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-center gap-3">
                    <span class="text-2xl">🎯</span>
                    <div>
                        <div class="font-semibold text-blue-900">Đang lọc theo tương thích</div>
                        <div class="text-sm text-blue-700" x-text="getActiveFilter()"></div>
                    </div>
                </div>
            </template>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Component Selection --}}
                <div class="lg:col-span-2 space-y-4">

                    @php
                        $components = [
                            ['key' => 'cpu', 'name' => 'CPU - Bộ vi xử lý', 'required' => true, 'icon' => '🔲'],
                            ['key' => 'mainboard', 'name' => 'Mainboard - Bo mạch chủ', 'required' => true, 'icon' => '🔌'],
                            ['key' => 'gpu', 'name' => 'VGA - Card màn hình', 'required' => true, 'icon' => '🎮'],
                            ['key' => 'ram', 'name' => 'RAM - Bộ nhớ', 'required' => true, 'icon' => '💾'],
                            ['key' => 'ssd', 'name' => 'SSD - Ổ cứng', 'required' => false, 'icon' => '💿'],
                            ['key' => 'psu', 'name' => 'PSU - Nguồn', 'required' => false, 'icon' => '⚡'],
                            ['key' => 'case', 'name' => 'Case - Vỏ máy', 'required' => false, 'icon' => '🖥️'],
                            ['key' => 'cooler', 'name' => 'Cooler - Tản nhiệt', 'required' => false, 'icon' => '❄️'],
                        ];
                    @endphp

                    @foreach($components as $comp)
                        <div
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-xl">
                                        {{ $comp['icon'] }}
                                    </div>
                                    <h3 class="font-bold text-gray-900">{{ $comp['name'] }}</h3>
                                </div>
                                @if($comp['required'])
                                    <span class="text-red-500 text-xs font-medium bg-red-50 px-3 py-1 rounded-full">* Bắt
                                        buộc</span>
                                @else
                                    <span class="text-gray-400 text-xs bg-gray-50 px-3 py-1 rounded-full">Tùy chọn</span>
                                @endif
                            </div>
                            <div class="p-4">
                                <template x-if="!selectedComponents.{{ $comp['key'] }}">
                                    <button @click="openModal('{{ $comp['key'] }}')"
                                        class="w-full border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-gray-900 hover:bg-gray-50 transition-all group cursor-pointer">
                                        <svg class="w-10 h-10 mx-auto text-gray-300 group-hover:text-gray-900 mb-2 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        <p class="text-gray-500 group-hover:text-gray-900 font-medium transition-colors">Chọn
                                            {{ $comp['name'] }}</p>
                                        <p class="text-xs text-gray-400 mt-1">Click để xem danh sách</p>
                                    </button>
                                </template>
                                <template x-if="selectedComponents.{{ $comp['key'] }}">
                                    <div class="flex items-center gap-4 bg-gray-50 rounded-xl p-4 border border-gray-100">
                                        <img :src="selectedComponents.{{ $comp['key'] }}.image || '/images/no-image.png'"
                                            alt="{{ $comp['name'] }}"
                                            class="w-16 h-16 object-contain bg-white rounded-lg p-1 border border-gray-200">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-900 truncate"
                                                x-text="selectedComponents.{{ $comp['key'] }}.name"></h4>
                                            <p class="text-lg font-bold text-gray-900 mt-1">
                                                <span x-text="formatPrice(selectedComponents.{{ $comp['key'] }}.price)"></span>₫
                                            </p>
                                            <!-- Show specs info -->
                                            <p class="text-xs text-gray-500 mt-1"
                                                x-show="selectedComponents.{{ $comp['key'] }}.specs">
                                                <template x-if="'{{ $comp['key'] }}' === 'cpu'">
                                                    <span
                                                        x-text="'Socket: ' + (selectedComponents.{{ $comp['key'] }}.specs?.socket || 'N/A')"></span>
                                                </template>
                                                <template x-if="'{{ $comp['key'] }}' === 'mainboard'">
                                                    <span
                                                        x-text="(selectedComponents.{{ $comp['key'] }}.specs?.socket || '') + ' | ' + (selectedComponents.{{ $comp['key'] }}.specs?.memory_type || '')"></span>
                                                </template>
                                                <template x-if="'{{ $comp['key'] }}' === 'ram'">
                                                    <span
                                                        x-text="selectedComponents.{{ $comp['key'] }}.specs?.type || ''"></span>
                                                </template>
                                            </p>
                                        </div>
                                        <div class="flex gap-2">
                                            <button @click="openModal('{{ $comp['key'] }}')"
                                                class="text-gray-500 hover:text-gray-900 p-2 hover:bg-gray-200 rounded-lg transition"
                                                title="Đổi linh kiện">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button @click="removeComponent('{{ $comp['key'] }}')"
                                                class="text-gray-500 hover:text-red-600 p-2 hover:bg-red-50 rounded-lg transition"
                                                title="Xóa">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Summary Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                        <div class="bg-gray-900 text-white px-6 py-5 rounded-t-2xl">
                            <h3 class="font-bold text-xl">📋 Tổng Quan Build</h3>
                        </div>

                        <div class="p-6 space-y-4">
                            {{-- Component Count --}}
                            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                                <span class="text-gray-600">Linh kiện đã chọn</span>
                                <span class="font-bold text-2xl text-gray-900" x-text="componentCount + '/8'"></span>
                            </div>

                            {{-- Selected Components List --}}
                            <div class="space-y-2 pb-4 border-b border-gray-100 max-h-60 overflow-y-auto">
                                <template x-for="(comp, key) in selectedComponents" :key="key">
                                    <div x-show="comp" class="flex justify-between text-sm py-1">
                                        <span class="text-gray-500 uppercase font-medium" x-text="key"></span>
                                        <span class="font-semibold text-gray-900"
                                            x-text="formatPrice(comp?.price || 0) + '₫'"></span>
                                    </div>
                                </template>
                            </div>

                            {{-- Total Price --}}
                            <div class="bg-gray-100 rounded-xl p-5 text-center">
                                <div class="text-sm text-gray-600 mb-1">Tổng giá trị</div>
                                <div class="text-3xl font-bold text-gray-900" x-text="formatPrice(totalPrice) + '₫'"></div>
                            </div>

                            {{-- Actions --}}
                            <template x-if="canAddToCart">
                                <button @click="addAllToCart()"
                                    class="w-full bg-gray-900 hover:bg-gray-800 text-white font-bold py-4 rounded-full transition-all shadow-lg hover:shadow-xl">
                                    🛒 Thêm Tất Cả Vào Giỏ
                                </button>
                            </template>
                            <template x-if="!canAddToCart">
                                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-sm text-yellow-700">
                                    <div class="font-semibold mb-1">⚠️ Chưa đủ linh kiện</div>
                                    <div class="text-xs">Vui lòng chọn CPU, Mainboard, VGA và RAM</div>
                                </div>
                            </template>

                            <button @click="resetBuild()"
                                class="w-full border border-gray-200 text-gray-600 hover:border-gray-300 hover:bg-gray-50 font-medium py-3 rounded-full transition">
                                🔄 Đặt Lại
                            </button>

                            {{-- Compatibility Tips --}}
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 text-sm">
                                <div class="font-semibold text-gray-900 mb-2">💡 Tương thích tự động</div>
                                <ul class="space-y-1 text-xs text-gray-600">
                                    <li>• Chọn CPU → Mainboard tự lọc theo socket</li>
                                    <li>• Chọn Mainboard → RAM tự lọc theo DDR</li>
                                    <li>• Hệ thống kiểm tra và cảnh báo tự động</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Component Selection Modal --}}
        <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-hidden" style="display: none;">

            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="closeModal()"></div>

            {{-- Modal Content --}}
            <div class="absolute inset-4 md:inset-8 lg:inset-12 bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                {{-- Modal Header --}}
                <div class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl" x-text="getComponentIcon(currentComponentType)"></span>
                        <div>
                            <h2 class="text-xl font-bold" x-text="'Chọn ' + getComponentName(currentComponentType)"></h2>
                            <p class="text-sm text-gray-400" x-show="getFilterInfo()" x-text="getFilterInfo()"></p>
                        </div>
                    </div>
                    <button @click="closeModal()" class="p-2 hover:bg-white/20 rounded-lg transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="flex-1 flex overflow-hidden">
                    {{-- Filters Sidebar --}}
                    <div class="w-72 bg-gray-50 border-r border-gray-200 p-5 overflow-y-auto hidden md:block">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                            🔍 Bộ lọc
                        </h3>

                        {{-- Search --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                            <input type="text" x-model="filters.search" @input.debounce.300ms="fetchProducts()"
                                placeholder="Nhập tên sản phẩm..."
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                        </div>

                        {{-- Price Range --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Khoảng giá</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-gray-100">
                                    <input type="radio" name="price" value="" x-model="filters.priceRange"
                                        @change="fetchProducts()" class="text-gray-900 focus:ring-gray-900">
                                    <span class="text-sm text-gray-700">Tất cả</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-gray-100">
                                    <input type="radio" name="price" value="0-5000000" x-model="filters.priceRange"
                                        @change="fetchProducts()" class="text-gray-900 focus:ring-gray-900">
                                    <span class="text-sm text-gray-700">Dưới 5 triệu</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-gray-100">
                                    <input type="radio" name="price" value="5000000-10000000" x-model="filters.priceRange"
                                        @change="fetchProducts()" class="text-gray-900 focus:ring-gray-900">
                                    <span class="text-sm text-gray-700">5 - 10 triệu</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-gray-100">
                                    <input type="radio" name="price" value="10000000-20000000" x-model="filters.priceRange"
                                        @change="fetchProducts()" class="text-gray-900 focus:ring-gray-900">
                                    <span class="text-sm text-gray-700">10 - 20 triệu</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-gray-100">
                                    <input type="radio" name="price" value="20000000-" x-model="filters.priceRange"
                                        @change="fetchProducts()" class="text-gray-900 focus:ring-gray-900">
                                    <span class="text-sm text-gray-700">Trên 20 triệu</span>
                                </label>
                            </div>
                        </div>

                        {{-- Sort --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sắp xếp</label>
                            <select x-model="filters.sort" @change="fetchProducts()"
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-gray-900">
                                <option value="">Mặc định</option>
                                <option value="price_asc">Giá tăng dần</option>
                                <option value="price_desc">Giá giảm dần</option>
                                <option value="name_asc">Tên A-Z</option>
                            </select>
                        </div>

                        {{-- Clear Filters --}}
                        <button @click="clearFilters()"
                            class="w-full text-sm text-gray-600 hover:text-gray-900 font-medium py-2 border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                            ↺ Xóa bộ lọc
                        </button>
                    </div>

                    {{-- Products Grid --}}
                    <div class="flex-1 p-5 overflow-y-auto bg-gray-50">
                        {{-- Mobile Search --}}
                        <div class="md:hidden mb-4">
                            <input type="text" x-model="filters.search" @input.debounce.300ms="fetchProducts()"
                                placeholder="🔍 Tìm kiếm..."
                                class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-gray-900">
                        </div>

                        {{-- Compatibility Filter Notice --}}
                        <div x-show="getFilterInfo()"
                            class="mb-4 bg-blue-50 border border-blue-200 rounded-xl p-3 flex items-center gap-2">
                            <span class="text-blue-600">🎯</span>
                            <span class="text-sm text-blue-800" x-text="getFilterInfo()"></span>
                            <button @click="clearCompatibilityFilter()"
                                class="ml-auto text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Xem tất cả
                            </button>
                        </div>

                        {{-- Loading State --}}
                        <div x-show="loading" class="flex items-center justify-center py-20">
                            <div class="animate-spin rounded-full h-12 w-12 border-4 border-gray-900 border-t-transparent">
                            </div>
                        </div>

                        {{-- Products Grid --}}
                        <div x-show="!loading" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <template x-for="product in products" :key="product.id">
                                <div @click="selectProduct(product)"
                                    :class="{'ring-2 ring-gray-900': isProductSelected(product)}"
                                    class="bg-white border border-gray-200 rounded-xl p-4 cursor-pointer hover:border-gray-400 hover:shadow-lg transition-all group">
                                    <div class="aspect-square bg-gray-50 rounded-lg mb-3 overflow-hidden">
                                        <img :src="product.image_url || '/images/no-image.png'" :alt="product.name"
                                            class="w-full h-full object-contain group-hover:scale-105 transition-transform p-2">
                                    </div>
                                    <h4 class="font-medium text-gray-900 text-sm line-clamp-2 mb-2 min-h-[2.5rem]"
                                        x-text="product.name"></h4>

                                    {{-- Show relevant specs --}}
                                    <div class="text-xs text-gray-500 mb-2 min-h-[1rem]">
                                        <template x-if="currentComponentType === 'cpu' && product.specs?.socket">
                                            <span x-text="'Socket: ' + product.specs.socket"></span>
                                        </template>
                                        <template x-if="currentComponentType === 'mainboard' && product.specs?.socket">
                                            <span
                                                x-text="product.specs.socket + ' | ' + (product.specs.memory_type || '')"></span>
                                        </template>
                                        <template x-if="currentComponentType === 'ram' && product.specs?.type">
                                            <span
                                                x-text="product.specs.type + ' ' + (product.specs.speed_mhz || '') + 'MHz'"></span>
                                        </template>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-gray-900"
                                            x-text="formatPrice(product.sale_price || product.price) + '₫'"></span>
                                    </div>
                                    <div x-show="product.sale_price" class="text-xs text-gray-400 line-through"
                                        x-text="formatPrice(product.price) + '₫'"></div>

                                    <div class="mt-2 text-xs"
                                        :class="product.stock > 0 ? 'text-green-600' : 'text-red-500'">
                                        <span
                                            x-text="product.stock > 0 ? ('Còn ' + product.stock + ' sản phẩm') : 'Hết hàng'"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- Empty State --}}
                        <div x-show="!loading && products.length === 0" class="text-center py-20">
                            <div class="text-6xl mb-4">📦</div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Không tìm thấy sản phẩm</h3>
                            <p class="text-gray-600 mb-4">Thử thay đổi bộ lọc hoặc xem tất cả sản phẩm</p>
                            <button @click="clearCompatibilityFilter()" class="text-gray-900 font-medium hover:underline">
                                Xem tất cả sản phẩm
                            </button>
                        </div>

                        {{-- Pagination --}}
                        <div x-show="!loading && totalPages > 1" class="flex justify-center gap-2 mt-6">
                            <button @click="prevPage()" :disabled="currentPage === 1"
                                :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium bg-white">
                                ← Trước
                            </button>
                            <span class="px-4 py-2 text-sm text-gray-600">
                                Trang <span x-text="currentPage"></span> / <span x-text="totalPages"></span>
                            </span>
                            <button @click="nextPage()" :disabled="currentPage === totalPages"
                                :class="currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium bg-white">
                                Sau →
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function pcBuilder() {
            return {
                selectedComponents: {
                    cpu: null,
                    mainboard: null,
                    gpu: null,
                    ram: null,
                    ssd: null,
                    psu: null,
                    case: null,
                    cooler: null
                },
                compatibilityMessages: [],

                // Modal state
                modalOpen: false,
                currentComponentType: '',
                products: [],
                loading: false,
                currentPage: 1,
                totalPages: 1,
                skipCompatibilityFilter: false,

                // Filters
                filters: {
                    search: '',
                    priceRange: '',
                    sort: ''
                },

                // Category mapping
                categoryMap: {
                    'cpu': 'cpu',
                    'gpu': 'vga',
                    'mainboard': 'mainboard',
                    'ram': 'ram',
                    'ssd': 'ssd',
                    'psu': 'psu',
                    'case': 'case',
                    'cooler': 'cooler'
                },

                async init() {
                    // Load from localStorage
                    const saved = localStorage.getItem('pcBuild');
                    if (saved) {
                        try {
                            const parsed = JSON.parse(saved);
                            this.selectedComponents = { ...this.selectedComponents, ...parsed };
                        } catch (e) {
                            console.error('Error loading saved build:', e);
                        }
                    }
                    this.checkCompatibility();
                },

                // Get compatibility filter for current component type
                getCompatibilityFilter() {
                    if (this.skipCompatibilityFilter) return {};

                    const filters = {};

                    // When selecting Mainboard, filter by CPU socket
                    if (this.currentComponentType === 'mainboard' && this.selectedComponents.cpu?.specs?.socket) {
                        filters.socket = this.selectedComponents.cpu.specs.socket;
                    }

                    // When selecting RAM, filter by Mainboard memory type
                    if (this.currentComponentType === 'ram' && this.selectedComponents.mainboard?.specs?.memory_type) {
                        filters.ramType = this.selectedComponents.mainboard.specs.memory_type;
                    }

                    // When selecting CPU, if mainboard selected, filter by its socket
                    if (this.currentComponentType === 'cpu' && this.selectedComponents.mainboard?.specs?.socket) {
                        filters.socket = this.selectedComponents.mainboard.specs.socket;
                    }

                    return filters;
                },

                getFilterInfo() {
                    const compat = this.getCompatibilityFilter();
                    if (compat.socket) {
                        return `Lọc theo socket: ${compat.socket}`;
                    }
                    if (compat.ramType) {
                        return `Lọc theo loại RAM: ${compat.ramType}`;
                    }
                    return null;
                },

                getActiveFilter() {
                    const cpu = this.selectedComponents.cpu;
                    const mb = this.selectedComponents.mainboard;

                    if (cpu?.specs?.socket && !mb) {
                        return `CPU socket ${cpu.specs.socket} - Mainboard sẽ được lọc tự động`;
                    }
                    if (mb?.specs?.memory_type && !this.selectedComponents.ram) {
                        return `Mainboard hỗ trợ ${mb.specs.memory_type} - RAM sẽ được lọc tự động`;
                    }
                    return null;
                },

                clearCompatibilityFilter() {
                    this.skipCompatibilityFilter = true;
                    this.fetchProducts();
                },

                openModal(type) {
                    this.currentComponentType = type;
                    this.modalOpen = true;
                    this.products = [];
                    this.currentPage = 1;
                    this.skipCompatibilityFilter = false;
                    this.clearFilters();
                    this.fetchProducts();
                    document.body.style.overflow = 'hidden';
                },

                closeModal() {
                    this.modalOpen = false;
                    this.skipCompatibilityFilter = false;
                    document.body.style.overflow = '';
                },

                clearFilters() {
                    this.filters = {
                        search: '',
                        priceRange: '',
                        sort: ''
                    };
                },

                async fetchProducts() {
                    this.loading = true;

                    const category = this.categoryMap[this.currentComponentType] || this.currentComponentType;
                    let url = `/products?category=${category}&ajax=1&page=${this.currentPage}`;

                    if (this.filters.search) {
                        url += `&search=${encodeURIComponent(this.filters.search)}`;
                    }

                    if (this.filters.priceRange) {
                        const [min, max] = this.filters.priceRange.split('-');
                        if (min) url += `&min_price=${min}`;
                        if (max) url += `&max_price=${max}`;
                    }

                    if (this.filters.sort) {
                        url += `&sort=${this.filters.sort}`;
                    }

                    // Apply compatibility filters
                    const compatFilters = this.getCompatibilityFilter();
                    if (compatFilters.socket) {
                        // Filter by socket in search
                        url += `&socket_filter=${encodeURIComponent(compatFilters.socket)}`;
                    }
                    if (compatFilters.ramType) {
                        url += `&ram_type_filter=${encodeURIComponent(compatFilters.ramType)}`;
                    }

                    try {
                        const response = await fetch(url, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (!response.ok) throw new Error('Network error');

                        const data = await response.json();
                        let products = data.data || data.products || data;

                        // Client-side filtering for compatibility
                        if (compatFilters.socket && Array.isArray(products)) {
                            products = products.filter(p =>
                                p.specs?.socket === compatFilters.socket
                            );
                        }
                        if (compatFilters.ramType && Array.isArray(products)) {
                            products = products.filter(p =>
                                p.specs?.type === compatFilters.ramType
                            );
                        }

                        this.products = products;
                        this.totalPages = data.last_page || 1;
                        this.currentPage = data.current_page || 1;
                    } catch (error) {
                        console.error('Error fetching products:', error);
                        this.products = [];
                    } finally {
                        this.loading = false;
                    }
                },

                isProductSelected(product) {
                    const current = this.selectedComponents[this.currentComponentType];
                    return current?.id === product.id;
                },

                selectProduct(product) {
                    if (product.stock <= 0) {
                        alert('Sản phẩm này đã hết hàng!');
                        return;
                    }

                    this.selectedComponents[this.currentComponentType] = {
                        id: product.id,
                        name: product.name,
                        price: product.sale_price || product.price,
                        image: product.image_url,
                        specs: product.specs || {}
                    };
                    this.save();
                    this.checkCompatibility();
                    this.closeModal();
                },

                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                        this.fetchProducts();
                    }
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                        this.fetchProducts();
                    }
                },

                getComponentName(type) {
                    const names = {
                        'cpu': 'CPU - Bộ vi xử lý',
                        'gpu': 'VGA - Card màn hình',
                        'mainboard': 'Mainboard',
                        'ram': 'RAM',
                        'ssd': 'SSD',
                        'psu': 'PSU - Nguồn',
                        'case': 'Case - Vỏ máy',
                        'cooler': 'Tản nhiệt'
                    };
                    return names[type] || type;
                },

                getComponentIcon(type) {
                    const icons = {
                        'cpu': '🔲',
                        'gpu': '🎮',
                        'mainboard': '🔌',
                        'ram': '💾',
                        'ssd': '💿',
                        'psu': '⚡',
                        'case': '🖥️',
                        'cooler': '❄️'
                    };
                    return icons[type] || '📦';
                },

                checkCompatibility() {
                    this.compatibilityMessages = [];
                    const cpu = this.selectedComponents.cpu;
                    const mainboard = this.selectedComponents.mainboard;
                    const ram = this.selectedComponents.ram;

                    // Check CPU vs Mainboard (Socket)
                    if (cpu && mainboard) {
                        const cpuSocket = cpu.specs?.socket;
                        const mbSocket = mainboard.specs?.socket;

                        if (cpuSocket && mbSocket && cpuSocket !== mbSocket) {
                            this.compatibilityMessages.push({
                                type: 'error',
                                text: `❌ CPU socket (${cpuSocket}) không khớp với Mainboard (${mbSocket}). Vui lòng chọn lại!`
                            });
                        }
                    }

                    // Check RAM vs Mainboard (RAM Type)
                    if (ram && mainboard) {
                        const ramType = ram.specs?.type;
                        const mbRamSupport = mainboard.specs?.memory_type;

                        if (ramType && mbRamSupport && !mbRamSupport.includes(ramType) && ramType !== mbRamSupport) {
                            this.compatibilityMessages.push({
                                type: 'error',
                                text: `❌ RAM (${ramType}) không tương thích với Mainboard (hỗ trợ ${mbRamSupport}). Vui lòng chọn lại!`
                            });
                        }
                    }

                    // Info messages
                    if (cpu && !mainboard) {
                        this.compatibilityMessages.push({
                            type: 'info',
                            text: `ℹ️ CPU socket ${cpu.specs?.socket || 'N/A'} - Khi chọn Mainboard sẽ tự động lọc theo socket này`
                        });
                    }

                    if (mainboard && !ram) {
                        this.compatibilityMessages.push({
                            type: 'info',
                            text: `ℹ️ Mainboard hỗ trợ ${mainboard.specs?.memory_type || 'N/A'} - Khi chọn RAM sẽ tự động lọc theo loại này`
                        });
                    }
                },

                get componentCount() {
                    return Object.values(this.selectedComponents).filter(c => c !== null).length;
                },

                get totalPrice() {
                    return Object.values(this.selectedComponents)
                        .filter(c => c !== null)
                        .reduce((sum, c) => sum + parseFloat(c.price || 0), 0);
                },

                get canAddToCart() {
                    const hasRequired = this.selectedComponents.cpu &&
                        this.selectedComponents.gpu &&
                        this.selectedComponents.mainboard &&
                        this.selectedComponents.ram;
                    const noErrors = this.compatibilityMessages.filter(m => m.type === 'error').length === 0;
                    return hasRequired && noErrors;
                },

                removeComponent(type) {
                    this.selectedComponents[type] = null;
                    this.save();
                    this.checkCompatibility();
                },

                resetBuild() {
                    if (confirm('Bạn có chắc muốn xóa toàn bộ build?')) {
                        this.selectedComponents = {
                            cpu: null,
                            mainboard: null,
                            gpu: null,
                            ram: null,
                            ssd: null,
                            psu: null,
                            case: null,
                            cooler: null
                        };
                        this.save();
                        this.checkCompatibility();
                    }
                },

                async addAllToCart() {
                    if (!this.canAddToCart) {
                        alert('Vui lòng giải quyết các vấn đề tương thích trước khi thêm vào giỏ hàng.');
                        return;
                    }

                    const components = Object.values(this.selectedComponents).filter(c => c !== null);

                    for (const component of components) {
                        try {
                            const response = await fetch(`/cart/add/${component.id}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({ quantity: 1 })
                            });

                            if (!response.ok) {
                                throw new Error('Failed to add to cart');
                            }
                        } catch (error) {
                            console.error('Error adding to cart:', error);
                        }
                    }

                    // Clear build after adding to cart
                    this.selectedComponents = {
                        cpu: null, mainboard: null, gpu: null, ram: null,
                        ssd: null, psu: null, case: null, cooler: null
                    };
                    this.save();

                    window.location.href = '{{ route("cart.index") }}';
                },

                save() {
                    localStorage.setItem('pcBuild', JSON.stringify(this.selectedComponents));
                },

                formatPrice(price) {
                    return new Intl.NumberFormat('vi-VN').format(price || 0);
                }
            }
        }
    </script>
@endsection