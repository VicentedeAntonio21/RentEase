@php
    $colorMap = [
        'primary' => 'bg-primary/10 text-primary',
        'success' => 'bg-success/10 text-success',
        'warning' => 'bg-warning/10 text-warning',
        'danger' => 'bg-danger/10 text-danger',
    ];
@endphp

<div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-5 flex items-center justify-between">
    <div>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $label }}</p>
        <p class="mt-1 text-2xl font-heading font-bold text-gray-800 dark:text-white">{{ $value }}</p>
    </div>
    <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $colorMap[$color] }}">
        <i class="{{ $icon }} text-2xl"></i>
    </div>
</div>