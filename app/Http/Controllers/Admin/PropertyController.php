<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('owner', 'units')
            ->latest()
            ->paginate(15);

        return view('admin.properties.index', compact('properties'));
    }

    public function destroy(Property $property)
    {
        foreach ($property->images as $image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
        }

        $property->delete();

        return back()->with('success', 'Property removed.');
    }
}