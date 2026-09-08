<a href="{{ route('listings.show', $unit) }}"
   class="group bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden hover:shadow-md transition-shadow">

    <div class="relative h-44 bg-gray-100 dark:bg-white/5">
        @if ($unit->property->images->count())
            <img src="{{ Storage::url($unit->property->images->first()->image_path) }}"
                 class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="h-full w-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                <i class="ri-image-line text-4xl"></i>
            </div>
        @endif

        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-xs font-medium bg-white/95 dark:bg-[#1E2235]/95 text-gray-700 dark:text-gray-200 capitalize">
            {{ $unit->property->property_type }}
        </span>
    </div>

    <div class="p-4">
        <p class="font-heading font-semibold text-gray-800 dark:text-white truncate">
            {{ $unit->property->title }} — {{ $unit->unit_name }}
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-0.5">
            <i class="ri-map-pin-line"></i> {{ $unit->property->city }}
        </p>

        <div class="flex items-center gap-3 mt-3 text-sm text-gray-500 dark:text-gray-400">
            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line"></i> {{ $unit->bedrooms }}</span>
            <span class="flex items-center gap-1"><i class="ri-drop-line"></i> {{ $unit->bathrooms }}</span>
            @if ($unit->area_sqm)
                <span class="flex items-center gap-1"><i class="ri-ruler-line"></i> {{ $unit->area_sqm }} sqm</span>
            @endif
        </div>

        <p class="mt-3 font-heading font-bold text-primary">
            ₱{{ number_format($unit->rent_price, 2) }}<span class="text-sm font-normal text-gray-400">/mo</span>
        </p>
    </div>
</a>