<x-app-layout>
    @section('title', 'My Applications')

    <div class="space-y-6">

        @if (session('success'))
            <div class="flex items-center gap-2 p-4 bg-success/10 text-success rounded-lg text-sm">
                <i class="ri-checkbox-circle-line text-lg"></i> {{ session('success') }}
            </div>
        @endif

        @if ($applications->isEmpty())
            <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-12 text-center">
                <i class="ri-file-list-3-line text-5xl text-gray-300 dark:text-gray-600"></i>
                <p class="mt-3 text-gray-500 dark:text-gray-400">You haven't applied to any units yet.</p>
                <a href="{{ route('home') }}" class="inline-block mt-3 text-primary text-sm font-medium">Browse listings</a>
            </div>
        @else
            <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 divide-y divide-gray-100 dark:divide-white/5">
                @foreach ($applications as $application)
                    <div class="p-5 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                <i class="ri-door-line"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="font-medium truncate">
                                    {{ $application->unit->property->title }} — {{ $application->unit->unit_name }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                    <i class="ri-calendar-line"></i>
                                    Move-in {{ \Carbon\Carbon::parse($application->move_in_date)->format('M d, Y') }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    Applied {{ $application->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                @class([
                                    'bg-warning/10 text-warning' => $application->status === 'pending',
                                    'bg-success/10 text-success' => $application->status === 'approved',
                                    'bg-danger/10 text-danger' => $application->status === 'rejected',
                                    'bg-gray-100 dark:bg-white/10 text-gray-500 dark:text-gray-400' => $application->status === 'cancelled',
                                ])">
                                {{ ucfirst($application->status) }}
                            </span>

                            @if ($application->status === 'pending')
                                <form action="{{ route('applications.cancel', $application) }}" method="POST"
                                      onsubmit="return confirm('Cancel this application?');">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-3 py-1.5 text-xs font-medium border border-gray-200 dark:border-white/10 rounded-lg text-gray-500 dark:text-gray-400 hover:border-danger hover:text-danger">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>