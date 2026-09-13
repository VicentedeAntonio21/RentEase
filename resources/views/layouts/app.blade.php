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
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-[#1E2235] text-gray-800 dark:text-gray-200" x-data="{
        mobileOpen: false,
        collapsed: localStorage.getItem('sidebarCollapsed') === 'true',
        toggleSidebar() {
            if (window.innerWidth < 1024) {
                this.mobileOpen = ! this.mobileOpen;
            } else {
                this.collapsed = ! this.collapsed;
                localStorage.setItem('sidebarCollapsed', this.collapsed);
            }
        }
    }">

    <!-- Sidebar (fixed, pinned to viewport) -->
    <aside :class="[
            mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
            collapsed ? 'lg:w-20' : 'lg:w-64'
        ]"
        class="fixed inset-y-0 left-0 z-40 w-64 bg-sidebar text-gray-300 transform transition-all duration-200 ease-in-out overflow-y-auto overflow-x-hidden">

        <a href="{{ route('dashboard') }}"
            class="h-16 flex items-center gap-2 px-6 border-b border-white/10 whitespace-nowrap hover:bg-sidebar-hover transition-colors">
            <img src="{{ asset('images/rentease-icon-square.png') }}" alt="RentEase" class="w-8 h-8 shrink-0">
            <span x-show="!collapsed" class="font-heading font-bold text-lg text-white">RentEase</span>
        </a>

        <nav class="px-3 py-4 space-y-1">
            <x-sidebar-link href="{{ route('listings.index') }}" icon="ri-search-line"
                :active="request()->routeIs('listings.*')">
                Browse Listings
            </x-sidebar-link>

            <x-sidebar-link href="{{ route('dashboard') }}" icon="ri-dashboard-line"
                :active="request()->routeIs('dashboard')">
                Dashboard
            </x-sidebar-link>

            @auth
                @if (auth()->user()->isTenant())
                    <x-sidebar-link href="{{ route('applications.index') }}" icon="ri-file-list-3-line"
                        :active="request()->routeIs('applications.index')">
                        My Applications
                    </x-sidebar-link>
                @endif

                @if (auth()->user()->isOwner())
                    <p x-show="!collapsed"
                        class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wide text-gray-500 whitespace-nowrap">
                        Owner</p>

                    <x-sidebar-link href="{{ route('owner.properties.index') }}" icon="ri-building-4-line"
                        :active="request()->routeIs('owner.properties.*')">
                        My Properties
                    </x-sidebar-link>
                    <x-sidebar-link href="{{ route('owner.applications.received') }}" icon="ri-inbox-archive-line"
                        :active="request()->routeIs('owner.applications.received')">
                        Applications
                    </x-sidebar-link>
                    <x-sidebar-link href="{{ route('owner.reports') }}" icon="ri-bar-chart-2-line"
                        :active="request()->routeIs('owner.reports')">
                        Reports
                    </x-sidebar-link>
                @endif

                @if (auth()->user()->isAdmin())
                    <p x-show="!collapsed"
                        class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-wide text-gray-500 whitespace-nowrap">
                        Admin</p>

                    <x-sidebar-link href="{{ route('admin.dashboard') }}" icon="ri-shield-star-line"
                        :active="request()->routeIs('admin.dashboard')">
                        Overview
                    </x-sidebar-link>
                    <x-sidebar-link href="{{ route('admin.users.index') }}" icon="ri-team-line"
                        :active="request()->routeIs('admin.users.*')">
                        Users
                    </x-sidebar-link>
                    <x-sidebar-link href="{{ route('admin.properties.index') }}" icon="ri-building-line"
                        :active="request()->routeIs('admin.properties.*')">
                        Properties
                    </x-sidebar-link>
                    <x-sidebar-link href="{{ route('admin.applications.index') }}" icon="ri-file-list-line"
                        :active="request()->routeIs('admin.applications.*')">
                        Applications
                    </x-sidebar-link>
                @endif
            @endauth
        </nav>
    </aside>

    <!-- Mobile overlay -->
    <div x-show="mobileOpen" x-cloak @click="mobileOpen = false" class="fixed inset-0 z-30 bg-black/40 lg:hidden"></div>

    <!-- Topbar -->
    <header :class="collapsed ? 'lg:left-20' : 'lg:left-64'"
        class="fixed top-0 left-0 right-0 z-20 h-16 bg-white dark:bg-[#252B3E] border-b border-gray-200 dark:border-white/10 flex items-center justify-between px-4 lg:px-6 transition-all duration-200 ease-in-out">

        <div class="flex items-center gap-3">
            <button @click="toggleSidebar()" class="text-xl text-gray-500 dark:text-gray-300 hover:text-primary">
                <i class="ri-menu-line"></i>
            </button>
            @hasSection('header')
                <h1 class="font-heading font-semibold text-lg">@yield('title')</h1>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button @click="
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
                            <span
                                class="w-8 h-8 rounded-full bg-primary-light dark:bg-primary/20 text-primary flex items-center justify-center font-heading font-semibold">
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
                <a href="{{ route('register') }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg bg-primary text-white hover:bg-primary-dark">Register</a>
            @endauth
        </div>
    </header>

    <!-- Page content -->
    <main :class="collapsed ? 'lg:ml-20' : 'lg:ml-64'"
        class="pt-16 min-h-screen transition-all duration-200 ease-in-out">
        <div class="p-4 sm:p-6 lg:p-8 max-w-[1400px] mx-auto">
            {{ $slot }}
        </div>
    </main>

    <!-- Global image lightbox -->
    <div x-show="$store.lightbox.open" x-cloak @click="$store.lightbox.close()"
        @keydown.escape.window="$store.lightbox.close()" @keydown.arrow-right.window="$store.lightbox.next()"
        @keydown.arrow-left.window="$store.lightbox.prev()" x-transition.opacity
        class="fixed inset-0 z-[100] bg-black/90 flex items-center justify-center p-4">
        <button @click.stop="$store.lightbox.close()"
            class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20 text-2xl">
            <i class="ri-close-line"></i>
        </button>

        <button x-show="$store.lightbox.images.length > 1" @click.stop="$store.lightbox.prev()"
            class="absolute left-4 w-11 h-11 flex items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20 text-3xl">
            <i class="ri-arrow-left-s-line"></i>
        </button>

        <img :src="$store.lightbox.images[$store.lightbox.index]" @click.stop
            class="max-h-[85vh] max-w-full rounded-lg object-contain shadow-2xl">

        <button x-show="$store.lightbox.images.length > 1" @click.stop="$store.lightbox.next()"
            class="absolute right-4 w-11 h-11 flex items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20 text-3xl">
            <i class="ri-arrow-right-s-line"></i>
        </button>

        <div x-show="$store.lightbox.images.length > 1"
            class="absolute bottom-6 px-3 py-1 rounded-full bg-white/10 text-white text-xs font-medium"
            x-text="`${$store.lightbox.index + 1} / ${$store.lightbox.images.length}`">
        </div>
    </div>

    @stack('scripts')
</body>

</html>