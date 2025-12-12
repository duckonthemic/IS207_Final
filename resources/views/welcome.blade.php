@extends('layouts.app')

@section('title', __('home.page_title'))

@section('content')
    <!-- Hero Banner Slider with Thumbnails -->
    <section class="bg-gray-100" x-data="bannerSlider()">
        <div class="container mx-auto px-4 max-w-7xl py-4">
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Main Banner Area -->
                <div class="flex-1 relative rounded-xl overflow-hidden shadow-lg">
                    <div class="relative overflow-hidden">
                        <!-- Slides Container -->
                        <div class="flex transition-transform duration-700 ease-in-out"
                            :style="'transform: translateX(-' + (currentSlide * 100) + '%)'">
                            <!-- Slide 1: PC Gaming -->
                            <div class="w-full flex-shrink-0">
                                <a href="{{ route('products.index', ['category' => 'pc-gaming']) }}" class="block">
                                    <img src="{{ asset('images/banner/banner-pc-gaming-giang-sinh.jpg') }}"
                                        alt="PC Gaming Giáng Sinh" class="w-full h-auto max-h-[450px] object-cover">
                                </a>
                            </div>
                            <!-- Slide 2: VGA -->
                            <div class="w-full flex-shrink-0">
                                <a href="{{ route('products.index', ['category' => 'vga']) }}" class="block">
                                    <img src="{{ asset('images/banner/banner-vga-giang-sinh.jpg') }}" alt="VGA Giáng Sinh"
                                        class="w-full h-auto max-h-[450px] object-cover">
                                </a>
                            </div>
                            <!-- Slide 3: PC Đồ Họa -->
                            <div class="w-full flex-shrink-0">
                                <a href="{{ route('products.index', ['category' => 'pc-design']) }}" class="block">
                                    <img src="{{ asset('images/banner/banner-pc-do-hoa-giang-sinh.jpg') }}"
                                        alt="PC Đồ Họa Giáng Sinh" class="w-full h-auto max-h-[450px] object-cover">
                                </a>
                            </div>
                        </div>

                        <!-- Navigation Arrows -->
                        <button @click="prev()"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-black/50 hover:bg-black/70 rounded-full flex items-center justify-center transition-all z-10">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </button>
                        <button @click="next()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-black/50 hover:bg-black/70 rounded-full flex items-center justify-center transition-all z-10">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>

                        <!-- Slide Counter -->
                        <div class="absolute bottom-3 right-3 bg-black/60 text-white text-sm px-3 py-1 rounded-full">
                            <span x-text="currentSlide + 1">1</span> / <span x-text="totalSlides">3</span>
                        </div>
                    </div>
                </div>

                <!-- Thumbnail Navigation (Right Side on Desktop) -->
                <div class="lg:w-48 flex lg:flex-col gap-2 overflow-x-auto lg:overflow-x-visible pb-2 lg:pb-0">
                    <!-- Thumbnail 1 -->
                    <button @click="goTo(0)"
                        :class="currentSlide === 0 ? 'ring-2 ring-blue-500 opacity-100' : 'opacity-70 hover:opacity-100'"
                        class="flex-shrink-0 w-28 lg:w-full rounded-lg overflow-hidden transition-all shadow-md">
                        <img src="{{ asset('images/banner/banner-pc-gaming-giang-sinh.jpg') }}" alt="PC Gaming"
                            class="w-full h-20 lg:h-24 object-cover">
                        <div class="bg-gray-800 text-white text-xs py-1 px-2 text-center truncate">PC Gaming</div>
                    </button>

                    <!-- Thumbnail 2 -->
                    <button @click="goTo(1)"
                        :class="currentSlide === 1 ? 'ring-2 ring-blue-500 opacity-100' : 'opacity-70 hover:opacity-100'"
                        class="flex-shrink-0 w-28 lg:w-full rounded-lg overflow-hidden transition-all shadow-md">
                        <img src="{{ asset('images/banner/banner-vga-giang-sinh.jpg') }}" alt="VGA"
                            class="w-full h-20 lg:h-24 object-cover">
                        <div class="bg-gray-800 text-white text-xs py-1 px-2 text-center truncate">Card Đồ Họa</div>
                    </button>

                    <!-- Thumbnail 3 -->
                    <button @click="goTo(2)"
                        :class="currentSlide === 2 ? 'ring-2 ring-blue-500 opacity-100' : 'opacity-70 hover:opacity-100'"
                        class="flex-shrink-0 w-28 lg:w-full rounded-lg overflow-hidden transition-all shadow-md">
                        <img src="{{ asset('images/banner/banner-pc-do-hoa-giang-sinh.jpg') }}" alt="PC Đồ Họa"
                            class="w-full h-20 lg:h-24 object-cover">
                        <div class="bg-gray-800 text-white text-xs py-1 px-2 text-center truncate">PC Đồ Họa</div>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <script>
        function bannerSlider() {
            return {
                currentSlide: 0,
                totalSlides: 3,
                autoplayInterval: null,
                init() {
                    this.startAutoplay();
                },
                startAutoplay() {
                    this.autoplayInterval = setInterval(() => {
                        this.next();
                    }, 5000);
                },
                stopAutoplay() {
                    clearInterval(this.autoplayInterval);
                },
                next() {
                    this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                },
                prev() {
                    this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
                },
                goTo(index) {
                    this.currentSlide = index;
                    this.stopAutoplay();
                    this.startAutoplay();
                }
            }
        }
    </script>

    <!-- Featured Categories Section -->
    @php
        $tabCategories = [
            ['name' => __('home.featured'), 'slug' => 'featured', 'products' => \App\Models\Product::with('category', 'images')->inRandomOrder()->limit(8)->get()],
            ['name' => 'CPU', 'slug' => 'cpu', 'products' => \App\Models\Product::whereHas('category', fn($q) => $q->where('slug', 'cpu'))->with('category', 'images')->limit(8)->get()],
            ['name' => 'VGA', 'slug' => 'vga', 'products' => \App\Models\Product::whereHas('category', fn($q) => $q->where('slug', 'vga'))->with('category', 'images')->limit(8)->get()],
            ['name' => __('home.monitor'), 'slug' => 'monitor', 'products' => \App\Models\Product::whereHas('category', fn($q) => $q->where('slug', 'monitor'))->with('category', 'images')->limit(8)->get()],
            ['name' => 'Mainboard', 'slug' => 'mainboard', 'products' => \App\Models\Product::whereHas('category', fn($q) => $q->where('slug', 'mainboard'))->with('category', 'images')->limit(8)->get()],
        ];
    @endphp
    <section class="py-12 bg-white" x-data="{ activeTab: 'featured' }">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __('home.discover_products') }}</h2>

                {{-- Category Tabs --}}
                <div class="flex flex-wrap justify-center gap-3 mt-6">
                    @foreach($tabCategories as $cat)
                        <button @click="activeTab = '{{ $cat['slug'] }}'"
                            :class="{ 'bg-gray-900 text-white shadow-lg': activeTab === '{{ $cat['slug'] }}', 'bg-gray-100 text-gray-600 hover:bg-gray-200': activeTab !== '{{ $cat['slug'] }}' }"
                            class="px-5 py-2 rounded-full font-semibold transition-all duration-300">
                            {{ $cat['name'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Tab Contents --}}
            @foreach($tabCategories as $cat)
                <div x-show="activeTab === '{{ $cat['slug'] }}'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($cat['products'] as $product)
                        <x-product-card :product="$product" />
                    @endforeach

                    @if($cat['products']->isEmpty())
                        <div class="col-span-full text-center py-12 text-gray-400">
                            <p>{{ __('home.updating_products') }}</p>
                        </div>
                    @endif
                </div>
            @endforeach

            <div class="text-center mt-10">
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center gap-2 text-gray-900 font-bold hover:text-gray-700 transition-colors">
                    {{ __('home.view_all_products') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                        </path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Flash Deals Section -->
    <section class="py-16 bg-gradient-to-r from-red-600 to-red-700" x-data="countdown()">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col md:flex-row items-center justify-between mb-10 gap-6">
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-3">
                        <span class="flex h-3 w-3 relative">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-300 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-400"></span>
                        </span>
                        <h2 class="text-3xl font-bold text-white">⚡ {{ __('home.flash_deals') }}</h2>
                    </div>

                    {{-- Countdown Timer --}}
                    <div class="flex items-center gap-2 text-white font-bold text-lg">
                        <div class="bg-white/20 backdrop-blur rounded-lg px-3 py-2 min-w-[3rem] text-center">
                            <span x-text="String(hours).padStart(2, '0')">00</span>
                        </div>
                        <span class="text-white font-bold text-xl">:</span>
                        <div class="bg-white/20 backdrop-blur rounded-lg px-3 py-2 min-w-[3rem] text-center">
                            <span x-text="String(minutes).padStart(2, '0')">00</span>
                        </div>
                        <span class="text-white font-bold text-xl">:</span>
                        <div class="bg-white/20 backdrop-blur rounded-lg px-3 py-2 min-w-[3rem] text-center">
                            <span x-text="String(seconds).padStart(2, '0')">00</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('products.index') }}"
                    class="text-white font-medium hover:text-yellow-200 flex items-center gap-1 group">
                    {{ __('home.view_all') }}
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @php
                    $flashDeals = \App\Models\Product::with('category', 'images')
                        ->where('sale_price', '>', 0)
                        ->inRandomOrder()
                        ->limit(4)
                        ->get();
                @endphp
                @forelse($flashDeals as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="col-span-full text-center py-12 text-white/70">
                        <p>{{ __('home.no_deals') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <script>
        function countdown() {
            return {
                hours: 0,
                minutes: 0,
                seconds: 0,
                endTime: new Date().setHours(24, 0, 0, 0),
                init() {
                    this.updateTimer();
                    setInterval(() => {
                        this.updateTimer();
                    }, 1000);
                },
                updateTimer() {
                    const now = new Date().getTime();
                    const distance = this.endTime - now;

                    if (distance < 0) {
                        this.endTime += 86400000;
                    }

                    this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    this.seconds = Math.floor((distance % (1000 * 60)) / 1000);
                }
            }
        }
    </script>

    <!-- Build PC CTA Banner -->
    <section class="py-16 bg-gray-900">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="lg:max-w-xl">
                    <p class="text-sm font-medium text-gray-400 uppercase tracking-wider mb-3">Công cụ Build PC</p>
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Xây dựng PC trong mơ của bạn</h2>
                    <p class="text-gray-400 mb-6">Lựa chọn linh kiện tương thích, kiểm tra hiệu năng và tối ưu ngân sách với
                        công cụ thông minh của chúng tôi.</p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('build-pc') }}"
                            class="px-6 py-3 bg-white text-gray-900 font-medium rounded-lg hover:bg-gray-100 transition-colors">
                            Bắt đầu Build PC
                        </a>
                        <a href="{{ route('products.index', ['category' => 'pc-gaming']) }}"
                            class="px-6 py-3 border border-white/30 text-white font-medium rounded-lg hover:bg-white/10 transition-colors">
                            Xem PC có sẵn
                        </a>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <div class="w-48 h-48 border border-white/10 rounded-2xl flex items-center justify-center">
                        <svg class="w-20 h-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-12 bg-white border-t border-gray-100">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="py-4">
                    <svg class="w-8 h-8 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0">
                        </path>
                    </svg>
                    <h3 class="font-semibold text-gray-900 mb-1">{{ __('home.fast_delivery') }}</h3>
                    <p class="text-gray-500 text-xs">{{ __('home.fast_delivery_desc') }}</p>
                </div>

                <div class="py-4">
                    <svg class="w-8 h-8 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                    <h3 class="font-semibold text-gray-900 mb-1">{{ __('home.genuine_warranty') }}</h3>
                    <p class="text-gray-500 text-xs">{{ __('home.genuine_warranty_desc') }}</p>
                </div>

                <div class="py-4">
                    <svg class="w-8 h-8 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                    <h3 class="font-semibold text-gray-900 mb-1">{{ __('home.flexible_payment') }}</h3>
                    <p class="text-gray-500 text-xs">{{ __('home.flexible_payment_desc') }}</p>
                </div>

                <div class="py-4">
                    <svg class="w-8 h-8 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <h3 class="font-semibold text-gray-900 mb-1">Hỗ trợ 24/7</h3>
                    <p class="text-gray-500 text-xs">Đội ngũ kỹ thuật hỗ trợ tư vấn mọi lúc</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Brand Partners -->
    <section class="py-10 bg-gray-50 border-t border-gray-100">
        <div class="container mx-auto px-4 max-w-5xl">
            <p class="text-center text-gray-400 text-xs uppercase tracking-wider mb-6">Đối tác phân phối chính hãng</p>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-12 text-gray-400">
                <span class="text-xl font-bold tracking-tight">Intel</span>
                <span class="text-xl font-bold tracking-tight">AMD</span>
                <span class="text-xl font-bold tracking-tight">NVIDIA</span>
                <span class="text-xl font-bold tracking-tight">ASUS</span>
                <span class="text-xl font-bold tracking-tight">MSI</span>
                <span class="text-xl font-bold tracking-tight">Corsair</span>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-gray-900 text-white overflow-hidden relative">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-gray-500 rounded-full filter blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-gray-600 rounded-full filter blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 max-w-2xl text-center relative z-10">
            <h2 class="text-3xl font-bold mb-4">{{ __('home.newsletter_title') }}</h2>
            <p class="text-gray-400 mb-8">{{ __('home.newsletter_desc') }}</p>

            <div x-data="{ 
                                        email: '', 
                                        loading: false, 
                                        message: '', 
                                        messageType: '',
                                        async subscribe() {
                                            if (!this.email) return;
                                            this.loading = true;
                                            this.message = '';
                                            try {
                                                const response = await fetch('{{ route('newsletter.subscribe') }}', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                        'Accept': 'application/json'
                                                    },
                                                    body: JSON.stringify({ email: this.email })
                                                });
                                                const data = await response.json();
                                                this.message = data.message;
                                                this.messageType = data.success ? 'success' : (data.type || 'error');
                                                if (data.success) this.email = '';
                                            } catch (error) {
                                                this.message = '{{ __('home.error_occurred') }}';
                                                this.messageType = 'error';
                                            }
                                            this.loading = false;
                                            setTimeout(() => { this.message = ''; }, 5000);
                                        }
                                    }">
                <form @submit.prevent="subscribe" class="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
                    <input type="email" x-model="email" :disabled="loading" placeholder="{{ __('home.email_placeholder') }}"
                        required
                        class="flex-1 px-6 py-4 bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:bg-white/20 focus:border-white/40 transition-all rounded-full backdrop-blur-sm disabled:opacity-50">
                    <button type="submit" :disabled="loading"
                        class="px-8 py-4 bg-white text-gray-900 font-bold hover:bg-gray-100 transition-all rounded-full shadow-lg disabled:opacity-50 flex items-center justify-center gap-2">
                        <svg x-show="loading" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span x-text="loading ? '{{ __('home.sending') }}' : '{{ __('home.subscribe') }}'"></span>
                    </button>
                </form>

                <!-- Success/Error Message -->
                <div x-show="message" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-4">
                    <p :class="{
                                                'text-green-400': messageType === 'success',
                                                'text-yellow-400': messageType === 'info',
                                                'text-red-400': messageType === 'error'
                                            }" class="text-sm font-medium" x-text="message"></p>
                </div>
            </div>
        </div>
    </section>

@endsection