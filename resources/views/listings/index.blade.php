<x-app-layout>
    @section('title', 'Browse Listings')

    <div class="space-y-6">

        <!-- Search / Filter Bar -->
        <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-5">
            <form method="GET" action="{{ route('home') }}" class="grid grid-cols-2 md:grid-cols-6 gap-3">

                <div class="col-span-2 md:col-span-1">
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">City</label>
                    <input type="text" name="city" placeholder="e.g. Lucena" value="{{ request('city') }}"
                           class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Min Price</label>
                    <input type="number" name="min_price" placeholder="₱" value="{{ request('min_price') }}"
                           class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Max Price</label>
                    <input type="number" name="max_price" placeholder="₱" value="{{ request('max_price') }}"
                           class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Bedrooms</label>
                    <select name="bedrooms" class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary">
                        <option value="">Any</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" @selected(request('bedrooms') == $i)>{{ $i }}+</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Type</label>
                    <select name="property_type" class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary">
                        <option value="">Any</option>
                        @foreach (['apartment', 'house', 'condo', 'room', 'other'] as $type)
                            <option value="{{ $type }}" @selected(request('property_type') === $type)>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark flex items-center justify-center gap-1">
                        <i class="ri-search-line"></i> Search
                    </button>
                    @if (request()->anyFilled(['city', 'min_price', 'max_price', 'bedrooms', 'property_type']))
                        <a href="{{ route('home') }}" class="px-3 py-2 border border-gray-200 dark:border-white/10 rounded-lg text-sm text-gray-500 dark:text-gray-400">
                            <i class="ri-close-line"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Results header -->
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $units->total() }} {{ Str::plural('unit', $units->total()) }} available
            </p>
        </div>

        <!-- Results grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($units as $unit)
                <x-property-card :unit="$unit" />
            @empty
                <div class="col-span-full text-center py-16">
                    <i class="ri-home-search-line text-5xl text-gray-300 dark:text-gray-600"></i>
                    <p class="mt-3 text-gray-500 dark:text-gray-400">No available units match your search.</p>
                    <a href="{{ route('home') }}" class="inline-block mt-2 text-primary text-sm font-medium">Clear filters</a>
                </div>
            @endforelse
        </div>

        <div>
            {{ $units->links() }}
        </div>
    </div>
</x-app-layout>