<?php

namespace App\Models;

use Database\Factories\LocationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    /** @use HasFactory<LocationFactory> */
    use HasFactory;
    protected $fillable = ['name', 'slug', 'parent_id', 'latitude', 'longitude'];
    protected $casts = ['latitude' => 'float', 'longitude' => 'float'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
