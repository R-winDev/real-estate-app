<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BuildingMaterial extends Model
{
    protected $fillable = ['name', 'name_fa', 'slug'];

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_building_materials');
    }
}
