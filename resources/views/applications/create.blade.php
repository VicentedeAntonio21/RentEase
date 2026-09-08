<x-app-layout>
    @section('title', 'Apply for ' . $unit->unit_name)

    <div class="max-w-xl mx-auto space-y-6">

        <a href="{{ route('listings.show', $unit) }}" class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-primary">
            <i class="ri-arrow-left-line"></i> Back to listing
        </a>

        <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden">

            <!-- Unit summary -->
            <div class="p-5 bg-primary/5 dark:bg-primary/10 border-b border-gray-100 dark:border-white/5">
                <p class="font-heading font-semibold">{{ $unit->property->title }} — {{ $unit->unit_name }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                    <i class="ri-map-pin-line"></i> {{ $unit->property->address }}, {{ $unit->property->city }}
                </p>
                <p class="text-primary font-heading font-bold mt-2">₱{{ number_format($unit->rent_price, 2) }}/mo</p>
            </div>

            <form action="{{ route('applications.store', $unit) }}" method="POST" class="p-6 space-y-5">
                @csrf

                <x-form-input
                    name="move_in_date"
                    label="Preferred Move-in Date"
                    type="date"
                    icon="ri-calendar-line"
                    required />

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Message to Owner <span class="text-gray-400 font-normal">(optional)</span>
                    </label>
                    <textarea id="message" name="message" rows="4"
                              placeholder="Introduce yourself, mention occupants, etc."
                              class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary">{{ old('message') }}</textarea>
                    @error('message') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <a href="{{ route('listings.show', $unit) }}"
                       class="px-4 py-2 border border-gray-200 dark:border-white/10 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-5 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark flex items-center gap-2">
                        <i class="ri-send-plane-line"></i> Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>