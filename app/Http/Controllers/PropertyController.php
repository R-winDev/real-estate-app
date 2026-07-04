<?php

namespace App\Http\Controllers;

use App\Models\Property;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with(['location', 'type', 'status'])->get();

        return view('properties.index', compact('properties'));
    }
}
