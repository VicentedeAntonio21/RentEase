<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Property</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded-lg p-6">

            <form action="{{ route('owner.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="w-full border-gray-300 rounded">
                    @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Description</label>
                    <textarea name="description" class="w-full border-gray-300 rounded">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Address</label>
                    <input type="text" name="address" value="{{ old('address') }}"
                           class="w-full border-gray-300 rounded">
                    @error('address') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">City</label>
                        <input type="text" name="city" value="{{ old('city') }}"
                               class="w-full border-gray-300 rounded">
                        @error('city') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Province</label>
                        <input type="text" name="province" value="{{ old('province') }}"
                               class="w-full border-gray-300 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Zip Code</label>
                        <input type="text" name="zip_code" value="{{ old('zip_code') }}"
                               class="w-full border-gray-300 rounded">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium">Property Type</label>
                    <select name="property_type" class="w-full border-gray-300 rounded">
                        <option value="apartment">Apartment</option>
                        <option value="house">House</option>
                        <option value="condo">Condo</option>
                        <option value="room">Room</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Photos (optional, multiple allowed)</label>
                    <input type="file" name="images[]" multiple accept="image/*"
                           class="w-full border-gray-300 rounded">
                    @error('images.*') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('owner.properties.index') }}" class="px-4 py-2 border rounded">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded">Save Property</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>