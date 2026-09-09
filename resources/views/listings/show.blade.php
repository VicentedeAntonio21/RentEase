<x-app-layout>
    @section('title', $unit->property->title)

    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Back link -->
        <a href="{{ url()->previous() === url()->current() ? route('listings.index') : url()->previous() }}"
           class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-primary">
            <i class="ri-arrow-left-line"></i> Back to listings
        </a>

        <!-- Image gallery -->
        @if ($unit->property->images->count())
            <div class="grid grid-cols-3 gap-2 rounded-xl overflow-hidden">
                @foreach ($unit->property->images->take(3) as $image)
                    <img src="{{ Storage::url($image->image_path) }}"
                         class="h-56 w-full object-cover {{ $loop->first ? 'col-span-3 sm:col-span-1' : '' }}">
                @endforeach
            </div>
        @else
            <div class="h-56 rounded-xl bg-gray-100 dark:bg-white/5 flex items-center justify-center text-gray-300 dark:text-gray-600">
                <i class="ri-image-line text-5xl"></i>
            </div>
        @endif

        <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-6 space-y-5">

            <!-- Header -->
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-medium text-primary uppercase tracking-wide">
                        {{ $unit->property->property_type }}
                    </p>
                    <h1 class="font-heading text-2xl font-bold text-gray-800 dark:text-white mt-1">
                        {{ $unit->property->title }} — {{ $unit->unit_name }}
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                        <i class="ri-map-pin-line"></i> {{ $unit->property->address }}, {{ $unit->property->city }}
                    </p>
                </div>

                <span class="shrink-0 px-3 py-1.5 rounded-full text-xs font-medium
                    {{ $unit->status === 'available'
                        ? 'bg-success/10 text-success'
                        : 'bg-gray-100 dark:bg-white/10 text-gray-500 dark:text-gray-400' }}">
                    {{ ucfirst($unit->status) }}
                </span>
            </div>

            <p class="font-heading text-3xl font-bold text-primary">
                ₱{{ number_format($unit->rent_price, 2) }}<span class="text-base font-normal text-gray-400">/mo</span>
            </p>

            <!-- Quick stats -->
            <div class="grid grid-cols-3 gap-4 py-4 border-y border-gray-100 dark:border-white/5">
                <div class="text-center">
                    <i class="ri-hotel-bed-line text-2xl text-primary"></i>
                    <p class="mt-1 font-heading font-semibold">{{ $unit->bedrooms }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Bedrooms</p>
                </div>
                <div class="text-center">
                    <i class="ri-drop-line text-2xl text-primary"></i>
                    <p class="mt-1 font-heading font-semibold">{{ $unit->bathrooms }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Bathrooms</p>
                </div>
                <div class="text-center">
                    <i class="ri-ruler-line text-2xl text-primary"></i>
                    <p class="mt-1 font-heading font-semibold">{{ $unit->area_sqm ?? '—' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">sqm</p>
                </div>
            </div>

            <!-- Description -->
            <div>
                <h2 class="font-heading font-semibold mb-2">About this property</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    {{ $unit->property->description ?? 'No description provided.' }}
                </p>
            </div>

            <!-- Owner -->
            <div class="flex items-center gap-3 pt-2">
                <span class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-heading font-semibold">
                    {{ strtoupper(substr($unit->property->owner->name, 0, 1)) }}
                </span>
                <div>
                    <p class="text-sm font-medium">{{ $unit->property->owner->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Property Owner</p>
                </div>
            </div>

            <!-- CTA -->
            <div class="pt-4 border-t border-gray-100 dark:border-white/5">
                @auth
                    @if (auth()->user()->isTenant() && $unit->status === 'available')
                        <a href="{{ route('applications.create', $unit) }}"
                           class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary text-white rounded-lg font-medium text-sm hover:bg-primary-dark">
                            <i class="ri-file-add-line"></i> Apply / Reserve This Unit
                        </a>
                    @elseif (! auth()->user()->isTenant())
                        <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                            <i class="ri-information-line"></i> Only tenant accounts can apply.
                        </p>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                            <i class="ri-information-line"></i> This unit is not currently available.
                        </p>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary text-white rounded-lg font-medium text-sm hover:bg-primary-dark">
                        <i class="ri-login-box-line"></i> Log in to Apply
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>