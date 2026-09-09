<x-app-layout>
    @section('title', $property->title)

    <div class="max-w-4xl mx-auto space-y-6">

        <a href="{{ route('owner.properties.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-primary">
            <i class="ri-arrow-left-line"></i> Back to properties
        </a>

        @if (session('success'))
            <div class="flex items-center gap-2 p-4 bg-success/10 text-success rounded-lg text-sm">
                <i class="ri-checkbox-circle-line text-lg"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Property info card -->
        <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden">
            <div class="p-6 flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-medium text-primary uppercase tracking-wide">{{ $property->property_type }}</p>
                    <h1 class="font-heading text-xl font-bold mt-1">{{ $property->title }}</h1>
                    <p class="text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                        <i class="ri-map-pin-line"></i> {{ $property->address }}, {{ $property->city }}
                    </p>
                </div>
                <a href="{{ route('owner.properties.edit', $property) }}"
                   class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 border border-gray-200 dark:border-white/10 rounded-lg text-sm font-medium hover:border-primary hover:text-primary">
                    <i class="ri-edit-line"></i> Edit
                </a>
            </div>

            @if ($property->description)
                <p class="px-6 pb-6 text-gray-600 dark:text-gray-300">{{ $property->description }}</p>
            @endif

            @if ($property->images->count())
                <div class="grid grid-cols-4 gap-2 px-6 pb-6">
                    @foreach ($property->images as $image)
                        <img src="{{ Storage::url($image->image_path) }}" class="rounded-lg h-24 w-full object-cover">
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Units -->
        <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden">
            <div class="p-5 flex items-center justify-between border-b border-gray-100 dark:border-white/5">
                <h2 class="font-heading font-semibold">Units</h2>
                <a href="{{ route('owner.properties.units.create', $property) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark">
                    <i class="ri-add-line"></i> Add Unit
                </a>
            </div>

            <div class="divide-y divide-gray-100 dark:divide-white/5">
                @forelse ($property->units as $unit)
                    <div class="p-5 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                <i class="ri-door-line"></i>
                            </span>
                            <div>
                                <p class="font-medium">{{ $unit->unit_name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    ₱{{ number_format($unit->rent_price, 2) }}/mo &middot;
                                    {{ $unit->bedrooms }} bed / {{ $unit->bathrooms }} bath
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                @class([
                                    'bg-success/10 text-success' => $unit->status === 'available',
                                    'bg-gray-100 dark:bg-white/10 text-gray-500 dark:text-gray-400' => $unit->status === 'occupied',
                                    'bg-warning/10 text-warning' => $unit->status === 'maintenance',
                                ])">
                                {{ ucfirst($unit->status) }}
                            </span>

                            <a href="{{ route('owner.units.edit', $unit) }}" class="text-gray-400 hover:text-primary">
                                <i class="ri-edit-line text-lg"></i>
                            </a>
                            <form action="{{ route('owner.units.destroy', $unit) }}" method="POST"
                                  onsubmit="return confirm('Delete this unit?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-danger">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                        <i class="ri-door-line text-3xl text-gray-300 dark:text-gray-600"></i>
                        <p class="mt-2 text-sm">No units added yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>