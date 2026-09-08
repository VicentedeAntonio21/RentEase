<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">All Applications</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="bg-white shadow rounded-lg divide-y">
                @foreach ($applications as $application)
                    <div class="p-4 flex justify-between items-center">
                        <div>
                            <p class="font-semibold">
                                {{ $application->unit->property->title }} — {{ $application->unit->unit_name }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Tenant: {{ $application->tenant->name }} &middot;
                                Owner: {{ $application->unit->property->owner->name }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Applied {{ $application->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded text-sm
                            @class([
                                'bg-yellow-100 text-yellow-700' => $application->status === 'pending',
                                'bg-green-100 text-green-700' => $application->status === 'approved',
                                'bg-red-100 text-red-700' => $application->status === 'rejected',
                                'bg-gray-100 text-gray-600' => $application->status === 'cancelled',
                            ])">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                @endforeach
            </div>

            {{ $applications->links() }}
        </div>
    </div>
</x-app-layout>