<x-app-layout>
    @section('title', 'Reports')

    <div class="space-y-6">

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stat-card label="Total Units" :value="$totalUnits" icon="ri-home-4-line" color="primary" />
            <x-stat-card label="Occupancy Rate" :value="$occupancyRate . '%'" icon="ri-pie-chart-line" color="primary" />
            <x-stat-card label="Monthly Revenue" :value="'₱' . number_format($monthlyRevenue, 0)" icon="ri-wallet-3-line" color="success" />
            <x-stat-card label="Potential Revenue" :value="'₱' . number_format($potentialRevenue, 0)" icon="ri-line-chart-line" color="warning" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-6">
                <h3 class="font-heading font-semibold mb-4">Unit Status Breakdown</h3>
                <canvas id="unitStatusChart" height="220"></canvas>
            </div>

            <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-6">
                <h3 class="font-heading font-semibold mb-4">Applications by Status</h3>
                <canvas id="applicationsChart" height="220"></canvas>
            </div>
        </div>

        <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden">
            <h3 class="font-heading font-semibold p-5 border-b border-gray-100 dark:border-white/5">Per-Property Breakdown</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-white/5 text-left text-gray-500 dark:text-gray-400">
                        <tr>
                            <th class="p-4 font-medium">Property</th>
                            <th class="p-4 font-medium">Units</th>
                            <th class="p-4 font-medium">Occupied</th>
                            <th class="p-4 font-medium">Occupancy</th>
                            <th class="p-4 font-medium">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @forelse ($propertyBreakdown as $row)
                            <tr>
                                <td class="p-4 font-medium">{{ $row['title'] }}</td>
                                <td class="p-4 text-gray-500 dark:text-gray-400">{{ $row['total_units'] }}</td>
                                <td class="p-4 text-gray-500 dark:text-gray-400">{{ $row['occupied'] }}</td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary">
                                        {{ $row['occupancy_rate'] }}%
                                    </span>
                                </td>
                                <td class="p-4 font-medium">₱{{ number_format($row['revenue'], 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-500 dark:text-gray-400">No properties yet.</td>
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
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#B4BDD6' : '#6B7280';
        const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';

        new Chart(document.getElementById('unitStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Occupied', 'Available', 'Maintenance'],
                datasets: [{
                    data: [{{ $occupiedUnits }}, {{ $availableUnits }}, {{ $maintenanceUnits }}],
                    backgroundColor: ['#F1B44C', '#34C38F', '#F46A6A'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { labels: { color: textColor } } }
            }
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
                    backgroundColor: ['#F1B44C', '#34C38F', '#F46A6A', '#9CA3AF'],
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, color: textColor }, grid: { color: gridColor } },
                    x: { ticks: { color: textColor }, grid: { display: false } },
                }
            }
        });
    </script>
    @endpush
</x-app-layout>