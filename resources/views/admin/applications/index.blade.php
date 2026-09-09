<x-app-layout>
    @section('title', 'All Applications')

    <div class="space-y-6">

        <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 divide-y divide-gray-100 dark:divide-white/5">
            @foreach ($applications as $application)
                <div class="p-5 flex items-center justify-between gap-4">
                    <div class="min-w-0">
                        <p class="font-medium truncate">
                            {{ $application->unit->property->title }} — {{ $application->unit->unit_name }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Tenant: {{ $application->tenant->name }} &middot;
                            Owner: {{ $application->unit->property->owner->name }}
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                            Applied {{ $application->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <span class="shrink-0 px-2.5 py-1 rounded-full text-xs font-medium
                        @class([
                            'bg-warning/10 text-warning' => $application->status === 'pending',
                            'bg-success/10 text-success' => $application->status === 'approved',
                            'bg-danger/10 text-danger' => $application->status === 'rejected',
                            'bg-gray-100 dark:bg-white/10 text-gray-500 dark:text-gray-400' => $application->status === 'cancelled',
                        ])">
                        {{ ucfirst($application->status) }}
                    </span>
                </div>
            @endforeach
        </div>

        {{ $applications->links() }}
    </div>
</x-app-layout>