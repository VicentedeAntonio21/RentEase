<x-app-layout>
    @section('title', 'Manage Properties')

    <div class="space-y-6">

        @if (session('success'))
            <div class="flex items-center gap-2 p-4 bg-success/10 text-success rounded-lg text-sm">
                <i class="ri-checkbox-circle-line text-lg"></i> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 divide-y divide-gray-100 dark:divide-white/5">
            @foreach ($properties as $property)
                <div class="p-5 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
                            <i class="ri-building-4-line"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="font-medium truncate">{{ $property->title }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Owner: {{ $property->owner->name }} ({{ $property->owner->email }})
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-0.5">
                                <i class="ri-map-pin-line"></i> {{ $property->address }}, {{ $property->city }} &middot;
                                {{ $property->units->count() }} {{ Str::plural('unit', $property->units->count()) }}
                            </p>
                        </div>
                    </div>
                    <form action="{{ route('admin.properties.destroy', $property) }}" method="POST"
                          onsubmit="return confirm('Delete this property and all its units/applications?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1.5 text-sm font-medium border border-danger/20 rounded-lg text-danger hover:bg-danger/10 shrink-0">
                            Remove
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        {{ $properties->links() }}
    </div>
</x-app-layout>