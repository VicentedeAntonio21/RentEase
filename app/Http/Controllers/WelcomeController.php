<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Unit;

class WelcomeController extends Controller
{
    public function index()
    {
        $stats = [
            'available_units' => Unit::available()->count(),
            'total_properties' => Property::count(),
            'cities' => Property::distinct('city')->count('city'),
        ];

        return view('landing', compact('stats'));
    }
}