<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::where('owner_id', Auth::id())
            ->with('units', 'images')
            ->latest()
            ->get();

        return view('owner.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('owner.properties.create');
    }

    public function store(StorePropertyRequest $request)
    {
        $property = Auth::user()->properties()->create($request->validated());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $property->images()->create(['image_path' => $path]);
            }
        }

        return redirect()
            ->route('owner.properties.index')
            ->with('success', 'Property created successfully.');
    }

    public function show(Property $property)
    {
        abort_if($property->owner_id !== Auth::id(), 403);

        $property->load('units', 'images');

        return view('owner.properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        abort_if($property->owner_id !== Auth::id(), 403);

        return view('owner.properties.edit', compact('property'));
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $property->update($request->validated());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $property->images()->create(['image_path' => $path]);
            }
        }

        return redirect()
            ->route('owner.properties.index')
            ->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        abort_if($property->owner_id !== Auth::id(), 403);

        foreach ($property->images as $image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
        }

        $property->delete(); // units, images, applications cascade-delete via DB

        return redirect()
            ->route('owner.properties.index')
            ->with('success', 'Property deleted.');
    }
}