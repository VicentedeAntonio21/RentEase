<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function create(Property $property)
    {
        abort_if($property->owner_id !== Auth::id(), 403);

        return view('owner.units.create', compact('property'));
    }

    public function store(Request $request, Property $property)
    {
        abort_if($property->owner_id !== Auth::id(), 403);

        $validated = $request->validate([
            'unit_name' => ['required', 'string', 'max:255'],
            'rent_price' => ['required', 'numeric', 'min:0'],
            'bedrooms' => ['required', 'integer', 'min:0'],
            'bathrooms' => ['required', 'integer', 'min:0'],
            'area_sqm' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:available,occupied,maintenance'],
        ]);

        $property->units()->create($validated);

        return redirect()
            ->route('owner.properties.show', $property)
            ->with('success', 'Unit added successfully.');
    }

    public function edit(Unit $unit)
    {
        abort_if($unit->property->owner_id !== Auth::id(), 403);

        return view('owner.units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        abort_if($unit->property->owner_id !== Auth::id(), 403);

        $validated = $request->validate([
            'unit_name' => ['required', 'string', 'max:255'],
            'rent_price' => ['required', 'numeric', 'min:0'],
            'bedrooms' => ['required', 'integer', 'min:0'],
            'bathrooms' => ['required', 'integer', 'min:0'],
            'area_sqm' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:available,occupied,maintenance'],
        ]);

        $unit->update($validated);

        return redirect()
            ->route('owner.properties.show', $unit->property)
            ->with('success', 'Unit updated successfully.');
    }

    public function destroy(Unit $unit)
    {
        abort_if($unit->property->owner_id !== Auth::id(), 403);

        $property = $unit->property;
        $unit->delete();

        return redirect()
            ->route('owner.properties.show', $property)
            ->with('success', 'Unit deleted.');
    }
}