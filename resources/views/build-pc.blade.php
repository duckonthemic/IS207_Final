@extends('layouts.app')

@section('title', 'Tự Build PC - Tùy chỉnh linh kiện')

@section('content')
<div class="bg-gray-50 min-h-screen" x-data="pcBuilder()">
    <div class="container mx-auto px-4 py-6">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm mb-6">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-black">Trang chủ</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-medium">Build PC</span>
        </nav>

        {{-- Header --}}
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-black text-gray-900 mb-3">
                <svg class="w-10 h-10 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                Tự Build PC
            </h1>
            <p class="text-gray-600 text-lg">Chọn từng linh kiện để tạo nên bộ PC hoàn hảo</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Component Selection --}}
            <div class="lg:col-span-2 space-y-4">
                {{-- CPU --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                            </svg>
                            <h3 class="font-bold text-lg">CPU - Bộ vi xử lý</h3>
                        </div>
                        <span class="text-red-400 text-sm font-medium">* Bắt buộc</span>
                    </div>
                    <div class="p-6">
                        <template x-if="!selectedComponents.cpu">
                            <a href="{{ route('products.index', ['category' => 'cpu']) }}" 
                               class="block border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-black hover:bg-gray-50 transition group">
                                <svg class="w-12 h-12 mx-auto text-gray-400 group-hover:text-black mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <p class="text-gray-600 group-hover:text-black font-medium">Chọn CPU</p>
                                <p class="text-sm text-gray-500 mt-1">Click để xem danh sách</p>
                            </a>
                        </template>
                        <template x-if="selectedComponents.cpu">
                            <div class="flex items-center gap-4 bg-gray-50 rounded-lg p-4">
                                <img :src="selectedComponents.cpu.image || 'https://via.placeholder.com/100'" 
                                     alt="CPU" class="w-20 h-20 object-contain bg-white rounded">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900" x-text="selectedComponents.cpu.name"></h4>
                                    <p class="text-lg font-bold text-gray-900 mt-1">
                                        <span x-text="formatPrice(selectedComponents.cpu.price)"></span>₫
                                    </p>
                                </div>
                                <button @click="removeComponent('cpu')" 
                                        class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- VGA --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                            <h3 class="font-bold text-lg">VGA - Card màn hình</h3>
                        </div>
                        <span class="text-red-400 text-sm font-medium">* Bắt buộc</span>
                    </div>
                    <div class="p-6">
                        <template x-if="!selectedComponents.gpu">
                            <a href="{{ route('products.index', ['category' => 'vga']) }}" 
                               class="block border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-black hover:bg-gray-50 transition group">
                                <svg class="w-12 h-12 mx-auto text-gray-400 group-hover:text-black mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <p class="text-gray-600 group-hover:text-black font-medium">Chọn VGA</p>
                                <p class="text-sm text-gray-500 mt-1">Click để xem danh sách</p>
                            </a>
                        </template>
                        <template x-if="selectedComponents.gpu">
                            <div class="flex items-center gap-4 bg-gray-50 rounded-lg p-4">
                                <img :src="selectedComponents.gpu.image || 'https://via.placeholder.com/100'" 
                                     alt="VGA" class="w-20 h-20 object-contain bg-white rounded">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900" x-text="selectedComponents.gpu.name"></h4>
                                    <p class="text-lg font-bold text-gray-900 mt-1">
                                        <span x-text="formatPrice(selectedComponents.gpu.price)"></span>₫
                                    </p>
                                </div>
                                <button @click="removeComponent('gpu')" 
                                        class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Mainboard --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                            </svg>
                            <h3 class="font-bold text-lg">Mainboard - Bo mạch chủ</h3>
                        </div>
                        <span class="text-red-400 text-sm font-medium">* Bắt buộc</span>
                    </div>
                    <div class="p-6">
                        <template x-if="!selectedComponents.mainboard">
                            <a href="{{ route('products.index', ['category' => 'mainboard']) }}" 
                               class="block border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-black hover:bg-gray-50 transition group">
                                <svg class="w-12 h-12 mx-auto text-gray-400 group-hover:text-black mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <p class="text-gray-600 group-hover:text-black font-medium">Chọn Mainboard</p>
                                <p class="text-sm text-gray-500 mt-1">Click để xem danh sách</p>
                            </a>
                        </template>
                        <template x-if="selectedComponents.mainboard">
                            <div class="flex items-center gap-4 bg-gray-50 rounded-lg p-4">
                                <img :src="selectedComponents.mainboard.image || 'https://via.placeholder.com/100'" 
                                     alt="Mainboard" class="w-20 h-20 object-contain bg-white rounded">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900" x-text="selectedComponents.mainboard.name"></h4>
                                    <p class="text-lg font-bold text-gray-900 mt-1">
                                        <span x-text="formatPrice(selectedComponents.mainboard.price)"></span>₫
                                    </p>
                                </div>
                                <button @click="removeComponent('mainboard')" 
                                        class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- RAM --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                            </svg>
                            <h3 class="font-bold text-lg">RAM - Bộ nhớ</h3>
                        </div>
                        <span class="text-red-400 text-sm font-medium">* Bắt buộc</span>
                    </div>
                    <div class="p-6">
                        <template x-if="!selectedComponents.ram">
                            <a href="{{ route('products.index', ['category' => 'ram']) }}" 
                               class="block border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-black hover:bg-gray-50 transition group">
                                <svg class="w-12 h-12 mx-auto text-gray-400 group-hover:text-black mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <p class="text-gray-600 group-hover:text-black font-medium">Chọn RAM</p>
                                <p class="text-sm text-gray-500 mt-1">Click để xem danh sách</p>
                            </a>
                        </template>
                        <template x-if="selectedComponents.ram">
                            <div class="flex items-center gap-4 bg-gray-50 rounded-lg p-4">
                                <img :src="selectedComponents.ram.image || 'https://via.placeholder.com/100'" 
                                     alt="RAM" class="w-20 h-20 object-contain bg-white rounded">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900" x-text="selectedComponents.ram.name"></h4>
                                    <p class="text-lg font-bold text-gray-900 mt-1">
                                        <span x-text="formatPrice(selectedComponents.ram.price)"></span>₫
                                    </p>
                                </div>
                                <button @click="removeComponent('ram')" 
                                        class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- SSD --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                            <h3 class="font-bold text-lg">SSD - Ổ cứng</h3>
                        </div>
                        <span class="text-gray-400 text-sm font-medium">Tùy chọn</span>
                    </div>
                    <div class="p-6">
                        <template x-if="!selectedComponents.ssd">
                            <a href="{{ route('products.index', ['category' => 'ssd']) }}" 
                               class="block border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-black hover:bg-gray-50 transition group">
                                <svg class="w-12 h-12 mx-auto text-gray-400 group-hover:text-black mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <p class="text-gray-600 group-hover:text-black font-medium">Chọn SSD</p>
                                <p class="text-sm text-gray-500 mt-1">Click để xem danh sách</p>
                            </a>
                        </template>
                        <template x-if="selectedComponents.ssd">
                            <div class="flex items-center gap-4 bg-gray-50 rounded-lg p-4">
                                <img :src="selectedComponents.ssd.image || 'https://via.placeholder.com/100'" 
                                     alt="SSD" class="w-20 h-20 object-contain bg-white rounded">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900" x-text="selectedComponents.ssd.name"></h4>
                                    <p class="text-lg font-bold text-gray-900 mt-1">
                                        <span x-text="formatPrice(selectedComponents.ssd.price)"></span>₫
                                    </p>
                                </div>
                                <button @click="removeComponent('ssd')" 
                                        class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- PSU --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <h3 class="font-bold text-lg">PSU - Nguồn</h3>
                        </div>
                        <span class="text-gray-400 text-sm font-medium">Tùy chọn</span>
                    </div>
                    <div class="p-6">
                        <template x-if="!selectedComponents.psu">
                            <a href="{{ route('products.index', ['category' => 'psu']) }}" 
                               class="block border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-black hover:bg-gray-50 transition group">
                                <svg class="w-12 h-12 mx-auto text-gray-400 group-hover:text-black mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <p class="text-gray-600 group-hover:text-black font-medium">Chọn PSU</p>
                                <p class="text-sm text-gray-500 mt-1">Click để xem danh sách</p>
                            </a>
                        </template>
                        <template x-if="selectedComponents.psu">
                            <div class="flex items-center gap-4 bg-gray-50 rounded-lg p-4">
                                <img :src="selectedComponents.psu.image || 'https://via.placeholder.com/100'" 
                                     alt="PSU" class="w-20 h-20 object-contain bg-white rounded">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900" x-text="selectedComponents.psu.name"></h4>
                                    <p class="text-lg font-bold text-gray-900 mt-1">
                                        <span x-text="formatPrice(selectedComponents.psu.price)"></span>₫
                                    </p>
                                </div>
                                <button @click="removeComponent('psu')" 
                                        class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Case --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <h3 class="font-bold text-lg">Case - Vỏ máy</h3>
                        </div>
                        <span class="text-gray-400 text-sm font-medium">Tùy chọn</span>
                    </div>
                    <div class="p-6">
                        <template x-if="!selectedComponents.case">
                            <a href="{{ route('products.index', ['category' => 'case']) }}" 
                               class="block border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-black hover:bg-gray-50 transition group">
                                <svg class="w-12 h-12 mx-auto text-gray-400 group-hover:text-black mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <p class="text-gray-600 group-hover:text-black font-medium">Chọn Case</p>
                                <p class="text-sm text-gray-500 mt-1">Click để xem danh sách</p>
                            </a>
                        </template>
                        <template x-if="selectedComponents.case">
                            <div class="flex items-center gap-4 bg-gray-50 rounded-lg p-4">
                                <img :src="selectedComponents.case.image || 'https://via.placeholder.com/100'" 
                                     alt="Case" class="w-20 h-20 object-contain bg-white rounded">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900" x-text="selectedComponents.case.name"></h4>
                                    <p class="text-lg font-bold text-gray-900 mt-1">
                                        <span x-text="formatPrice(selectedComponents.case.price)"></span>₫
                                    </p>
                                </div>
                                <button @click="removeComponent('case')" 
                                        class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Summary Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg border-2 border-black sticky top-24">
                    <div class="bg-black text-white px-6 py-4">
                        <h3 class="font-black text-xl">Tổng Quan Build</h3>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        {{-- Component Count --}}
                        <div class="flex items-center justify-between pb-4 border-b">
                            <span class="text-gray-600">Linh kiện đã chọn</span>
                            <span class="font-bold text-xl" x-text="componentCount"></span>
                        </div>

                        {{-- Total Price --}}
                        <div class="bg-gray-900 text-white rounded-lg p-6 text-center">
                            <div class="text-sm text-gray-400 mb-2">Tổng giá trị</div>
                            <div class="text-3xl font-black" x-text="formatPrice(totalPrice) + '₫'"></div>
                        </div>

                        {{-- Actions --}}
                        <template x-if="canAddToCart">
                            <button @click="addAllToCart()" 
                                    class="w-full bg-black hover:bg-gray-800 text-white font-bold py-4 rounded-lg transition">
                                Thêm Tất Cả Vào Giỏ
                            </button>
                        </template>
                        <template x-if="!canAddToCart">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-sm text-yellow-800">
                                <div class="font-semibold mb-1">⚠️ Chưa đủ linh kiện</div>
                                <div class="text-xs">Vui lòng chọn CPU, VGA, Mainboard và RAM</div>
                            </div>
                        </template>

                        <button @click="resetBuild()" 
                                class="w-full border-2 border-gray-300 text-gray-700 hover:border-black hover:text-black font-bold py-3 rounded-lg transition">
                            Đặt Lại
                        </button>

                        {{-- Info --}}
                        <div class="bg-blue-50 rounded-lg p-4 text-sm text-blue-900">
                            <div class="font-semibold mb-2">💡 Gợi ý</div>
                            <ul class="space-y-1 text-xs">
                                <li>• Chọn CPU và Mainboard tương thích socket</li>
                                <li>• RAM phù hợp với loại hỗ trợ của Mainboard</li>
                                <li>• PSU đủ công suất cho toàn bộ hệ thống</li>
                            </ul>
                        </div>
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
            gpu: null,
            mainboard: null,
            ram: null,
            ssd: null,
            psu: null,
            case: null
        },
        
        init() {
            // Load from localStorage
            const saved = localStorage.getItem('pcBuild');
            if (saved) {
                this.selectedComponents = JSON.parse(saved);
            }

            // Check URL parameters for adding component
            const params = new URLSearchParams(window.location.search);
            if (params.has('add')) {
                const type = params.get('type');
                const data = {
                    id: parseInt(params.get('id')),
                    name: params.get('name'),
                    price: parseFloat(params.get('price')),
                    image: params.get('image')
                };
                this.selectedComponents[type] = data;
                this.save();
                // Clean URL
                window.history.replaceState({}, '', '{{ route("build-pc") }}');
            }
        },

        get componentCount() {
            return Object.values(this.selectedComponents).filter(c => c !== null).length;
        },

        get totalPrice() {
            return Object.values(this.selectedComponents)
                .filter(c => c !== null)
                .reduce((sum, c) => sum + parseFloat(c.price), 0);
        },

        get canAddToCart() {
            return this.selectedComponents.cpu && 
                   this.selectedComponents.gpu && 
                   this.selectedComponents.mainboard && 
                   this.selectedComponents.ram;
        },

        removeComponent(type) {
            this.selectedComponents[type] = null;
            this.save();
        },

        resetBuild() {
            if (confirm('Bạn có chắc muốn xóa toàn bộ build?')) {
                this.selectedComponents = {
                    cpu: null,
                    gpu: null,
                    mainboard: null,
                    ram: null,
                    ssd: null,
                    psu: null,
                    case: null
                };
                this.save();
            }
        },

        async addAllToCart() {
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

            // Redirect to cart
            window.location.href = '{{ route("cart.index") }}';
        },

        save() {
            localStorage.setItem('pcBuild', JSON.stringify(this.selectedComponents));
        },

        formatPrice(price) {
            return new Intl.NumberFormat('vi-VN').format(price);
        }
    }
}
</script>
@endsection
