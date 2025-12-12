@extends('layouts.app')

@section('title', 'Tự Build PC - Tùy chỉnh linh kiện')

@section('content')
    <div class="bg-gray-50 min-h-screen" x-data="pcBuilder()" x-init="init()">
        <div class="container mx-auto px-4 py-8 max-w-7xl">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm mb-6">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-900 transition">Trang chủ</a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-900 font-medium">Build PC</span>
            </nav>

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Tự Build PC</h1>
                <p class="text-gray-600">Chọn từng linh kiện để tạo nên bộ PC hoàn hảo của bạn</p>
            </div>

            <!-- Compatibility Alerts - 3 Levels -->
            <!-- Level 1: Errors (Red) - Cannot build -->
            <template x-if="compatibilityErrors.length > 0">
                <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center gap-2 font-semibold text-red-800 mb-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        Lỗi tương thích (Không thể lắp ráp)
                    </div>
                    <ul class="text-sm text-red-700 space-y-1">
                        <template x-for="error in compatibilityErrors" :key="error">
                            <li class="flex items-start gap-2">
                                <span class="text-red-500 mt-0.5">✕</span>
                                <span x-text="error"></span>
                            </li>
                        </template>
                    </ul>
                </div>
            </template>

            <!-- Level 2: Warnings (Yellow) - Can build but not optimal -->
            <template x-if="compatibilityWarnings.length > 0">
                <div class="mb-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center gap-2 font-semibold text-yellow-800 mb-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Cảnh báo hiệu năng (Có thể lắp nhưng không tối ưu)
                    </div>
                    <ul class="text-sm text-yellow-700 space-y-1">
                        <template x-for="warn in compatibilityWarnings" :key="warn">
                            <li class="flex items-start gap-2">
                                <span class="text-yellow-500 mt-0.5">⚠</span>
                                <span x-text="warn"></span>
                            </li>
                        </template>
                    </ul>
                </div>
            </template>

            <!-- Level 3: Info (Blue) - Suggestions -->
            <template x-if="compatibilityInfo.length > 0">
                <div class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center gap-2 font-semibold text-blue-800 mb-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Gợi ý tối ưu
                    </div>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <template x-for="tip in compatibilityInfo" :key="tip">
                            <li class="flex items-start gap-2">
                                <span class="text-blue-500 mt-0.5">ℹ</span>
                                <span x-text="tip"></span>
                            </li>
                        </template>
                    </ul>
                </div>
            </template>

            <!-- Info about auto-filtering -->
            <template x-if="getFilterHint()">
                <div class="mb-6 bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-700">
                    <span x-text="getFilterHint()"></span>
                </div>
            </template>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Component Selection -->
                <div class="lg:col-span-2 space-y-3">

                    @php
                        $components = [
                            ['key' => 'cpu', 'name' => 'CPU - Bộ vi xử lý', 'required' => true, 'category' => 'cpu'],
                            ['key' => 'mainboard', 'name' => 'Mainboard - Bo mạch chủ', 'required' => true, 'category' => 'mainboard'],
                            ['key' => 'gpu', 'name' => 'VGA - Card màn hình', 'required' => true, 'category' => 'vga'],
                            ['key' => 'ram', 'name' => 'RAM - Bộ nhớ', 'required' => true, 'category' => 'ram'],
                            ['key' => 'ssd', 'name' => 'SSD - Ổ cứng', 'required' => false, 'category' => 'ssd'],
                            ['key' => 'psu', 'name' => 'PSU - Nguồn', 'required' => false, 'category' => 'psu'],
                            ['key' => 'case', 'name' => 'Case - Vỏ máy', 'required' => false, 'category' => 'case'],
                            ['key' => 'cooler', 'name' => 'Cooler - Tản nhiệt', 'required' => false, 'category' => 'cooler'],
                        ];
                    @endphp

                    @foreach($components as $comp)
                        <div
                            class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                            <div class="px-5 py-4 flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <span
                                            class="text-gray-600 font-bold text-xs uppercase">{{ strtoupper(substr($comp['key'], 0, 3)) }}</span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $comp['name'] }}</h3>
                                        @if($comp['required'])
                                            <span class="text-xs text-red-500">Bắt buộc</span>
                                        @else
                                            <span class="text-xs text-gray-400">Tùy chọn</span>
                                        @endif
                                    </div>
                                </div>

                                <template x-if="!selectedComponents.{{ $comp['key'] }}">
                                    <button @click="openModal('{{ $comp['key'] }}', '{{ $comp['category'] }}')"
                                        class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition">
                                        Chọn
                                    </button>
                                </template>

                                <template x-if="selectedComponents.{{ $comp['key'] }}">
                                    <div class="flex items-center gap-4">
                                        <div class="text-right">
                                            <div class="font-semibold text-gray-900"
                                                x-text="selectedComponents.{{ $comp['key'] }}.name.substring(0, 40) + (selectedComponents.{{ $comp['key'] }}.name.length > 40 ? '...' : '')">
                                            </div>
                                            <div class="text-sm text-gray-600"
                                                x-text="formatPrice(selectedComponents.{{ $comp['key'] }}.price) + '₫'"></div>
                                            <!-- Socket/RAM info -->
                                            <div class="text-xs text-gray-500">
                                                <template
                                                    x-if="'{{ $comp['key'] }}' === 'cpu' && selectedComponents.cpu?.specs?.cpu_socket">
                                                    <span x-text="'Socket: ' + selectedComponents.cpu.specs.cpu_socket"></span>
                                                </template>
                                                <template
                                                    x-if="'{{ $comp['key'] }}' === 'mainboard' && selectedComponents.mainboard?.specs?.mb_socket">
                                                    <span
                                                        x-text="selectedComponents.mainboard.specs.mb_socket + ' | ' + (selectedComponents.mainboard.specs.mb_memory_type || '')"></span>
                                                </template>
                                                <template
                                                    x-if="'{{ $comp['key'] }}' === 'ram' && selectedComponents.ram?.specs?.ram_type">
                                                    <span x-text="selectedComponents.ram.specs.ram_type"></span>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="flex gap-1">
                                            <button @click="openModal('{{ $comp['key'] }}', '{{ $comp['category'] }}')"
                                                class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition"
                                                title="Đổi">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button @click="removeComponent('{{ $comp['key'] }}')"
                                                class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                                title="Xóa">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                <!-- Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg border border-gray-200 sticky top-24">
                        <div class="bg-gray-900 text-white px-5 py-4 rounded-t-lg">
                            <h3 class="font-bold text-lg">Tổng Quan Build</h3>
                        </div>

                        <div class="p-5 space-y-4">
                            <!-- Component Count -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                                <span class="text-gray-600">Linh kiện đã chọn</span>
                                <span class="font-bold text-xl text-gray-900" x-text="componentCount + '/8'"></span>
                            </div>

                            <!-- Selected Components List -->
                            <div class="space-y-2 pb-4 border-b border-gray-100 max-h-48 overflow-y-auto">
                                <template x-for="(comp, key) in selectedComponents" :key="key">
                                    <div x-show="comp" class="flex justify-between text-sm py-1">
                                        <span class="text-gray-500 uppercase font-medium" x-text="key"></span>
                                        <span class="font-medium text-gray-900"
                                            x-text="formatPrice(comp?.price || 0) + '₫'"></span>
                                    </div>
                                </template>
                            </div>

                            <!-- Total Price -->
                            <div class="bg-gray-50 rounded-lg p-4 text-center">
                                <div class="text-sm text-gray-600 mb-1">Tổng giá trị</div>
                                <div class="text-2xl font-bold text-gray-900" x-text="formatPrice(totalPrice) + '₫'"></div>
                            </div>

                            <!-- Actions -->
                            @auth
                                <template x-if="canAddToCart">
                                    <button @click="addAllToCart()"
                                        class="w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-3 rounded-lg transition">
                                        Thêm Tất Cả Vào Giỏ
                                    </button>
                                </template>
                            @else
                                <a href="{{ route('login') }}"
                                    class="block w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-3 rounded-lg transition text-center">
                                    Đăng nhập để mua hàng
                                </a>
                            @endauth

                            <template x-if="!canAddToCart">
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-sm text-yellow-700">
                                    <div class="font-medium mb-1">Chưa đủ linh kiện bắt buộc</div>
                                    <div class="text-xs" x-text="getMissingComponents()"></div>
                                </div>
                            </template>

                            <button @click="resetBuild()"
                                class="w-full border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium py-2.5 rounded-lg transition">
                                Đặt Lại
                            </button>

                            <!-- Compatibility Tips -->
                            <div class="bg-gray-50 rounded-lg p-4 text-sm">
                                <div class="font-medium text-gray-900 mb-2">Tương thích tự động</div>
                                <ul class="space-y-1 text-xs text-gray-600">
                                    <li>• Chọn CPU sẽ lọc Mainboard theo socket</li>
                                    <li>• Chọn Mainboard sẽ lọc RAM theo DDR</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Component Selection Modal -->
        <div x-show="modalOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-hidden" style="display: none;">

            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/50" @click="closeModal()"></div>

            <!-- Modal Content -->
            <div class="absolute inset-4 md:inset-8 lg:inset-12 bg-white rounded-lg shadow-2xl flex flex-col overflow-hidden"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">

                <!-- Modal Header -->
                <div class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold" x-text="'Chọn ' + getComponentName(currentComponentType)"></h2>
                        <p class="text-sm text-gray-400" x-show="getModalFilterInfo()" x-text="getModalFilterInfo()"></p>
                    </div>
                    <button @click="closeModal()" class="p-2 hover:bg-white/20 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="flex-1 flex overflow-hidden">
                    <!-- Filters Sidebar -->
                    <div class="w-64 bg-gray-50 border-r border-gray-200 p-4 overflow-y-auto hidden md:block">
                        <h3 class="font-semibold text-gray-900 mb-4">Bộ lọc</h3>

                        <!-- Search -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                            <input type="text" x-model="filters.search" @input.debounce.400ms="fetchProducts()"
                                placeholder="Nhập tên sản phẩm..."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                        </div>

                        <!-- Price Range -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Khoảng giá</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="price" value="" x-model="filters.priceRange"
                                        @change="fetchProducts()" class="text-gray-900 focus:ring-gray-900">
                                    <span class="text-sm text-gray-700">Tất cả</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="price" value="0-5000000" x-model="filters.priceRange"
                                        @change="fetchProducts()" class="text-gray-900 focus:ring-gray-900">
                                    <span class="text-sm text-gray-700">Dưới 5 triệu</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="price" value="5000000-10000000" x-model="filters.priceRange"
                                        @change="fetchProducts()" class="text-gray-900 focus:ring-gray-900">
                                    <span class="text-sm text-gray-700">5 - 10 triệu</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="price" value="10000000-20000000" x-model="filters.priceRange"
                                        @change="fetchProducts()" class="text-gray-900 focus:ring-gray-900">
                                    <span class="text-sm text-gray-700">10 - 20 triệu</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="price" value="20000000-" x-model="filters.priceRange"
                                        @change="fetchProducts()" class="text-gray-900 focus:ring-gray-900">
                                    <span class="text-sm text-gray-700">Trên 20 triệu</span>
                                </label>
                            </div>
                        </div>

                        <!-- Sort -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sắp xếp</label>
                            <select x-model="filters.sort" @change="fetchProducts()"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-gray-900">
                                <option value="">Mặc định</option>
                                <option value="price_asc">Giá tăng dần</option>
                                <option value="price_desc">Giá giảm dần</option>
                                <option value="name_asc">Tên A-Z</option>
                            </select>
                        </div>

                        <!-- Show all button if filtering -->
                        <button x-show="isFiltering()" @click="clearCompatibilityFilter()"
                            class="w-full text-sm text-blue-600 hover:text-blue-800 font-medium py-2 border border-blue-200 rounded-lg hover:bg-blue-50 transition">
                            Xem tất cả (bỏ lọc tương thích)
                        </button>
                    </div>

                    <!-- Products Grid -->
                    <div class="flex-1 p-4 overflow-y-auto bg-gray-50">
                        <!-- Mobile Search -->
                        <div class="md:hidden mb-4">
                            <input type="text" x-model="filters.search" @input.debounce.400ms="fetchProducts()"
                                placeholder="Tìm kiếm..."
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900">
                        </div>

                        <!-- Filter notice -->
                        <div x-show="isFiltering() && !skipCompatibilityFilter"
                            class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-3 flex items-center justify-between">
                            <span class="text-sm text-blue-800" x-text="getModalFilterInfo()"></span>
                            <button @click="clearCompatibilityFilter()"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Xem tất cả
                            </button>
                        </div>

                        <!-- Loading State -->
                        <div x-show="loading" class="flex items-center justify-center py-16">
                            <div class="animate-spin rounded-full h-10 w-10 border-4 border-gray-900 border-t-transparent">
                            </div>
                        </div>

                        <!-- Products Grid -->
                        <div x-show="!loading" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            <template x-for="product in products" :key="product.id">
                                <div @click="selectProduct(product)"
                                    :class="{'ring-2 ring-gray-900 bg-gray-100': isProductSelected(product)}"
                                    class="bg-white border border-gray-200 rounded-lg p-3 cursor-pointer hover:border-gray-400 hover:shadow-md transition group">
                                    <div class="aspect-square bg-gray-50 rounded-lg mb-2 overflow-hidden">
                                        <img :src="product.image_url || '/images/no-image.png'" :alt="product.name"
                                            class="w-full h-full object-contain group-hover:scale-105 transition-transform p-2">
                                    </div>
                                    <h4 class="font-medium text-gray-900 text-sm line-clamp-2 mb-1 min-h-[2.5rem]"
                                        x-text="product.name"></h4>

                                    <!-- Show relevant specs -->
                                    <div class="text-xs text-gray-500 mb-2">
                                        <template x-if="currentComponentType === 'cpu' && product.specs?.cpu_socket">
                                            <span x-text="'Socket: ' + product.specs.cpu_socket"></span>
                                        </template>
                                        <template x-if="currentComponentType === 'mainboard' && product.specs?.mb_socket">
                                            <span
                                                x-text="product.specs.mb_socket + (product.specs.mb_memory_type ? ' | ' + product.specs.mb_memory_type : '')"></span>
                                        </template>
                                        <template x-if="currentComponentType === 'ram' && product.specs?.ram_type">
                                            <span
                                                x-text="product.specs.ram_type + (product.specs.ram_speed ? ' ' + product.specs.ram_speed : '')"></span>
                                        </template>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-gray-900 text-sm"
                                            x-text="formatPrice(product.sale_price || product.price) + '₫'"></span>
                                    </div>
                                    <div x-show="product.sale_price && product.sale_price < product.price"
                                        class="text-xs text-gray-400 line-through"
                                        x-text="formatPrice(product.price) + '₫'"></div>

                                    <div class="mt-1 text-xs"
                                        :class="product.stock > 0 ? 'text-green-600' : 'text-red-500'">
                                        <span x-text="product.stock > 0 ? 'Còn hàng' : 'Hết hàng'"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Empty State -->
                        <div x-show="!loading && products.length === 0" class="text-center py-16">
                            <div class="text-4xl mb-3 text-gray-300">0</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Không tìm thấy sản phẩm</h3>
                            <p class="text-gray-600 text-sm mb-3">Thử thay đổi bộ lọc hoặc xem tất cả sản phẩm</p>
                            <button @click="clearCompatibilityFilter()"
                                class="text-gray-900 font-medium hover:underline text-sm">
                                Xem tất cả sản phẩm
                            </button>
                        </div>

                        <!-- Pagination -->
                        <div x-show="!loading && totalPages > 1" class="flex justify-center gap-2 mt-5">
                            <button @click="prevPage()" :disabled="currentPage === 1"
                                :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                class="px-3 py-2 border border-gray-200 rounded-lg text-sm font-medium bg-white">
                                Trước
                            </button>
                            <span class="px-3 py-2 text-sm text-gray-600">
                                <span x-text="currentPage"></span> / <span x-text="totalPages"></span>
                            </span>
                            <button @click="nextPage()" :disabled="currentPage === totalPages"
                                :class="currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                class="px-3 py-2 border border-gray-200 rounded-lg text-sm font-medium bg-white">
                                Sau
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
                compatibilityErrors: [],
                compatibilityWarnings: [],
                compatibilityInfo: [],

                // Chipset to Tier mapping (VN Market 2024-2025)
                // Tier 1: Entry, Tier 2: Mid-Range, Tier 3: High-End, Tier 4: Enthusiast
                chipsetTiers: {
                    // Intel Entry
                    'H610': 1, 'H510': 1, 'H410': 1,
                    // AMD Entry
                    'A520': 1, 'A320': 1, 'A620': 1,
                    // Intel Mid-Range
                    'B760': 2, 'B660': 2, 'B560': 2, 'B460': 2,
                    // AMD Mid-Range
                    'B650': 2, 'B650E': 2, 'B550': 2, 'B450': 2,
                    // Intel High-End
                    'Z790': 3, 'Z690': 3, 'H770': 3, 'Z590': 3,
                    // AMD High-End
                    'X670': 3, 'X570': 3, 'X470': 3,
                    // Enthusiast
                    'X670E': 4,
                },

                // Case form factor compatibility
                caseMbCompatibility: {
                    'Full Tower': ['E-ATX', 'ATX', 'mATX', 'Mini-ITX'],
                    'Mid Tower': ['E-ATX', 'ATX', 'mATX', 'Mini-ITX'],
                    'Mini Tower': ['mATX', 'Mini-ITX'],
                    'SFF': ['Mini-ITX'],
                },

                // Modal state
                modalOpen: false,
                currentComponentType: '',
                currentCategory: '',
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

                init() {
                    // Load from localStorage
                    const saved = localStorage.getItem('pcBuild');
                    if (saved) {
                        try {
                            const parsed = JSON.parse(saved);
                            // Only load if data is valid
                            if (parsed && typeof parsed === 'object') {
                                Object.keys(this.selectedComponents).forEach(key => {
                                    if (parsed[key] && parsed[key].id) {
                                        this.selectedComponents[key] = parsed[key];
                                    }
                                });
                            }
                        } catch (e) {
                            console.error('Error loading saved build:', e);
                            localStorage.removeItem('pcBuild');
                        }
                    }
                    this.checkCompatibility();
                },

                // Check if we should apply compatibility filter
                isFiltering() {
                    if (this.skipCompatibilityFilter) return false;
                    return this.getCompatibilityFilter() !== null;
                },

                // Get compatibility filter based on current selection
                getCompatibilityFilter() {
                    // When selecting Mainboard, filter by CPU socket
                    if (this.currentComponentType === 'mainboard' && this.selectedComponents.cpu?.specs?.cpu_socket) {
                        return { type: 'socket', value: this.selectedComponents.cpu.specs.cpu_socket };
                    }

                    // When selecting RAM, filter by Mainboard memory type
                    if (this.currentComponentType === 'ram' && this.selectedComponents.mainboard?.specs?.mb_memory_type) {
                        return { type: 'ram', value: this.selectedComponents.mainboard.specs.mb_memory_type };
                    }

                    // When selecting CPU, if mainboard is already selected, filter by its socket
                    if (this.currentComponentType === 'cpu' && this.selectedComponents.mainboard?.specs?.mb_socket) {
                        return { type: 'socket', value: this.selectedComponents.mainboard.specs.mb_socket };
                    }

                    return null;
                },

                getModalFilterInfo() {
                    const filter = this.getCompatibilityFilter();
                    if (!filter || this.skipCompatibilityFilter) return null;

                    if (filter.type === 'socket') {
                        return `Đang lọc theo socket: ${filter.value}`;
                    }
                    if (filter.type === 'ram') {
                        return `Đang lọc theo RAM: ${filter.value}`;
                    }
                    return null;
                },

                getFilterHint() {
                    const cpu = this.selectedComponents.cpu;
                    const mb = this.selectedComponents.mainboard;

                    if (cpu?.specs?.cpu_socket && !mb) {
                        return `CPU socket ${cpu.specs.cpu_socket} đã chọn - Mainboard sẽ được lọc tự động theo socket này`;
                    }
                    if (mb?.specs?.mb_memory_type && !this.selectedComponents.ram) {
                        return `Mainboard hỗ trợ ${mb.specs.mb_memory_type} - RAM sẽ được lọc tự động theo loại này`;
                    }
                    return null;
                },

                clearCompatibilityFilter() {
                    this.skipCompatibilityFilter = true;
                    this.currentPage = 1;
                    this.fetchProducts();
                },

                openModal(type, category) {
                    this.currentComponentType = type;
                    this.currentCategory = category;
                    this.modalOpen = true;
                    this.products = [];
                    this.currentPage = 1;
                    this.skipCompatibilityFilter = false;
                    this.filters = { search: '', priceRange: '', sort: '' };
                    this.fetchProducts();
                    document.body.style.overflow = 'hidden';
                },

                closeModal() {
                    this.modalOpen = false;
                    this.skipCompatibilityFilter = false;
                    document.body.style.overflow = '';
                },

                async fetchProducts() {
                    this.loading = true;

                    let url = `/products?category=${this.currentCategory}&ajax=1&page=${this.currentPage}&per_page=16`;

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

                    // Apply compatibility filters on server side
                    const compatFilter = this.getCompatibilityFilter();
                    if (compatFilter && !this.skipCompatibilityFilter) {
                        if (compatFilter.type === 'socket') {
                            url += `&socket_filter=${encodeURIComponent(compatFilter.value)}`;
                        } else if (compatFilter.type === 'ram') {
                            url += `&ram_type_filter=${encodeURIComponent(compatFilter.value)}`;
                        }
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
                        let products = data.data || data.products || [];

                        // Client-side filtering as backup if server doesn't filter
                        if (compatFilter && !this.skipCompatibilityFilter && Array.isArray(products)) {
                            if (compatFilter.type === 'socket') {
                                const socketValue = compatFilter.value;
                                products = products.filter(p => {
                                    const socket = p.specs?.cpu_socket || p.specs?.mb_socket;
                                    return socket === socketValue;
                                });
                            } else if (compatFilter.type === 'ram') {
                                const ramValue = compatFilter.value;
                                products = products.filter(p => {
                                    const ramType = p.specs?.ram_type || p.specs?.mb_memory_type;
                                    return ramType && ramType.includes(ramValue);
                                });
                            }
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

                checkCompatibility() {
                    // Reset all alerts
                    this.compatibilityErrors = [];
                    this.compatibilityWarnings = [];
                    this.compatibilityInfo = [];

                    const cpu = this.selectedComponents.cpu;
                    const mainboard = this.selectedComponents.mainboard;
                    const ram = this.selectedComponents.ram;
                    const gpu = this.selectedComponents.gpu;
                    const psu = this.selectedComponents.psu;
                    const pcCase = this.selectedComponents.case;
                    const cooler = this.selectedComponents.cooler;

                    // ============================================
                    // LAYER 1: PHYSICAL COMPATIBILITY (ERRORS)
                    // ============================================

                    // 1.1 CPU Socket vs Mainboard Socket
                    if (cpu && mainboard) {
                        const cpuSocket = cpu.specs?.cpu_socket;
                        const mbSocket = mainboard.specs?.mb_socket;
                        if (cpuSocket && mbSocket && cpuSocket !== mbSocket) {
                            this.compatibilityErrors.push(`CPU socket (${cpuSocket}) không khớp với Mainboard socket (${mbSocket})`);
                        }
                    }

                    // 1.2 RAM Type vs Mainboard (CHECK BEFORE TIER!)
                    if (ram && mainboard) {
                        const ramType = ram.specs?.ram_type;
                        const mbRamSupport = mainboard.specs?.mb_memory_type;
                        if (ramType && mbRamSupport && !mbRamSupport.includes(ramType) && ramType !== mbRamSupport) {
                            this.compatibilityErrors.push(`RAM (${ramType}) không tương thích với Mainboard (hỗ trợ ${mbRamSupport})`);
                        }
                    }

                    // 1.3 Mainboard Form Factor vs Case
                    if (mainboard && pcCase) {
                        const mbFormFactor = mainboard.specs?.mb_form_factor;
                        let caseMbSupport = pcCase.specs?.case_motherboard_support;
                        const caseType = pcCase.specs?.case_type;

                        if (mbFormFactor) {
                            // Try case specs first
                            if (caseMbSupport) {
                                if (!Array.isArray(caseMbSupport)) caseMbSupport = [caseMbSupport];
                                if (!caseMbSupport.includes(mbFormFactor)) {
                                    this.compatibilityErrors.push(`Mainboard ${mbFormFactor} không lắp vừa Case (hỗ trợ: ${caseMbSupport.join(', ')})`);
                                }
                            } else if (caseType && this.caseMbCompatibility[caseType]) {
                                // Fallback to case type mapping
                                if (!this.caseMbCompatibility[caseType].includes(mbFormFactor)) {
                                    this.compatibilityErrors.push(`Mainboard ${mbFormFactor} không lắp vừa Case ${caseType}`);
                                }
                            }
                        }
                    }

                    // 1.4 GPU Length vs Case
                    if (gpu && pcCase) {
                        const gpuLength = parseInt(gpu.specs?.gpu_length_mm) || 0;
                        const caseMaxGpu = parseInt(pcCase.specs?.case_gpu_length) || 0;
                        if (gpuLength > 0 && caseMaxGpu > 0 && gpuLength > caseMaxGpu) {
                            this.compatibilityErrors.push(`GPU dài ${gpuLength}mm, Case chỉ hỗ trợ tối đa ${caseMaxGpu}mm`);
                        }
                    }

                    // 1.5 Cooler Height vs Case (Air cooler)
                    if (cooler && pcCase) {
                        const coolerType = cooler.specs?.cooler_type;
                        if (coolerType === 'Air') {
                            const coolerHeight = parseInt(cooler.specs?.cooler_height) || 0;
                            const caseMaxCooler = parseInt(pcCase.specs?.case_cooler_height) || 0;
                            if (coolerHeight > 0 && caseMaxCooler > 0 && coolerHeight > caseMaxCooler) {
                                this.compatibilityErrors.push(`Tản nhiệt cao ${coolerHeight}mm, Case chỉ hỗ trợ tối đa ${caseMaxCooler}mm`);
                            }
                        }
                        // 1.6 AIO Radiator vs Case
                        if (coolerType === 'Liquid') {
                            const radiatorSize = parseInt(cooler.specs?.cooler_radiator) || 0;
                            const caseRadiatorSupport = pcCase.specs?.case_radiator_support || '';
                            if (radiatorSize > 0 && caseRadiatorSupport) {
                                const matches = caseRadiatorSupport.match(/(\d+)mm/g);
                                const supportedSizes = matches ? matches.map(m => parseInt(m)) : [];
                                const maxSupported = supportedSizes.length > 0 ? Math.max(...supportedSizes) : 0;
                                if (maxSupported > 0 && radiatorSize > maxSupported) {
                                    this.compatibilityErrors.push(`Radiator ${radiatorSize}mm không hỗ trợ, Case chỉ lắp tối đa ${maxSupported}mm`);
                                }
                            }
                        }
                    }

                    // ============================================
                    // LAYER 2: PERFORMANCE/BOTTLENECK (WARNINGS)
                    // ============================================
                    if (cpu && mainboard) {
                        const cpuTier = cpu.tier || this.inferCpuTier(cpu.name);
                        const mbTier = mainboard.tier || this.inferMainboardTier(mainboard.specs?.mb_chipset);

                        if (cpuTier && mbTier) {
                            if (cpuTier > mbTier) {
                                this.compatibilityWarnings.push(`CPU cao cấp (Tier ${cpuTier}) ghép với Mainboard entry-level (Tier ${mbTier}) có thể gây nghẽn cổ chai do VRM yếu`);
                            }
                            if (mbTier > cpuTier + 1) {
                                this.compatibilityInfo.push(`Mainboard (Tier ${mbTier}) cao cấp hơn nhiều so với CPU (Tier ${cpuTier}) - có thể tối ưu chi phí`);
                            }
                        }
                    }

                    // ============================================
                    // LAYER 3: POWER CONSUMPTION (ERRORS + INFO)
                    // ============================================
                    if (psu) {
                        const psuWattage = parseInt(psu.specs?.psu_wattage) || 0;
                        if (psuWattage > 0) {
                            const totalTdp = this.calculateTotalTdp();
                            const requiredWattage = Math.ceil(totalTdp * 1.2);
                            const recommendedWattage = Math.ceil(totalTdp * 1.3);

                            if (psuWattage < requiredWattage) {
                                this.compatibilityErrors.push(`Nguồn ${psuWattage}W không đủ! Cần tối thiểu ${requiredWattage}W (TDP: ${totalTdp}W + 20% headroom)`);
                            } else if (psuWattage < recommendedWattage) {
                                this.compatibilityInfo.push(`Nguồn ${psuWattage}W đủ dùng nhưng gần giới hạn. Khuyến nghị ${recommendedWattage}W+`);
                            }

                            // Check GPU recommended PSU
                            if (gpu) {
                                const gpuRecommendedPsu = parseInt(gpu.specs?.gpu_recommended_psu) || 0;
                                if (gpuRecommendedPsu > 0 && psuWattage < gpuRecommendedPsu) {
                                    this.compatibilityInfo.push(`GPU khuyến nghị nguồn ${gpuRecommendedPsu}W, bạn đang dùng ${psuWattage}W`);
                                }

                                // Check PCIe connectors
                                const gpuPowerConnectors = gpu.specs?.gpu_power_connectors || '';
                                const psuPcie8pin = parseInt(psu.specs?.psu_pcie_8pin) || 0;
                                const psu12vhpwr = parseInt(psu.specs?.psu_12vhpwr) || 0;

                                if (gpuPowerConnectors) {
                                    const match8pin = gpuPowerConnectors.match(/(\d+)x\s*8-pin/i);
                                    if (match8pin) {
                                        const required8pin = parseInt(match8pin[1]);
                                        if (psuPcie8pin > 0 && psuPcie8pin < required8pin) {
                                            this.compatibilityErrors.push(`GPU cần ${required8pin}x cổng 8-pin PCIe, nguồn chỉ có ${psuPcie8pin}x`);
                                        }
                                    }
                                    if (/12VHPWR|16-pin/i.test(gpuPowerConnectors) && psu12vhpwr < 1) {
                                        this.compatibilityInfo.push(`GPU cần cổng 12VHPWR (16-pin), cần kiểm tra nguồn có adapter không`);
                                    }
                                }
                            }
                        }
                    }
                },

                // Helper: Infer CPU tier from name
                inferCpuTier(cpuName) {
                    if (!cpuName) return null;
                    if (/i9|Ryzen\s*9/i.test(cpuName)) return 4;
                    if (/i7|Ryzen\s*7/i.test(cpuName)) return 3;
                    if (/i5|Ryzen\s*5/i.test(cpuName)) return 2;
                    if (/i3|Ryzen\s*3|Pentium|Athlon/i.test(cpuName)) return 1;
                    return null;
                },

                // Helper: Infer Mainboard tier from chipset
                inferMainboardTier(chipset) {
                    if (!chipset) return null;
                    for (const [key, tier] of Object.entries(this.chipsetTiers)) {
                        if (chipset.includes(key)) return tier;
                    }
                    return null;
                },

                // Helper: Calculate total TDP
                calculateTotalTdp() {
                    let total = 0;
                    const cpu = this.selectedComponents.cpu;
                    const gpu = this.selectedComponents.gpu;

                    if (cpu?.specs?.cpu_tdp) total += parseInt(cpu.specs.cpu_tdp) || 0;
                    if (gpu?.specs?.gpu_tdp) total += parseInt(gpu.specs.gpu_tdp) || 0;

                    // Estimated other components (RAM, SSD, Fans, etc.)
                    total += 50;
                    return total;
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
                    const noErrors = this.compatibilityErrors.length === 0;
                    return hasRequired && noErrors;
                },

                getMissingComponents() {
                    const missing = [];
                    if (!this.selectedComponents.cpu) missing.push('CPU');
                    if (!this.selectedComponents.mainboard) missing.push('Mainboard');
                    if (!this.selectedComponents.gpu) missing.push('VGA');
                    if (!this.selectedComponents.ram) missing.push('RAM');
                    return 'Cần chọn: ' + missing.join(', ');
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
                        alert('Vui lòng chọn đủ linh kiện bắt buộc và giải quyết các vấn đề tương thích.');
                        return;
                    }

                    const components = Object.values(this.selectedComponents).filter(c => c !== null);
                    let successCount = 0;
                    let errorMessages = [];

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                    if (!csrfToken) {
                        alert('Lỗi: Không tìm thấy CSRF token. Vui lòng tải lại trang.');
                        return;
                    }

                    for (const component of components) {
                        if (!component.id) {
                            errorMessages.push(`${component.name}: ID không hợp lệ`);
                            continue;
                        }

                        try {
                            console.log('Adding to cart:', component.id, component.name);
                            const response = await fetch(`/cart/add/${component.id}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({ quantity: 1 })
                            });

                            console.log('Response status:', response.status);

                            if (response.ok) {
                                successCount++;
                            } else if (response.status === 401) {
                                window.location.href = '{{ route("login") }}';
                                return;
                            } else if (response.status === 404) {
                                errorMessages.push(`${component.name}: Sản phẩm không tồn tại (ID: ${component.id})`);
                            } else {
                                const data = await response.json().catch(() => ({}));
                                errorMessages.push(`${component.name}: ${data.error || 'Lỗi ' + response.status}`);
                            }
                        } catch (error) {
                            console.error('Error adding to cart:', component.name, error);
                            errorMessages.push(`${component.name}: Lỗi kết nối`);
                        }
                    }

                    if (errorMessages.length > 0) {
                        alert('Một số sản phẩm không thể thêm vào giỏ:\n' + errorMessages.join('\n'));
                    }

                    if (successCount > 0) {
                        this.selectedComponents = {
                            cpu: null, mainboard: null, gpu: null, ram: null,
                            ssd: null, psu: null, case: null, cooler: null
                        };
                        this.save();
                        window.location.href = '{{ route("cart.index") }}';
                    }
                },

                save() {
                    try {
                        localStorage.setItem('pcBuild', JSON.stringify(this.selectedComponents));
                    } catch (e) {
                        console.error('Error saving build:', e);
                    }
                },

                formatPrice(price) {
                    return new Intl.NumberFormat('vi-VN').format(price || 0);
                }
            }
        }
    </script>
@endsection