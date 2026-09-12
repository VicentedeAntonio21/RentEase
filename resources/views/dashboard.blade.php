<x-app-layout>
    @section('title', 'Dashboard')

    <div class="space-y-6">

        <div class="bg-gradient-to-r from-primary to-primary-dark rounded-xl p-6 text-white flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-heading text-xl font-semibold">Welcome back, {{ auth()->user()->name }}</h2>
                <p class="text-white/80 text-sm mt-1">
                    You're signed in as
                    <span class="font-medium capitalize">{{ auth()->user()->role }}</span>.
                </p>
            </div>

            @if (auth()->user()->isTenant())
                <a href="{{ route('home') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-primary rounded-lg font-medium text-sm hover:bg-white/90 w-fit">
                    <i class="ri-search-line"></i> Browse Listings
                </a>
            @elseif (auth()->user()->isOwner())
                <a href="{{ route('owner.properties.index') }}" class="... animate-fade-in-up">
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-primary rounded-lg font-medium text-sm hover:bg-white/90 w-fit">
                    <i class="ri-add-line"></i> Add Property
                </a>
            @endif
        </div>

        @if (auth()->user()->isTenant())
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('home') }}" class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                        <i class="ri-search-line text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-heading font-semibold">Browse Listings</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Find your next home</p>
                    </div>
                </a>
                <a href="{{ route('applications.index') }}" class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-warning/10 text-warning flex items-center justify-center">
                        <i class="ri-file-list-3-line text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-heading font-semibold">My Applications</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Track your rental applications</p>
                    </div>
                </a>
            </div>
        @endif

        @if (auth()->user()->isOwner())
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('owner.properties.index') }}" class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                        <i class="ri-building-4-line text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-heading font-semibold">My Properties</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage listings & units</p>
                    </div>
                </a>
                <a href="{{ route('owner.applications.received') }}" class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-5 flex items-center gap-4 hover:shadow-md transition-shadow animate-fade-in-up animate-delay-1">
                    <div class="w-12 h-12 rounded-full bg-warning/10 text-warning flex items-center justify-center">
                        <i class="ri-inbox-archive-line text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-heading font-semibold">Applications</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Review tenant requests</p>
                    </div>
                </a>
                <a href="{{ route('owner.reports') }}" class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-5 flex items-center gap-4 hover:shadow-md transition-shadow animate-fade-in-up animate-delay-2">
                    <div class="w-12 h-12 rounded-full bg-success/10 text-success flex items-center justify-center">
                        <i class="ri-bar-chart-2-line text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-heading font-semibold">Reports</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Occupancy & revenue</p>
                    </div>
                </a>
            </div>
        @endif

        @if (auth()->user()->isAdmin())
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('admin.dashboard') }}" class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                        <i class="ri-shield-star-line text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-heading font-semibold">Admin Overview</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Platform-wide stats</p>
                    </div>
                </a>
                <a href="{{ route('admin.users.index') }}" class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-warning/10 text-warning flex items-center justify-center">
                        <i class="ri-team-line text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-heading font-semibold">Users</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage all accounts</p>
                    </div>
                </a>
                <a href="{{ route('admin.properties.index') }}" class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-5 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-success/10 text-success flex items-center justify-center">
                        <i class="ri-building-line text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-heading font-semibold">Properties</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Oversee all listings</p>
                    </div>
                </a>
            </div>
        @endif
    </div>
</x-app-layout>