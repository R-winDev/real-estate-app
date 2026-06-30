<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyFile extends Model
{
    protected $fillable = ['property_id', 'file_url', 'file_type', 'label'];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
