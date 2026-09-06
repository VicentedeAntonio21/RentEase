<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Properties</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex justify-end">
                <a href="{{ route('owner.properties.create') }}"
                   class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                    + Add Property
                </a>
            </div>

            <div class="bg-white shadow rounded-lg divide-y">
                @forelse ($properties as $property)
                    <div class="p-4 flex justify-between items-center">
                        <div>
                            <a href="{{ route('owner.properties.show', $property) }}"
                               class="font-semibold text-lg hover:underline">
                                {{ $property->title }}
                            </a>
                            <p class="text-sm text-gray-600">
                                {{ $property->address }}, {{ $property->city }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $property->units->count() }} unit(s) &middot; {{ ucfirst($property->property_type) }}
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('owner.properties.edit', $property) }}"
                               class="px-3 py-1 text-sm bg-yellow-500 text-white rounded">Edit</a>
                            <form action="{{ route('owner.properties.destroy', $property) }}" method="POST"
                                  onsubmit="return confirm('Delete this property and all its units?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-sm bg-red-600 text-white rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="p-4 text-gray-500">You haven't added any properties yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>