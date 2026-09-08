<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Properties</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg divide-y">
                @foreach ($properties as $property)
                    <div class="p-4 flex justify-between items-center">
                        <div>
                            <p class="font-semibold">{{ $property->title }}</p>
                            <p class="text-sm text-gray-500">
                                Owner: {{ $property->owner->name }} ({{ $property->owner->email }})
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $property->address }}, {{ $property->city }} &middot;
                                {{ $property->units->count() }} unit(s)
                            </p>
                        </div>
                        <form action="{{ route('admin.properties.destroy', $property) }}" method="POST"
                              onsubmit="return confirm('Delete this property and all its units/applications?');">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 text-sm bg-red-600 text-white rounded">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>

            {{ $properties->links() }}
        </div>
    </div>
</x-app-layout>