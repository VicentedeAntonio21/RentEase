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

            <form action="{{ route('listings.index') }}" method="GET"
                class="mt-8 flex flex-col sm:flex-row gap-3 bg-white dark:bg-[#252B3E] p-2 rounded-xl shadow-sm border border-gray-100 dark:border-white/5 animate-fade-in-up animate-delay-2">
                <div class="flex-1 flex items-center gap-2 px-3">
                    <i class="ri-map-pin-line text-gray-400"></i>
                    <input type="text" name="city" placeholder="Search by city"
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

        <div class="relative hidden lg:block animate-fade-in-up animate-delay-2">
            <div class="absolute inset-0 bg-primary/5 rounded-3xl -rotate-3"></div>
            <div
                class="relative bg-white dark:bg-[#252B3E] rounded-2xl shadow-lg border border-gray-100 dark:border-white/5 p-6 space-y-4">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-lg bg-success/10 text-success flex items-center justify-center"><i
                            class="ri-checkbox-circle-line"></i></span>
                    <div>
                        <p class="font-medium text-sm">Application approved</p>
                        <p class="text-xs text-gray-400">Sunrise Apartments — Unit 2B</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center"><i
                            class="ri-bar-chart-2-line"></i></span>
                    <div>
                        <p class="font-medium text-sm">Occupancy at 82%</p>
                        <p class="text-xs text-gray-400">Across 6 properties</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-lg bg-warning/10 text-warning flex items-center justify-center"><i
                            class="ri-time-line"></i></span>
                    <div>
                        <p class="font-medium text-sm">2 new applications</p>
                        <p class="text-xs text-gray-400">Waiting for review</p>
                    </div>
                </div>
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