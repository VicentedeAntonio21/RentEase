<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RentEase') }} — Find your next home</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white dark:bg-[#1E2235] text-gray-800 dark:text-gray-200">

    <nav x-data="{ open: false }" class="border-b border-gray-100 dark:border-white/5">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <i class="ri-home-4-fill text-primary text-2xl"></i>
                <span class="font-heading font-bold text-lg">RentEase</span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('listings.index') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary">Browse Listings</a>
                <a href="#how-it-works" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary">How It Works</a>
            </div>

            <div class="hidden md:flex items-center gap-4">
                <button
                    @click="
                        document.documentElement.classList.toggle('dark');
                        localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
                    "
                    class="w-9 h-9 flex items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 dark:text-gray-300">
                    <i class="ri-sun-line dark:hidden"></i>
                    <i class="ri-moon-line hidden dark:inline"></i>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary">Log in</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark">
                        Get Started
                    </a>
                @endauth
            </div>

            <button @click="open = !open" class="md:hidden text-xl text-gray-500">
                <i class="ri-menu-line" x-show="!open"></i>
                <i class="ri-close-line" x-show="open" x-cloak></i>
            </button>
        </div>

        <div x-show="open" x-cloak class="md:hidden border-t border-gray-100 dark:border-white/5 px-4 py-4 space-y-3">
            <a href="{{ route('listings.index') }}" class="block text-sm font-medium text-gray-600 dark:text-gray-300">Browse Listings</a>
            <a href="#how-it-works" class="block text-sm font-medium text-gray-600 dark:text-gray-300">How It Works</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block text-sm font-medium text-primary">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="block text-sm font-medium text-gray-600 dark:text-gray-300">Log in</a>
                <a href="{{ route('register') }}" class="block text-sm font-medium text-primary">Get Started</a>
            @endauth
        </div>
    </nav>

    {{ $slot }}

    <footer class="border-t border-gray-100 dark:border-white/5 mt-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <i class="ri-home-4-fill text-primary text-xl"></i>
                <span class="font-heading font-semibold">RentEase</span>
            </div>
            <p class="text-sm text-gray-400">&copy; {{ date('Y') }} RentEase. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>