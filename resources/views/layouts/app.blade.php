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
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js --}}
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm">Lỗi!</p>
                        <p class="text-sm text-gray-600">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="ml-4 text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
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

    {{-- Comparison Floating Bar --}}
    <div x-show="compareList.length > 0" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         class="fixed bottom-0 inset-x-0 z-40 bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] p-4"
         style="display: none;">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <span class="font-bold text-gray-900">So sánh (<span x-text="compareList.length"></span>/3)</span>
                <div class="flex gap-2">
                    <template x-for="product in compareList" :key="product.id">
                        <div class="relative group">
                            <img :src="product.image" class="w-12 h-12 object-contain border border-gray-200 rounded bg-white p-1">
                            <button @click="toggleCompare(product)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-0.5 opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
            <div class="flex gap-3">
                <button @click="compareList = []; localStorage.removeItem('compareList')" class="text-gray-500 hover:text-red-500 text-sm font-medium">Xóa tất cả</button>
                <a :href="'/products/compare?ids=' + compareList.map(p => p.id).join(',')" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition-colors shadow-lg">
                    So sánh ngay
                </a>
            </div>
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
                    if (this.compareList.length >= 3) {
                        alert('Chỉ có thể so sánh tối đa 3 sản phẩm');
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
