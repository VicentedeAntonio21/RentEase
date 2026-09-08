<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $ownerId = Auth::id();

        $properties = Property::where('owner_id', $ownerId)->with('units')->get();

        $totalUnits = $properties->sum(fn ($p) => $p->units->count());
        $occupiedUnits = $properties->sum(fn ($p) => $p->units->where('status', 'occupied')->count());
        $availableUnits = $properties->sum(fn ($p) => $p->units->where('status', 'available')->count());
        $maintenanceUnits = $totalUnits - $occupiedUnits - $availableUnits;

        $occupancyRate = $totalUnits > 0
            ? round(($occupiedUnits / $totalUnits) * 100, 1)
            : 0;

        $monthlyRevenue = $properties->sum(
            fn ($p) => $p->units->where('status', 'occupied')->sum('rent_price')
        );

        $potentialRevenue = $properties->sum(
            fn ($p) => $p->units->sum('rent_price')
        );

        $applicationsByStatus = Application::whereHas('unit.property', function ($q) use ($ownerId) {
            $q->where('owner_id', $ownerId);
        })
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Per-property breakdown for the table
        $propertyBreakdown = $properties->map(function ($property) {
            $total = $property->units->count();
            $occupied = $property->units->where('status', 'occupied')->count();

            return [
                'title' => $property->title,
                'total_units' => $total,
                'occupied' => $occupied,
                'occupancy_rate' => $total > 0 ? round(($occupied / $total) * 100, 1) : 0,
                'revenue' => $property->units->where('status', 'occupied')->sum('rent_price'),
            ];
        });

        return view('owner.reports.index', [
            'totalUnits' => $totalUnits,
            'occupiedUnits' => $occupiedUnits,
            'availableUnits' => $availableUnits,
            'maintenanceUnits' => $maintenanceUnits,
            'occupancyRate' => $occupancyRate,
            'monthlyRevenue' => $monthlyRevenue,
            'potentialRevenue' => $potentialRevenue,
            'applicationsByStatus' => $applicationsByStatus,
            'propertyBreakdown' => $propertyBreakdown,
        ]);
    }
}