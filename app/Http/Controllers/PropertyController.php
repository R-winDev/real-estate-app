<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use Illuminate\Http\Request;

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

        return view('properties.create', compact('locations', 'propertyTypes', 'propertyStatuses'));
    }

    public function store(Request $request)
    {
        Property::create($request->all());
        return redirect()->route('properties.index');
    }
}
