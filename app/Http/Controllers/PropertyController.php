<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with(['location', 'type', 'status'])->get();

        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        $locations = Location::pluck('name', 'id')->toArray();
        $propertyTypes = PropertyType::pluck('name', 'id')->toArray();
        $propertyStatuses = PropertyStatus::pluck('name', 'id')->toArray();
        $users = User::pluck('name', 'id')->toArray();

        return view('properties.create', compact('locations', 'propertyTypes', 'propertyStatuses', 'users'));
    }

    public function store(StorePropertyRequest $request)
    {
        Property::create($request->validated());

        return redirect()->route('properties.index')->with('success', 'ملک با موفقیت ثبت شد');
    }

    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        return view('properties.edit', compact('property'));
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $property->update($request->validated());

        return redirect()->route('properties.index')->with('success', 'ملک با موفیقت به روزرسانی شد.');
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('properties.index')->with('success', 'ملک حذف شد');
    }
}
