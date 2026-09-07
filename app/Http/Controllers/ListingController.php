<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $units = Unit::query()
            ->available()
            ->inCity($request->input('city'))
            ->priceBetween($request->input('min_price'), $request->input('max_price'))
            ->minBedrooms($request->input('bedrooms'))
            ->propertyType($request->input('property_type'))
            ->with('property.images')
            ->latest()
            ->paginate(9)
            ->withQueryString(); // keeps filters in pagination links

        return view('listings.index', compact('units'));
    }

    public function show(Unit $unit)
    {
        $unit->load('property.images', 'property.owner');

        return view('listings.show', compact('unit'));
    }
}