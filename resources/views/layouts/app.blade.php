<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="UITech - Cửa hàng linh kiện máy tính chuyên nghiệp">
    <title>@yield('title', 'UITech - Linh kiện máy tính')</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Custom Tailwind Config --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'cyber': {
                            'dark': '#0a0e27',
                            'darker': '#060920',
                            'card': '#0f1535',
                            'border': '#1a2a4a',
                            'accent': '#00ffff',
                            'glow': '#00ff00',
                            'purple': '#9b59b6',
                            'text': '#e0e6ed',
                            'muted': '#7a8a9a',
                            'success': '#00ff88',
                            'error': '#ff1744',
                        }
                    },
                    boxShadow: {
                        'glow-cyan': '0 0 20px rgba(0, 255, 255, 0.5)',
                        'glow-green': '0 0 20px rgba(0, 255, 136, 0.5)',
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen flex flex-col bg-cyber-dark text-cyber-text font-sans" x-data="{ mobileMenuOpen: false, searchOpen: false }">
    {{-- Header --}}
    @include('partials.header')

    {{-- Main Content --}}
    <main class="flex-1">
        {{-- Alert Messages --}}
        @if (session('success'))
            <div class="fixed top-4 right-4 bg-cyber-success/10 border border-cyber-success text-cyber-success px-6 py-3 rounded-lg shadow-lg animate-pulse-glow z-50 max-w-md">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="fixed top-4 right-4 bg-cyber-error/10 border border-cyber-error text-cyber-error px-6 py-3 rounded-lg shadow-lg animate-pulse-glow z-50 max-w-md">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')
</body>
</html>

