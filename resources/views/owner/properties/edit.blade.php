<x-app-layout>
    @section('title', 'Edit Property')

    <div class="max-w-2xl mx-auto space-y-6">

        <a href="{{ route('owner.properties.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-primary">
            <i class="ri-arrow-left-line"></i> Back to properties
        </a>

        <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-6">
            <h2 class="font-heading font-semibold text-lg mb-5">Edit Property</h2>

            <form action="{{ route('owner.properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <x-form-input name="title" label="Title" icon="ri-home-4-line" :value="$property->title" required />

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary">{{ old('description', $property->description) }}</textarea>
                </div>

                <x-form-input name="address" label="Address" icon="ri-map-pin-line" :value="$property->address" required />

                <div class="grid grid-cols-3 gap-4">
                    <x-form-input name="city" label="City" :value="$property->city" required />
                    <x-form-input name="province" label="Province" :value="$property->province" />
                    <x-form-input name="zip_code" label="Zip Code" :value="$property->zip_code" />
                </div>

                <div>
                    <label for="property_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Property Type</label>
                    <select id="property_type" name="property_type"
                            class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary">
                        @foreach (['apartment', 'house', 'condo', 'room', 'other'] as $type)
                            <option value="{{ $type }}" @selected(old('property_type', $property->property_type) === $type)>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($property->images->count())
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Photos</label>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach ($property->images as $image)
                                <img src="{{ Storage::url($image->image_path) }}" class="rounded-lg h-24 w-full object-cover">
                            @endforeach
                        </div>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Add More Photos <span class="text-gray-400 font-normal">(optional)</span>
                    </label>
                    <label for="images" class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-gray-200 dark:border-white/10 rounded-lg p-6 cursor-pointer hover:border-primary transition-colors">
                        <i class="ri-image-add-line text-3xl text-gray-400"></i>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Click to upload photos</span>
                        <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                    </label>
                </div>

                <div class="flex justify-end gap-2 pt-2 border-t border-gray-100 dark:border-white/5">
                    <a href="{{ route('owner.properties.index') }}"
                       class="px-4 py-2 border border-gray-200 dark:border-white/10 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-5 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark flex items-center gap-2">
                        <i class="ri-save-line"></i> Update Property
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>