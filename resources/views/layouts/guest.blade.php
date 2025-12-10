<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased neu-bg min-h-screen">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4 py-12">
        <!-- Logo Section with Neumorphism -->
        <div class="mb-8">
            <a href="/" class="flex flex-col items-center gap-3 group">
                <div class="neu-logo transition-transform duration-300 group-hover:scale-105">
                    <x-application-logo class="w-12 h-12 fill-current text-gray-900" />
                </div>
                <span class="font-bold text-2xl text-gray-900 tracking-tight">UITech Store</span>
            </a>
        </div>

        <!-- Main Card with Neumorphism -->
        <div class="w-full sm:max-w-md neu-raised px-8 py-10">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} UITech Store. All rights reserved.
        </div>
    </div>
</body>

</html>