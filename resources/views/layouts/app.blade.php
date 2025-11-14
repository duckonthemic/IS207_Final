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
    
    {{-- Tailwind CSS CDN with Custom Config --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Barlow', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'cyber-dark': '#0a0e27',
                        'cyber-darker': '#060920',
                        'cyber-card': '#0f1535',
                        'cyber-border': '#1a2a4a',
                        'cyber-accent': '#00ffff',
                        'cyber-glow': '#00ff88',
                        'cyber-text': '#e0e6ed',
                        'cyber-muted': '#7a8a9a',
                        'cyber-error': '#ff1744',
                    },
                    boxShadow: {
                        'glow-cyan': '0 0 20px rgba(0, 255, 255, 0.5)',
                        'glow-green': '0 0 20px rgba(0, 255, 136, 0.5)',
                    }
                }
            }
        }
    </script>

    {{-- Alpine.js CDN --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    @include('partials.header')

    <main class="min-h-screen">
        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
