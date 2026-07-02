<?php

namespace App\Models;

use Database\Factories\PropertyStatusFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyStatus extends Model
{
    /** @use HasFactory<PropertyStatusFactory> */
    use HasFactory;
    protected $fillable = ['name', 'name_fa', 'slug'];

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'status_id');
    }
}
