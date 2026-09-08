<x-app-layout>
    @section('title', 'Admin Overview')

    <div class="space-y-6">

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stat-card label="Total Users" :value="$stats['total_users']" icon="ri-team-line" color="primary" />
            <x-stat-card label="Owners" :value="$stats['total_owners']" icon="ri-user-star-line" color="primary" />
            <x-stat-card label="Tenants" :value="$stats['total_tenants']" icon="ri-user-line" color="primary" />
            <x-stat-card label="Properties" :value="$stats['total_properties']" icon="ri-building-4-line" color="primary" />
            <x-stat-card label="Total Units" :value="$stats['total_units']" icon="ri-home-4-line" color="primary" />
            <x-stat-card label="Available" :value="$stats['available_units']" icon="ri-checkbox-circle-line" color="success" />
            <x-stat-card label="Occupied" :value="$stats['occupied_units']" icon="ri-user-follow-line" color="warning" />
            <x-stat-card label="Pending Applications" :value="$stats['pending_applications']" icon="ri-time-line" color="danger" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="{{ route('admin.users.index') }}" class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-5 text-center hover:shadow-md transition-shadow">
                <i class="ri-team-line text-3xl text-primary"></i>
                <p class="mt-2 font-heading font-semibold">Manage Users</p>
            </a>
            <a href="{{ route('admin.properties.index') }}" class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-5 text-center hover:shadow-md transition-shadow">
                <i class="ri-building-line text-3xl text-primary"></i>
                <p class="mt-2 font-heading font-semibold">Manage Properties</p>
            </a>
            <a href="{{ route('admin.applications.index') }}" class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-5 text-center hover:shadow-md transition-shadow">
                <i class="ri-file-list-line text-3xl text-primary"></i>
                <p class="mt-2 font-heading font-semibold">View Applications</p>
            </a>
        </div>
    </div>
</x-app-layout>