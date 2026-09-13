@php
    $colorClasses = $confirmColor === 'danger'
        ? 'bg-danger hover:bg-red-600'
        : 'bg-primary hover:bg-primary-dark';
    $iconColorClasses = $confirmColor === 'danger'
        ? 'bg-danger/10 text-danger'
        : 'bg-primary/10 text-primary';
@endphp

<x-modal :name="$name" focusable>
    <div class="p-6">
        <div class="flex items-start gap-4">
            <span
                class="w-12 h-12 rounded-full {{ $iconColorClasses }} flex items-center justify-center shrink-0 animate-fade-in-up">
                <i class="{{ $icon }} text-2xl"></i>
            </span>
            <div class="animate-fade-in-up animate-delay-1">
                <h2 class="font-heading font-semibold text-lg">{{ $title }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1.5 leading-relaxed">{{ $message }}</p>
            </div>
        </div>

        <div class="mt-7 flex justify-end gap-2 pt-5 border-t border-gray-100 dark:border-white/5">
            <button type="button" x-on:click="$dispatch('close')"
                class="px-4 py-2 border border-gray-200 dark:border-white/10 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5">
                Cancel
            </button>
            {{ $slot }}
        </div>
    </div>
</x-modal>