<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyStatus extends Model
{
    protected $fillable = ['name', 'name_fa', 'slug'];

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'status_id');
    }
}
