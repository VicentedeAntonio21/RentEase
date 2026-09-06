<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Unit</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded-lg p-6">
            <form action="{{ route('owner.units.update', $unit) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium">Unit Name</label>
                    <input type="text" name="unit_name" value="{{ old('unit_name', $unit->unit_name) }}" class="w-full border-gray-300 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Rent Price (₱)</label>
                    <input type="number" step="0.01" name="rent_price" value="{{ old('rent_price', $unit->rent_price) }}" class="w-full border-gray-300 rounded">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Bedrooms</label>
                        <input type="number" name="bedrooms" value="{{ old('bedrooms', $unit->bedrooms) }}" class="w-full border-gray-300 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Bathrooms</label>
                        <input type="number" name="bathrooms" value="{{ old('bathrooms', $unit->bathrooms) }}" class="w-full border-gray-300 rounded">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium">Area (sqm)</label>
                    <input type="number" step="0.01" name="area_sqm" value="{{ old('area_sqm', $unit->area_sqm) }}" class="w-full border-gray-300 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded">
                        @foreach (['available', 'occupied', 'maintenance'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $unit->status) === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('owner.properties.show', $unit->property) }}" class="px-4 py-2 border rounded">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded">Update Unit</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>