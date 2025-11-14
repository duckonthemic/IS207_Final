{{-- Header Navigation --}}
<header class="sticky top-0 z-40 bg-cyber-darker/95 backdrop-blur-md border-b border-cyber-border">
    <nav class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <div class="w-8 h-8 bg-gradient-to-br from-cyber-accent to-cyber-glow rounded-lg flex items-center justify-center group-hover:shadow-glow-cyan transition-shadow">
                <svg class="w-5 h-5 text-cyber-darker" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM2 8a2 2 0 11-4 0 2 2 0 014 0zM5 15a4 4 0 008 0v2H5v-2z"/>
                </svg>
            </div>
            <span class="font-bold text-lg text-cyber-text">UITech</span>
        </a>

        {{-- Desktop Navigation --}}
        <div class="hidden md:flex items-center gap-8">
            <a href="{{ route('products.index') }}" class="text-cyber-text hover:text-cyber-accent transition-colors font-medium">
                Sản Phẩm
            </a>
            <a href="#" class="text-cyber-text hover:text-cyber-accent transition-colors font-medium">
                Giới Thiệu
            </a>
            <a href="#" class="text-cyber-text hover:text-cyber-accent transition-colors font-medium">
                Blog
            </a>
            <a href="#" class="text-cyber-text hover:text-cyber-accent transition-colors font-medium">
                Hỗ Trợ
            </a>
        </div>

        {{-- Right Actions --}}
        <div class="hidden md:flex items-center gap-4">
            <div class="relative">
                <form action="{{ route('products.index') }}" method="get" class="hidden lg:flex">
                    <input type="text" name="q" placeholder="Tìm kiếm..." value="{{ request('q') }}"
                           class="px-4 py-2 bg-cyber-card border border-cyber-border rounded-l-lg text-cyber-text placeholder-cyber-muted focus:outline-none focus:border-cyber-accent text-sm w-48">
                    <button type="submit" class="px-4 py-2 bg-cyber-accent text-cyber-darker rounded-r-lg font-semibold hover:shadow-glow-cyan transition-all">
                        🔍
                    </button>
                </form>
            </div>
        </div>

        {{-- Mobile Menu Button --}}
        <button x-data @click="$dispatch('toggle-menu')" class="md:hidden p-2">
            <svg class="w-6 h-6 text-cyber-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </nav>
</header>

