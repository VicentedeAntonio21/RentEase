<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $unit->property->title }} — {{ $unit->unit_name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($unit->property->images->count())
                <div class="grid grid-cols-3 gap-2">
                    @foreach ($unit->property->images as $image)
                        <img src="{{ Storage::url($image->image_path) }}" class="rounded h-48 w-full object-cover">
                    @endforeach
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6 space-y-3">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold">₱{{ number_format($unit->rent_price, 2) }}/mo</h3>
                        <p class="text-gray-500">
                            {{ $unit->property->address }}, {{ $unit->property->city }}
                        </p>
                    </div>
                    <span
                        class="px-3 py-1 rounded text-sm
                        {{ $unit->status === 'available' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                        {{ ucfirst($unit->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-4 text-center border-y py-4">
                    <div>
                        <p class="text-lg font-semibold">{{ $unit->bedrooms }}</p>
                        <p class="text-sm text-gray-500">Bedrooms</p>
                    </div>
                    <div>
                        <p class="text-lg font-semibold">{{ $unit->bathrooms }}</p>
                        <p class="text-sm text-gray-500">Bathrooms</p>
                    </div>
                    <div>
                        <p class="text-lg font-semibold">{{ $unit->area_sqm ?? '—' }}</p>
                        <p class="text-sm text-gray-500">sqm</p>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold mb-1">About this property</h4>
                    <p class="text-gray-700">{{ $unit->property->description ?? 'No description provided.' }}</p>
                </div>

                <div class="pt-4 border-t">
                    @auth
                        @if (auth()->user()->isTenant() && $unit->status === 'available')
                            <a href="{{ route('applications.create', $unit) }}"
                                class="inline-block px-6 py-2 bg-gray-800 text-white rounded">
                                Apply / Reserve This Unit
                            </a>
                            <p class="text-xs text-gray-400 mt-1">(Application form comes in Phase 5)</p>
                        @elseif (!auth()->user()->isTenant())
                            <p class="text-sm text-gray-500">Only tenant accounts can apply for units.</p>
                        @else
                            <p class="text-sm text-gray-500">This unit is not currently available.</p>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="inline-block px-6 py-2 bg-gray-800 text-white rounded">
                            Log in to Apply
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>