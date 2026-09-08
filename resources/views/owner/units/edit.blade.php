<x-app-layout>
    @section('title', 'Edit Unit')

    <div class="max-w-xl mx-auto space-y-6">

        <a href="{{ route('owner.properties.show', $unit->property) }}" class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-primary">
            <i class="ri-arrow-left-line"></i> Back to {{ $unit->property->title }}
        </a>

        <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-6">
            <h2 class="font-heading font-semibold text-lg mb-5">Edit Unit</h2>

            <form action="{{ route('owner.units.update', $unit) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <x-form-input name="unit_name" label="Unit Name" icon="ri-door-line" :value="$unit->unit_name" required />

                <x-form-input name="rent_price" label="Rent Price (₱)" type="number" step="0.01"
                              icon="ri-money-peso-circle-line" :value="$unit->rent_price" required />

                <div class="grid grid-cols-2 gap-4">
                    <x-form-input name="bedrooms" label="Bedrooms" type="number" :value="$unit->bedrooms" required />
                    <x-form-input name="bathrooms" label="Bathrooms" type="number" :value="$unit->bathrooms" required />
                </div>

                <x-form-input name="area_sqm" label="Area (sqm)" type="number" step="0.01" :value="$unit->area_sqm" />

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select id="status" name="status"
                            class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary">
                        @foreach (['available', 'occupied', 'maintenance'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $unit->status) === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-2 border-t border-gray-100 dark:border-white/5">
                    <a href="{{ route('owner.properties.show', $unit->property) }}"
                       class="px-4 py-2 border border-gray-200 dark:border-white/10 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-5 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark flex items-center gap-2">
                        <i class="ri-save-line"></i> Update Unit
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>