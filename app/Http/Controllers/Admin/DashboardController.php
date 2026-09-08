<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Property;
use App\Models\Unit;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_owners' => User::where('role', 'owner')->count(),
            'total_tenants' => User::where('role', 'tenant')->count(),
            'total_properties' => Property::count(),
            'total_units' => Unit::count(),
            'available_units' => Unit::where('status', 'available')->count(),
            'occupied_units' => Unit::where('status', 'occupied')->count(),
            'pending_applications' => Application::where('status', 'pending')->count(),
            'approved_applications' => Application::where('status', 'approved')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}