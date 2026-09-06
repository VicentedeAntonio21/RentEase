<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Unit to {{ $property->title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded-lg p-6">
            <form action="{{ route('owner.properties.units.store', $property) }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium">Unit Name</label>
                    <input type="text" name="unit_name" value="{{ old('unit_name') }}" class="w-full border-gray-300 rounded">
                    @error('unit_name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Rent Price (₱)</label>
                    <input type="number" step="0.01" name="rent_price" value="{{ old('rent_price') }}" class="w-full border-gray-300 rounded">
                    @error('rent_price') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Bedrooms</label>
                        <input type="number" name="bedrooms" value="{{ old('bedrooms', 1) }}" class="w-full border-gray-300 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Bathrooms</label>
                        <input type="number" name="bathrooms" value="{{ old('bathrooms', 1) }}" class="w-full border-gray-300 rounded">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium">Area (sqm, optional)</label>
                    <input type="number" step="0.01" name="area_sqm" value="{{ old('area_sqm') }}" class="w-full border-gray-300 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded">
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('owner.properties.show', $property) }}" class="px-4 py-2 border rounded">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded">Save Unit</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>