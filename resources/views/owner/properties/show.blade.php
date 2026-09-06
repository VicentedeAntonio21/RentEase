<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $property->title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-gray-700">{{ $property->description }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ $property->address }}, {{ $property->city }}</p>

                @if ($property->images->count())
                    <div class="grid grid-cols-4 gap-2 mt-4">
                        @foreach ($property->images as $image)
                            <img src="{{ Storage::url($image->image_path) }}" class="rounded h-32 w-full object-cover">
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-lg">Units</h3>
                    <a href="{{ route('owner.properties.units.create', $property) }}"
                       class="px-3 py-1 bg-gray-800 text-white rounded text-sm">+ Add Unit</a>
                </div>

                <div class="divide-y">
                    @forelse ($property->units as $unit)
                        <div class="py-3 flex justify-between items-center">
                            <div>
                                <p class="font-medium">{{ $unit->unit_name }}</p>
                                <p class="text-sm text-gray-500">
                                    ₱{{ number_format($unit->rent_price, 2) }} &middot;
                                    {{ $unit->bedrooms }} bed / {{ $unit->bathrooms }} bath &middot;
                                    <span class="capitalize">{{ $unit->status }}</span>
                                </p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('owner.units.edit', $unit) }}"
                                   class="px-3 py-1 text-sm bg-yellow-500 text-white rounded">Edit</a>
                                <form action="{{ route('owner.units.destroy', $unit) }}" method="POST"
                                      onsubmit="return confirm('Delete this unit?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 text-sm bg-red-600 text-white rounded">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 py-3">No units added yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>