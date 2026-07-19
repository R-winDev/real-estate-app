<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with(['location', 'type', 'status']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('address_fa', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        $properties = $query->latest()->paginate(12)->withQueryString();

        $propertyTypes = PropertyType::all();
        $locations = Location::whereNull('parent_id')->get();

        return view('properties.index', compact('properties', 'propertyTypes', 'locations'));
    }

    public function create()
    {
        $locations = Location::pluck('name', 'id')->toArray();
        $propertyTypes = PropertyType::pluck('name_fa', 'id')->toArray();
        $propertyStatuses = PropertyStatus::pluck('name_fa', 'id')->toArray();
        $users = User::pluck('name', 'id')->toArray();

        return view('properties.create', compact('locations', 'propertyTypes', 'propertyStatuses', 'users'));
    }

    public function store(StorePropertyRequest $request)
    {
        $property = Property::create($request->validated());

        return redirect()->route('properties.show', $property)->with('success', 'ملک با موفقیت ثبت شد');
    }

    public function show(Property $property)
    {
        $property->load('location', 'type', 'status', 'owner');

        return view('properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        $locations = Location::pluck('name', 'id')->toArray();
        $propertyTypes = PropertyType::pluck('name_fa', 'id')->toArray();
        $propertyStatuses = PropertyStatus::pluck('name_fa', 'id')->toArray();
        $users = User::pluck('name', 'id')->toArray();

        return view('properties.edit', compact('property', 'locations', 'propertyTypes', 'propertyStatuses', 'users'));
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $property->update($request->validated());

        return redirect()->route('properties.show', $property)->with('success', 'ملک با موفقیت بروزرسانی شد');
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('properties.index')->with('success', 'ملک با موفقیت حذف شد');
    }
}
