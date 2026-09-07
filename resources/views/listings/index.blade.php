<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Available Rentals</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Search / Filter Form -->
            <form method="GET" action="{{ route('home') }}" class="bg-white shadow rounded-lg p-4 grid grid-cols-2 md:grid-cols-5 gap-3">
                <input type="text" name="city" placeholder="City" value="{{ request('city') }}"
                       class="border-gray-300 rounded col-span-2 md:col-span-1">

                <input type="number" name="min_price" placeholder="Min price" value="{{ request('min_price') }}"
                       class="border-gray-300 rounded">

                <input type="number" name="max_price" placeholder="Max price" value="{{ request('max_price') }}"
                       class="border-gray-300 rounded">

                <select name="bedrooms" class="border-gray-300 rounded">
                    <option value="">Any bedrooms</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" @selected(request('bedrooms') == $i)>{{ $i }}+ bed</option>
                    @endfor
                </select>

                <select name="property_type" class="border-gray-300 rounded">
                    <option value="">Any type</option>
                    @foreach (['apartment', 'house', 'condo', 'room', 'other'] as $type)
                        <option value="{{ $type }}" @selected(request('property_type') === $type)>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>

                <div class="col-span-2 md:col-span-5 flex justify-end gap-2">
                    <a href="{{ route('home') }}" class="px-4 py-2 border rounded">Clear</a>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded">Search</button>
                </div>
            </form>

            <!-- Results -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($units as $unit)
                    <a href="{{ route('listings.show', $unit) }}"
                       class="bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition">

                        @if ($unit->property->images->count())
                            <img src="{{ Storage::url($unit->property->images->first()->image_path) }}"
                                 class="h-40 w-full object-cover">
                        @else
                            <div class="h-40 w-full bg-gray-200 flex items-center justify-center text-gray-400">
                                No photo
                            </div>
                        @endif

                        <div class="p-4">
                            <p class="font-semibold">{{ $unit->property->title }} — {{ $unit->unit_name }}</p>
                            <p class="text-sm text-gray-500">{{ $unit->property->city }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $unit->bedrooms }} bed / {{ $unit->bathrooms }} bath
                            </p>
                            <p class="mt-2 font-bold text-gray-800">
                                ₱{{ number_format($unit->rent_price, 2) }}/mo
                            </p>
                        </div>
                    </a>
                @empty
                    <p class="col-span-3 text-gray-500 text-center py-8">
                        No available units match your search.
                    </p>
                @endforelse
            </div>

            <div>
                {{ $units->links() }}
            </div>
        </div>
    </div>
</x-app-layout>