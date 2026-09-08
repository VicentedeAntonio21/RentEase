<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Reports</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Stat Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold">{{ $totalUnits }}</p>
                    <p class="text-sm text-gray-500">Total Units</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold text-blue-600">{{ $occupancyRate }}%</p>
                    <p class="text-sm text-gray-500">Occupancy Rate</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold text-green-600">₱{{ number_format($monthlyRevenue, 0) }}</p>
                    <p class="text-sm text-gray-500">Current Monthly Revenue</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold text-gray-400">₱{{ number_format($potentialRevenue, 0) }}</p>
                    <p class="text-sm text-gray-500">Potential (if fully occupied)</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Unit status chart -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Unit Status Breakdown</h3>
                    <canvas id="unitStatusChart" height="200"></canvas>
                </div>

                <!-- Applications chart -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Applications by Status</h3>
                    <canvas id="applicationsChart" height="200"></canvas>
                </div>
            </div>

            <!-- Per-property table -->
            <div class="bg-white shadow rounded-lg overflow-x-auto">
                <h3 class="font-semibold p-4 border-b">Per-Property Breakdown</h3>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="p-3">Property</th>
                            <th class="p-3">Units</th>
                            <th class="p-3">Occupied</th>
                            <th class="p-3">Occupancy Rate</th>
                            <th class="p-3">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($propertyBreakdown as $row)
                            <tr>
                                <td class="p-3">{{ $row['title'] }}</td>
                                <td class="p-3">{{ $row['total_units'] }}</td>
                                <td class="p-3">{{ $row['occupied'] }}</td>
                                <td class="p-3">{{ $row['occupancy_rate'] }}%</td>
                                <td class="p-3">₱{{ number_format($row['revenue'], 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-gray-500 text-center">No properties yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('unitStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Occupied', 'Available', 'Maintenance'],
                datasets: [{
                    data: [{{ $occupiedUnits }}, {{ $availableUnits }}, {{ $maintenanceUnits }}],
                    backgroundColor: ['#4b5563', '#22c55e', '#f59e0b'],
                }]
            },
            options: { responsive: true }
        });

        new Chart(document.getElementById('applicationsChart'), {
            type: 'bar',
            data: {
                labels: ['Pending', 'Approved', 'Rejected', 'Cancelled'],
                datasets: [{
                    label: 'Applications',
                    data: [
                        {{ $applicationsByStatus['pending'] ?? 0 }},
                        {{ $applicationsByStatus['approved'] ?? 0 }},
                        {{ $applicationsByStatus['rejected'] ?? 0 }},
                        {{ $applicationsByStatus['cancelled'] ?? 0 }},
                    ],
                    backgroundColor: ['#eab308', '#22c55e', '#ef4444', '#9ca3af'],
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
    </script>
    @endpush
</x-app-layout>