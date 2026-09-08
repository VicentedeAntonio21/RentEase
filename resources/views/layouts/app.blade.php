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

    <title>{{ config('app.name', 'RentEase') }} — @yield('title', 'Dashboard')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-[#1E2235] text-gray-800 dark:text-gray-200" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-30 w-64 bg-sidebar text-gray-300 transform transition-transform duration-200 ease-in-out lg:static lg:translate-x-0">

            <div class="h-16 flex items-center gap-2 px-6 border-b border-white/10">
                <i class="ri-home-4-fill text-primary text-2xl"></i>
                <span class="font-heading font-bold text-lg text-white">RentEase</span>
            </div>

            <nav class="px-3 py-4 space-y-1">
                <x-sidebar-link href="{{ route('home') }}" icon="ri-search-line" :active="request()->routeIs('home')">
                    Browse Listings
                </x-sidebar-link>

                <x-sidebar-link href="{{ route('dashboard') }}" icon="ri-dashboard-line" :active="request()->routeIs('dashboard')">
                    Dashboard
                </x-sidebar-link>

                @auth
                    @if (auth()->user()->isTenant())
                        <x-sidebar-link href="{{ route('applications.index') }}" icon="ri-file-list-3-line" :active="request()->routeIs('applications.index')">
                            My Applications
                        </x-sidebar-link>
                    @endif

                    @if (auth()->user()->isOwner())
                        <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wide text-gray-500">Owner</p>

                        <x-sidebar-link href="{{ route('owner.properties.index') }}" icon="ri-building-4-line" :active="request()->routeIs('owner.properties.*')">
                            My Properties
                        </x-sidebar-link>
                        <x-sidebar-link href="{{ route('owner.applications.received') }}" icon="ri-inbox-archive-line" :active="request()->routeIs('owner.applications.received')">
                            Applications
                        </x-sidebar-link>
                        <x-sidebar-link href="{{ route('owner.reports') }}" icon="ri-bar-chart-2-line" :active="request()->routeIs('owner.reports')">
                            Reports
                        </x-sidebar-link>
                    @endif

                    @if (auth()->user()->isAdmin())
                        <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wide text-gray-500">Admin</p>

                        <x-sidebar-link href="{{ route('admin.dashboard') }}" icon="ri-shield-star-line" :active="request()->routeIs('admin.dashboard')">
                            Overview
                        </x-sidebar-link>
                        <x-sidebar-link href="{{ route('admin.users.index') }}" icon="ri-team-line" :active="request()->routeIs('admin.users.*')">
                            Users
                        </x-sidebar-link>
                        <x-sidebar-link href="{{ route('admin.properties.index') }}" icon="ri-building-line" :active="request()->routeIs('admin.properties.*')">
                            Properties
                        </x-sidebar-link>
                        <x-sidebar-link href="{{ route('admin.applications.index') }}" icon="ri-file-list-line" :active="request()->routeIs('admin.applications.*')">
                            Applications
                        </x-sidebar-link>
                    @endif
                @endauth
            </nav>
        </aside>

        <!-- Mobile overlay -->
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
             class="fixed inset-0 z-20 bg-black/40 lg:hidden"></div>

        <!-- Main column -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- Topbar -->
            <header class="h-16 bg-white dark:bg-[#252B3E] border-b border-gray-200 dark:border-white/10 flex items-center justify-between px-4 lg:px-6">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-xl text-gray-500">
                        <i class="ri-menu-line"></i>
                    </button>
                    @hasSection('header')
                        <h1 class="font-heading font-semibold text-lg">@yield('title')</h1>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <!-- Dark mode toggle -->
                    <button
                        x-data
                        @click="
                            document.documentElement.classList.toggle('dark');
                            localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
                        "
                        class="w-9 h-9 flex items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 dark:text-gray-300">
                        <i class="ri-sun-line dark:hidden"></i>
                        <i class="ri-moon-line hidden dark:inline"></i>
                    </button>

                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-2 text-sm font-medium">
                                    <span class="w-8 h-8 rounded-full bg-primary-light dark:bg-primary/20 text-primary flex items-center justify-center font-heading font-semibold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                    <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                                    <i class="ri-arrow-down-s-line text-gray-400"></i>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        Log Out
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300">Log in</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium rounded-lg bg-primary text-white hover:bg-primary-dark">Register</a>
                    @endauth
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 p-4 lg:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>