<x-marketing-layout>

    <!-- Hero -->
    <section class="relative overflow-hidden">
        <div
            class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary/10 rounded-full blur-3xl -translate-y-1/3 translate-x-1/3 pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-primary/5 rounded-full blur-3xl translate-y-1/3 -translate-x-1/3 pointer-events-none">
        </div>

        <div
            class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <h1 class="font-heading text-4xl sm:text-5xl font-bold leading-tight animate-fade-in-up">
                Renting made simple, for tenants and owners alike.
            </h1>
            <p class="mt-5 text-gray-500 dark:text-gray-400 text-lg max-w-md animate-fade-in-up animate-delay-1">
                Browse available units, apply online, and track everything from one place — no phone tag, no
                paperwork.
            </p>

            <form action="{{ route('home') }}" method="GET"
                class="mt-8 flex flex-col sm:flex-row gap-3 bg-white dark:bg-[#252B3E] p-2 rounded-xl shadow-sm border border-gray-100 dark:border-white/5 animate-fade-in-up animate-delay-2">
                <div class="flex-1 flex items-center gap-2 px-3">
                    <i class="ri-map-pin-line text-gray-400"></i>
                    <input type="text" name="city" placeholder="Search by city" value="{{ $city }}"
                        class="w-full border-0 focus:ring-0 text-sm bg-transparent dark:text-white placeholder:text-gray-400">
                </div>
                <button type="submit"
                    class="px-6 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark flex items-center justify-center gap-2">
                    <i class="ri-search-line"></i> Search
                </button>
            </form>

            <div class="flex flex-wrap gap-x-8 gap-y-3 mt-10 animate-fade-in-up animate-delay-3">
                <div>
                    <p class="font-heading text-2xl font-bold text-primary">{{ $stats['available_units'] }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Units available now</p>
                </div>
                <div>
                    <p class="font-heading text-2xl font-bold text-primary">{{ $stats['total_properties'] }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Properties listed</p>
                </div>
                <div>
                    <p class="font-heading text-2xl font-bold text-primary">{{ $stats['cities'] }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ Str::plural('city', $stats['cities']) }}
                        covered</p>
                </div>
            </div>
        </div>

        <div class="hidden lg:block animate-fade-in-up animate-delay-2">
            @if ($featuredUnits->isNotEmpty())
                <div class="flex flex-wrap justify-center gap-4">
                    @foreach ($featuredUnits as $unit)
                        <a href="{{ route('listings.show', $unit) }}"
                            class="group flex {{ $featuredUnits->count() === 1 ? 'flex-row w-80' : 'flex-col w-56' }} bg-white dark:bg-[#252B3E] rounded-2xl shadow-lg border border-gray-100 dark:border-white/5 overflow-hidden hover:shadow-xl transition-shadow">

                            <div
                                class="relative {{ $featuredUnits->count() === 1 ? 'w-32 shrink-0' : 'w-full h-36' }} bg-gray-100 dark:bg-white/5">
                                @if ($unit->property->images->count())
                                    <img src="{{ Storage::url($unit->property->images->first()->image_path) }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                                        <i class="ri-image-line text-2xl"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4 flex-1 min-w-0">
                                <p class="text-xs font-medium text-success flex items-center gap-1">
                                    <i class="ri-checkbox-circle-fill"></i> Available now
                                </p>
                                <p class="font-heading font-semibold text-sm mt-1 truncate">
                                    {{ $unit->property->title }} — {{ $unit->unit_name }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-0.5">
                                    <i class="ri-map-pin-line"></i> {{ $unit->property->city }}
                                </p>
                                <div class="flex items-center justify-between mt-2">
                                    <p class="font-heading font-bold text-primary text-sm">
                                        ₱{{ number_format($unit->rent_price, 0) }}<span
                                            class="text-xs font-normal text-gray-400">/mo</span>
                                    </p>
                                    <i
                                        class="ri-arrow-right-line text-primary opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>


                @if ($city)
                    <p class="text-center text-sm mt-4">
                        <a href="{{ route('listings.index', ['city' => $city]) }}"
                            class="text-primary font-medium hover:underline">
                            View all results in "{{ $city }}" →
                        </a>
                    </p>
                @endif
            @else
                <div
                    class="max-w-sm mx-auto bg-white dark:bg-[#252B3E] rounded-2xl shadow-lg border border-gray-100 dark:border-white/5 p-8 text-center">
                    <i class="ri-home-search-line text-4xl text-gray-300 dark:text-gray-600"></i>
                    <p class="font-heading font-semibold mt-3">
                        @if ($city)
                            No available apartments in "{{ $city }}"
                        @else
                            No available apartments yet
                        @endif
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        @if ($city)
                            Try another city, or browse all listings.
                        @else
                            Check back soon, or explore the full listings page.
                        @endif
                    </p>
                    <a href="{{ route('listings.index') }}"
                        class="inline-block mt-4 text-primary text-sm font-medium hover:underline">
                        Browse all listings →
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Features -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center max-w-2xl mx-auto mb-12 animate-fade-in-up">
            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-medium mb-3">
                Why RentEase
            </span>
            <h2 class="font-heading text-3xl font-bold">Everything you need, in one place</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2">
                No more scattered listings, missed calls, or lost paperwork — RentEase keeps the whole rental process
                organized.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-6 hover:shadow-md hover:-translate-y-1 transition-all duration-200 animate-fade-in-up">
                <span class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-4">
                    <i class="ri-search-eye-line text-2xl"></i>
                </span>
                <h3 class="font-heading font-semibold mb-1">Smart Search & Filters</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Narrow down listings by city, price range, bedrooms, and property type in seconds.
                </p>
            </div>

            <div
                class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-6 hover:shadow-md hover:-translate-y-1 transition-all duration-200 animate-fade-in-up animate-delay-1">
                <span class="w-12 h-12 rounded-xl bg-success/10 text-success flex items-center justify-center mb-4">
                    <i class="ri-file-list-3-line text-2xl"></i>
                </span>
                <h3 class="font-heading font-semibold mb-1">Apply Entirely Online</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Submit your move-in date and a message to the owner — no printed forms, no office visits.
                </p>
            </div>

            <div
                class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-6 hover:shadow-md hover:-translate-y-1 transition-all duration-200 animate-fade-in-up animate-delay-2">
                <span class="w-12 h-12 rounded-xl bg-warning/10 text-warning flex items-center justify-center mb-4">
                    <i class="ri-notification-3-line text-2xl"></i>
                </span>
                <h3 class="font-heading font-semibold mb-1">Real-Time Status Updates</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Track every application from pending to approved without chasing anyone for updates.
                </p>
            </div>

            <div
                class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-6 hover:shadow-md hover:-translate-y-1 transition-all duration-200 animate-fade-in-up">
                <span class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-4">
                    <i class="ri-image-2-line text-2xl"></i>
                </span>
                <h3 class="font-heading font-semibold mb-1">Photo Galleries</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Browse real photos of every property and unit before you ever have to schedule a visit.
                </p>
            </div>

            <div
                class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-6 hover:shadow-md hover:-translate-y-1 transition-all duration-200 animate-fade-in-up animate-delay-1">
                <span class="w-12 h-12 rounded-xl bg-success/10 text-success flex items-center justify-center mb-4">
                    <i class="ri-bar-chart-2-line text-2xl"></i>
                </span>
                <h3 class="font-heading font-semibold mb-1">Occupancy & Revenue Reports</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Owners get clear dashboards showing occupancy rate and monthly revenue at a glance.
                </p>
            </div>

            <div
                class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-6 hover:shadow-md hover:-translate-y-1 transition-all duration-200 animate-fade-in-up animate-delay-2">
                <span class="w-12 h-12 rounded-xl bg-warning/10 text-warning flex items-center justify-center mb-4">
                    <i class="ri-shield-check-line text-2xl"></i>
                </span>
                <h3 class="font-heading font-semibold mb-1">Verified Accounts</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Email verification for every account keeps the platform trustworthy for tenants and owners alike.
                </p>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section id="how-it-works"
        class="bg-gray-50 dark:bg-white/[0.02] border-y border-gray-100 dark:border-white/5 py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-12">

            <div>
                <h2 class="font-heading text-2xl font-bold mb-6">For tenants</h2>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <span
                            class="shrink-0 w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-sm font-semibold">1</span>
                        <div>
                            <p class="font-medium">Search & filter</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Find units by city, price, and bedrooms.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span
                            class="shrink-0 w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-sm font-semibold">2</span>
                        <div>
                            <p class="font-medium">Apply online</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Submit your move-in date and a message
                                to the owner.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span
                            class="shrink-0 w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-sm font-semibold">3</span>
                        <div>
                            <p class="font-medium">Track your status</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">See approvals in real time from your
                                dashboard.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="font-heading text-2xl font-bold mb-6">For property owners</h2>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <span
                            class="shrink-0 w-8 h-8 rounded-full bg-sidebar text-white flex items-center justify-center text-sm font-semibold">1</span>
                        <div>
                            <p class="font-medium">List your property</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Add units, prices, and photos in
                                minutes.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span
                            class="shrink-0 w-8 h-8 rounded-full bg-sidebar text-white flex items-center justify-center text-sm font-semibold">2</span>
                        <div>
                            <p class="font-medium">Review applications</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Approve or reject tenants with one
                                click.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span
                            class="shrink-0 w-8 h-8 rounded-full bg-sidebar text-white flex items-center justify-center text-sm font-semibold">3</span>
                        <div>
                            <p class="font-medium">Track occupancy</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">See revenue and occupancy rates at a
                                glance.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats band -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-sidebar rounded-2xl p-10 grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
            <div class="animate-fade-in-up">
                <p class="font-heading text-3xl font-bold text-primary">{{ $stats['available_units'] }}</p>
                <p class="text-sm text-gray-300 mt-1">Units available</p>
            </div>
            <div class="animate-fade-in-up animate-delay-1">
                <p class="font-heading text-3xl font-bold text-primary">{{ $stats['total_properties'] }}</p>
                <p class="text-sm text-gray-300 mt-1">Properties listed</p>
            </div>
            <div class="animate-fade-in-up animate-delay-2">
                <p class="font-heading text-3xl font-bold text-primary">{{ $stats['cities'] }}</p>
                <p class="text-sm text-gray-300 mt-1">{{ Str::plural('City', $stats['cities']) }} covered</p>
            </div>
            <div class="animate-fade-in-up animate-delay-3">
                <p class="font-heading text-3xl font-bold text-primary">24/7</p>
                <p class="text-sm text-gray-300 mt-1">Assistant support</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <h2 class="font-heading text-3xl font-bold">Ready to get started?</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-2">Create an account as a tenant or property owner — it takes a
            minute.</p>
        <div class="flex justify-center gap-3 mt-6">
            @auth
                <a href="{{ route('dashboard') }}"
                    class="px-6 py-3 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}"
                    class="px-6 py-3 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark">
                    Create an Account
                </a>
                <a href="{{ route('listings.index') }}"
                    class="px-6 py-3 border border-gray-200 dark:border-white/10 rounded-lg text-sm font-medium hover:border-primary hover:text-primary">
                    Browse Listings
                </a>
            @endauth
        </div>
    </section>

</x-marketing-layout>