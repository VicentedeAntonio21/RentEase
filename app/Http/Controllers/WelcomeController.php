<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Unit;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'available_units' => Unit::available()->count(),
            'total_properties' => Property::count(),
            'cities' => Property::distinct('city')->count('city'),
        ];

        $city = $request->input('city');

        $featuredUnits = Unit::available()
            ->inCity($city)
            ->with('property.images')
            ->latest()
            ->take(3)
            ->get();

        return view('landing', compact('stats', 'featuredUnits', 'city'));
    }
}