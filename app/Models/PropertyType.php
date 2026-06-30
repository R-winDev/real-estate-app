<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyType extends Model
{
    protected $fillable = ['name', 'name_fa', 'slug', 'category'];

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'type_id');
    }
}
