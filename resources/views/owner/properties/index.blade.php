<x-app-layout>
    @section('title', 'My Properties')

    <div class="space-y-6">

        @if (session('success'))
            <div class="flex items-center gap-2 p-4 bg-success/10 text-success rounded-lg text-sm">
                <i class="ri-checkbox-circle-line text-lg"></i> {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $properties->count() }} {{ Str::plural('property', $properties->count()) }}
            </p>
            <a href="{{ route('owner.properties.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark">
                <i class="ri-add-line"></i> Add Property
            </a>
        </div>

        @if ($properties->isEmpty())
            <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-12 text-center">
                <i class="ri-building-4-line text-5xl text-gray-300 dark:text-gray-600"></i>
                <p class="mt-3 text-gray-500 dark:text-gray-400">You haven't added any properties yet.</p>
                <a href="{{ route('owner.properties.create') }}" class="inline-block mt-3 text-primary text-sm font-medium">
                    Add your first property
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($properties as $property)
                    <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden">

                        <a href="{{ route('owner.properties.show', $property) }}" class="block relative h-36 bg-gray-100 dark:bg-white/5">
                            @if ($property->images->count())
                                <img src="{{ Storage::url($property->images->first()->image_path) }}" class="h-full w-full object-cover">
                            @else
                                <div class="h-full w-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                                    <i class="ri-image-line text-3xl"></i>
                                </div>
                            @endif
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-xs font-medium bg-white/95 dark:bg-[#1E2235]/95 capitalize">
                                {{ $property->property_type }}
                            </span>
                        </a>

                        <div class="p-4">
                            <a href="{{ route('owner.properties.show', $property) }}" class="font-heading font-semibold hover:text-primary">
                                {{ $property->title }}
                            </a>
                            <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-0.5">
                                <i class="ri-map-pin-line"></i> {{ $property->city }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                <i class="ri-door-line"></i> {{ $property->units->count() }} {{ Str::plural('unit', $property->units->count()) }}
                            </p>

                            <div class="flex items-center gap-2 mt-4 pt-4 border-t border-gray-100 dark:border-white/5">
                                <a href="{{ route('owner.properties.edit', $property) }}"
                                   class="flex-1 text-center px-3 py-1.5 text-sm font-medium border border-gray-200 dark:border-white/10 rounded-lg text-gray-600 dark:text-gray-300 hover:border-primary hover:text-primary">
                                    Edit
                                </a>
                                <form action="{{ route('owner.properties.destroy', $property) }}" method="POST"
                                      onsubmit="return confirm('Delete this property and all its units?');" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full px-3 py-1.5 text-sm font-medium border border-danger/20 rounded-lg text-danger hover:bg-danger/10">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>