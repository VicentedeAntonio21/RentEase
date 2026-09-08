<a href="{{ $href }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors whitespace-nowrap
   {{ $active
        ? 'bg-primary/10 text-primary'
        : 'text-gray-300 hover:bg-sidebar-hover hover:text-white' }}">
    <i class="{{ $icon }} text-lg shrink-0"></i>
    <span x-show="!collapsed">{{ $slot }}</span>
</a>