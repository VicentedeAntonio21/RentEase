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

    <title>{{ config('app.name', 'RentEase') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-[#1E2235] text-gray-800 dark:text-gray-200">

    <div class="min-h-screen flex">

        <!-- Left: brand panel (hidden on small screens) -->
        <div class="hidden lg:flex lg:w-1/2 bg-sidebar text-white flex-col justify-between p-12 relative overflow-hidden">
            <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-primary/20"></div>
            <div class="absolute -right-10 bottom-0 w-64 h-64 rounded-full bg-primary/10"></div>

            <div class="relative flex items-center gap-2">
                <i class="ri-home-4-fill text-primary text-3xl"></i>
                <span class="font-heading font-bold text-xl">RentEase</span>
            </div>

            <div class="relative">
                <h1 class="font-heading text-3xl font-bold leading-tight">
                    Find your next home,<br>or manage the ones you own.
                </h1>
                <p class="mt-4 text-gray-300 max-w-sm">
                    RentEase brings property owners and renters together — browse listings, apply online, and track everything in one place.
                </p>

                <div class="flex gap-6 mt-8 text-sm text-gray-300">
                    <div class="flex items-center gap-2"><i class="ri-search-line text-primary"></i> Browse listings</div>
                    <div class="flex items-center gap-2"><i class="ri-file-list-3-line text-primary"></i> Apply online</div>
                    <div class="flex items-center gap-2"><i class="ri-bar-chart-2-line text-primary"></i> Track occupancy</div>
                </div>
            </div>

            <p class="relative text-xs text-gray-400">&copy; {{ date('Y') }} RentEase. All rights reserved.</p>
        </div>

        <!-- Right: form panel -->
        <div class="flex-1 flex flex-col items-center justify-center p-6 relative">

            <!-- Dark mode toggle -->
            <button
                x-data
                @click="
                    document.documentElement.classList.toggle('dark');
                    localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
                "
                class="absolute top-6 right-6 w-9 h-9 flex items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 dark:text-gray-300">
                <i class="ri-sun-line dark:hidden"></i>
                <i class="ri-moon-line hidden dark:inline"></i>
            </button>

            <!-- Mobile-only logo -->
            <div class="lg:hidden flex items-center gap-2 mb-8">
                <i class="ri-home-4-fill text-primary text-3xl"></i>
                <span class="font-heading font-bold text-xl">RentEase</span>
            </div>

            <div class="w-full max-w-sm">
                {{ $slot }}
            </div>
        </div>
    </div>

</body>
</html>