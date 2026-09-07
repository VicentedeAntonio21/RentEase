<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Applications</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg divide-y">
                @forelse ($applications as $application)
                    <div class="p-4 flex justify-between items-center">
                        <div>
                            <p class="font-semibold">
                                {{ $application->unit->property->title }} — {{ $application->unit->unit_name }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Move-in: {{ \Carbon\Carbon::parse($application->move_in_date)->format('M d, Y') }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Applied {{ $application->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded text-sm
                                @class([
                                    'bg-yellow-100 text-yellow-700' => $application->status === 'pending',
                                    'bg-green-100 text-green-700' => $application->status === 'approved',
                                    'bg-red-100 text-red-700' => $application->status === 'rejected',
                                    'bg-gray-100 text-gray-600' => $application->status === 'cancelled',
                                ])">
                                {{ ucfirst($application->status) }}
                            </span>

                            @if ($application->status === 'pending')
                                <form action="{{ route('applications.cancel', $application) }}" method="POST"
                                      onsubmit="return confirm('Cancel this application?');">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-3 py-1 text-sm bg-gray-200 rounded">Cancel</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="p-4 text-gray-500">You haven't applied to any units yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>