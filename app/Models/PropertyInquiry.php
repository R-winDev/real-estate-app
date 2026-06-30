<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyInquiry extends Model
{
    protected $fillable = [
        'property_id',
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'inquiry_type',
        'preferred_date',
        'preferred_time',
        'message',
        'status',
    ];
    protected $casts = ['preferred_date' => 'date', 'preferred_time' => 'datetime'];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
