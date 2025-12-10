<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'UITech - Cửa hàng linh kiện máy tính')</title>

    {{-- Google Fonts - Barlow (Vietnamese Support) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>

<body class="bg-gray-50 text-black antialiased font-sans" x-data="app()">
    @include('partials.header')

    <main class="min-h-screen">
        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="fixed top-24 right-4 z-50 bg-white border-l-4 border-green-500 text-gray-800 px-6 py-4 shadow-xl rounded-r-lg transform transition-all duration-300 hover:scale-105">
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 rounded-full p-1">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm">Thành công!</p>
                        <p class="text-sm text-gray-600">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="ml-4 text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="fixed top-24 right-4 z-50 bg-white border-l-4 border-red-500 text-gray-800 px-6 py-4 shadow-xl rounded-r-lg transform transition-all duration-300 hover:scale-105">
                <div class="flex items-center gap-3">
                    <div class="bg-red-100 rounded-full p-1">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm">Lỗi!</p>
                        <p class="text-sm text-gray-600">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="ml-4 text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="fixed top-36 right-4 z-50 bg-white border-l-4 border-red-500 text-gray-800 px-6 py-4 shadow-xl rounded-r-lg transform transition-all duration-300 hover:scale-105">
                <div class="flex items-start gap-3">
                    <div class="bg-red-100 rounded-full p-1 mt-1">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm mb-1">Vui lòng kiểm tra lại:</p>
                        <ul class="list-disc list-inside text-sm text-gray-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button @click="show = false" class="ml-4 text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if (isset($header))
            <header class="bg-white border-b border-gray-100 shadow-sm">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        @if(isset($slot) && $slot->isNotEmpty())
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    {{-- Enhanced Comparison Floating Widget --}}
    <div x-show="compareList.length > 0" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-full opacity-0"
        class="fixed bottom-4 left-1/2 -translate-x-1/2 z-50 bg-white rounded-2xl shadow-2xl border border-gray-200 p-4 max-w-2xl w-full mx-4"
        style="display: none;">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <span class="font-bold text-gray-900">So sánh sản phẩm</span>
                    <span class="text-sm text-gray-500 ml-1">(<span x-text="compareList.length"></span>/4)</span>
                </div>
            </div>
            <button @click="compareList = []; localStorage.removeItem('compareList')"
                class="text-gray-400 hover:text-red-500 transition-colors p-1" title="Xóa tất cả">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
            </button>
        </div>

        {{-- Products Grid --}}
        <div class="flex items-center gap-3 mb-4">
            <template x-for="product in compareList" :key="product.id">
                <div class="relative group flex-shrink-0">
                    <div
                        class="w-20 h-20 bg-gray-50 border border-gray-200 rounded-xl p-2 transition-all group-hover:border-gray-400">
                        <img :src="product.image" :alt="product.name" class="w-full h-full object-contain">
                    </div>
                    <button @click="toggleCompare(product)"
                        class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all shadow-md hover:bg-red-600 hover:scale-110">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    {{-- Product Name Tooltip --}}
                    <div
                        class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none max-w-[150px] truncate">
                        <span x-text="product.name"></span>
                    </div>
                </div>
            </template>

            {{-- Add More Slots --}}
            <template x-for="i in (4 - compareList.length)" :key="'empty-' + i">
                <a href="{{ route('products.index') }}"
                    class="w-20 h-20 border-2 border-dashed border-gray-300 rounded-xl flex items-center justify-center text-gray-300 hover:border-gray-400 hover:text-gray-400 transition-colors flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </a>
            </template>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3">
            <a :href="'/products/compare?ids=' + compareList.map(p => p.id).join(',')"
                class="flex-1 bg-gray-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                So sánh ngay
            </a>
            <a href="{{ route('products.index') }}"
                class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                + Thêm
            </a>
        </div>
    </div>

    <script>
        function app() {
            return {
                compareList: [],
                init() {
                    const saved = localStorage.getItem('compareList');
                    if (saved) {
                        this.compareList = JSON.parse(saved);
                    }

                    window.addEventListener('toggle-compare', (e) => {
                        this.toggleCompare(e.detail);
                    });
                },
                toggleCompare(product) {
                    const index = this.compareList.findIndex(p => p.id === product.id);
                    if (index > -1) {
                        this.compareList.splice(index, 1);
                    } else {
                        if (this.compareList.length >= 4) {
                            alert('Chỉ có thể so sánh tối đa 4 sản phẩm');
                            return;
                        }
                        // Check category consistency
                        if (this.compareList.length > 0 && this.compareList[0].category !== product.category) {
                            if (confirm('Bạn đang so sánh sản phẩm khác danh mục. Bạn có muốn xóa danh sách cũ để thêm sản phẩm này?')) {
                                this.compareList = [product];
                            } else {
                                return;
                            }
                        } else {
                            this.compareList.push(product);
                        }
                    }
                    localStorage.setItem('compareList', JSON.stringify(this.compareList));
                }
            }
        }
    </script>

    @include('partials.footer')

    @stack('scripts')
</body>

</html>