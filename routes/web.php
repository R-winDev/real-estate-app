<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredProperties = Property::with(['location', 'type', 'status'])
        ->latest()
        ->take(6)
        ->get();

    $stats = [
        'total_properties' => Property::count(),
        'total_locations' => Location::count(),
        'total_types' => PropertyType::count(),
        'total_users' => User::count(),
    ];

    return view('welcome', compact('featuredProperties', 'stats'));
})->name('home');

Route::get('/dashboard', function () {
    $stats = [
        'total' => Property::count(),
        'active' => Property::where('is_sold', false)->count(),
        'sold' => Property::where('is_sold', true)->count(),
        'inactive' => Property::where('status_id', '!=', 1)->count(),
    ];

    $recentProperties = Property::with(['location', 'type', 'status'])
        ->latest()
        ->take(5)
        ->get();

    return view('dashboard', compact('stats', 'recentProperties'));
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('properties', PropertyController::class)->except(['index', 'show'])->middleware(['auth', 'admin']);

Route::resource('properties', PropertyController::class)->only(['index', 'show']);

require __DIR__.'/auth.php';
