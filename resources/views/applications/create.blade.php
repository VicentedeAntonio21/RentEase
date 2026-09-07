<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Apply for {{ $unit->unit_name }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded-lg p-6">

            <div class="mb-4 pb-4 border-b">
                <p class="font-semibold">{{ $unit->property->title }} — {{ $unit->unit_name }}</p>
                <p class="text-sm text-gray-500">{{ $unit->property->address }}, {{ $unit->property->city }}</p>
                <p class="text-sm text-gray-500">₱{{ number_format($unit->rent_price, 2) }}/mo</p>
            </div>

            <form action="{{ route('applications.store', $unit) }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium">Preferred Move-in Date</label>
                    <input type="date" name="move_in_date" value="{{ old('move_in_date') }}"
                           class="w-full border-gray-300 rounded">
                    @error('move_in_date') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Message to Owner (optional)</label>
                    <textarea name="message" rows="4" class="w-full border-gray-300 rounded"
                              placeholder="Introduce yourself, mention occupants, etc.">{{ old('message') }}</textarea>
                    @error('message') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('listings.show', $unit) }}" class="px-4 py-2 border rounded">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded">Submit Application</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>