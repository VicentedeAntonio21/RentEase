<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        {{ $label }} @if ($required)<span class="text-danger">*</span>@endif
    </label>

    <div class="relative">
        @if ($icon)
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                <i class="{{ $icon }}"></i>
            </span>
        @endif

        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            @if ($step) step="{{ $step }}" @endif
            {{ $attributes->merge([
                'class' => 'w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary'
                    . ($icon ? ' pl-10' : '')
            ]) }}>
    </div>

    @error($name)
        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
    @enderror
</div>