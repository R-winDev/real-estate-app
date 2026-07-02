<?php

namespace App\Models;

use Database\Factories\PropertyTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyType extends Model
{
    /** @use HasFactory<PropertyTypeFactory> */
    use HasFactory;
    protected $fillable = ['name', 'name_fa', 'slug', 'category'];

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'type_id');
    }
}
