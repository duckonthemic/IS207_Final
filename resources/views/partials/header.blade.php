{{-- Header Navigation --}}
<header class="sticky top-0 z-40 bg-cyber-darker/95 backdrop-blur-md border-b border-cyber-border">
    <nav class="container mx-auto px-4 py-4 flex items-center justify-between">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <div class="w-8 h-8 bg-gradient-to-br from-cyber-accent to-cyber-glow rounded-lg flex items-center justify-center group-hover:shadow-glow-cyan transition-shadow">
                <svg class="w-5 h-5 text-cyber-darker" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM2 8a2 2 0 11-4 0 2 2 0 014 0zM5 15a4 4 0 008 0v2H5v-2z"/>
                </svg>
            </div>
            <span class="font-bold text-lg text-cyber-text">Tech Parts</span>
        </a>

        {{-- Search (Desktop) --}}
        <div class="hidden md:flex flex-1 mx-8 max-w-md">
            <form action="{{ route('products.index') }}" method="get" class="w-full">
                <div class="relative">
                    <input 
                        type="text" 
                        name="q" 
                        placeholder="Tìm kiếm sản phẩm..."
                        value="{{ request('q') }}"
                        class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded-lg text-cyber-text placeholder-cyber-muted focus:outline-none focus:border-cyber-accent focus:ring-1 focus:ring-cyber-accent/30 transition-all"
                    >
                    <button type="submit" class="absolute right-3 top-2.5 text-cyber-muted hover:text-cyber-accent transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- Desktop Navigation --}}
        <div class="hidden md:flex items-center gap-6">
            <a href="{{ route('products.index') }}" class="text-cyber-text hover:text-cyber-accent transition-colors">
                Sản phẩm
            </a>
            <a href="{{ route('about') }}" class="text-cyber-text hover:text-cyber-accent transition-colors">
                Về chúng tôi
            </a>
            <a href="{{ route('contact') }}" class="text-cyber-text hover:text-cyber-accent transition-colors">
                Liên hệ
            </a>

            {{-- Cart Icon (Disabled - requires auth) --}}
            {{-- 
            <a href="{{ route('cart.index') }}" class="relative group">
                <div class="p-2 rounded-lg bg-cyber-card border border-cyber-border group-hover:border-cyber-accent group-hover:shadow-glow-cyan transition-all">
                    <svg class="w-6 h-6 text-cyber-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </a>
            --}}

            {{-- Auth (Disabled - requires Breeze) --}}
            {{--
            @auth
                <div class="flex items-center gap-3">
                    <span class="text-cyber-muted text-sm">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 bg-cyber-error/10 border border-cyber-error text-cyber-error rounded text-sm hover:bg-cyber-error/20 transition-colors">
                            Đăng xuất
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 border border-cyber-accent text-cyber-accent rounded-lg hover:bg-cyber-accent/10 transition-colors">
                    Đăng nhập
                </a>
            @endauth
            --}}
        </div>

        {{-- Mobile Menu Button --}}
        <button x-data @click="$dispatch('toggle-menu')" class="md:hidden p-2">
            <svg class="w-6 h-6 text-cyber-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </nav>
</header>

