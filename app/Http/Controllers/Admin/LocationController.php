<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::with('parent')->latest()->paginate(15);
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        $parentLocations = Location::whereNull('parent_id')->orderBy('name')->get();
        return view('admin.locations.create', compact('parentLocations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:locations,slug',
            'parent_id' => 'nullable|exists:locations,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Location::create($validated);

        return redirect()->route('admin.locations.index')->with('success', 'موقعیت با موفقیت ایجاد شد');
    }

    public function edit(Location $location)
    {
        $parentLocations = Location::whereNull('parent_id')
            ->where('id', '!=', $location->id)
            ->orderBy('name')
            ->get();

        return view('admin.locations.edit', compact('location', 'parentLocations'));
    }

    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:locations,slug,' . $location->id,
            'parent_id' => 'nullable|exists:locations,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $location->update($validated);

        return redirect()->route('admin.locations.index')->with('success', 'موقعیت با موفقیت بروزرسانی شد');
    }

    public function destroy(Location $location)
    {
        Property::where('location_id', $location->id)->update(['location_id' => null]);
        $location->delete();

        return redirect()->route('admin.locations.index')->with('success', 'موقعیت با موفقیت حذف شد');
    }
}
