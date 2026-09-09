<x-app-layout>
    @section('title', 'Applications Received')

    <div class="space-y-6">

        @if (session('success'))
            <div class="flex items-center gap-2 p-4 bg-success/10 text-success rounded-lg text-sm">
                <i class="ri-checkbox-circle-line text-lg"></i> {{ session('success') }}
            </div>
        @endif

        @if ($applications->isEmpty())
            <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-12 text-center">
                <i class="ri-inbox-archive-line text-5xl text-gray-300 dark:text-gray-600"></i>
                <p class="mt-3 text-gray-500 dark:text-gray-400">No applications received yet.</p>
            </div>
        @else
            <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 divide-y divide-gray-100 dark:divide-white/5">
                @foreach ($applications as $application)
                    <div class="p-5 flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3 min-w-0">
                            <span class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0 font-heading font-semibold">
                                {{ strtoupper(substr($application->tenant->name, 0, 1)) }}
                            </span>
                            <div class="min-w-0">
                                <p class="font-medium">
                                    {{ $application->unit->property->title }} — {{ $application->unit->unit_name }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $application->tenant->name }} &middot; {{ $application->tenant->email }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-0.5">
                                    <i class="ri-calendar-line"></i>
                                    Move-in {{ \Carbon\Carbon::parse($application->move_in_date)->format('M d, Y') }}
                                </p>
                                @if ($application->message)
                                    <p class="text-sm text-gray-600 dark:text-gray-300 italic mt-2 bg-gray-50 dark:bg-white/5 rounded-lg p-2.5">
                                        "{{ $application->message }}"
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
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
                                <form action="{{ route('owner.applications.approve', $application) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-success/10 text-success hover:bg-success hover:text-white" title="Approve">
                                        <i class="ri-check-line"></i>
                                    </button>
                                </form>
                                <form action="{{ route('owner.applications.reject', $application) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-danger/10 text-danger hover:bg-danger hover:text-white" title="Reject">
                                        <i class="ri-close-line"></i>
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