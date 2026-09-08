<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold">{{ $stats['total_users'] }}</p>
                    <p class="text-sm text-gray-500">Total Users</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold">{{ $stats['total_owners'] }}</p>
                    <p class="text-sm text-gray-500">Owners</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold">{{ $stats['total_tenants'] }}</p>
                    <p class="text-sm text-gray-500">Tenants</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold">{{ $stats['total_properties'] }}</p>
                    <p class="text-sm text-gray-500">Properties</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold">{{ $stats['total_units'] }}</p>
                    <p class="text-sm text-gray-500">Total Units</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold text-green-600">{{ $stats['available_units'] }}</p>
                    <p class="text-sm text-gray-500">Available</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold text-gray-600">{{ $stats['occupied_units'] }}</p>
                    <p class="text-sm text-gray-500">Occupied</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_applications'] }}</p>
                    <p class="text-sm text-gray-500">Pending Applications</p>
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-800 text-white rounded">Manage Users</a>
                <a href="{{ route('admin.properties.index') }}" class="px-4 py-2 bg-gray-800 text-white rounded">Manage Properties</a>
                <a href="{{ route('admin.applications.index') }}" class="px-4 py-2 bg-gray-800 text-white rounded">View Applications</a>
            </div>
        </div>
    </div>
</x-app-layout>