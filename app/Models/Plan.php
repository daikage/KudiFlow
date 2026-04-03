<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'code',
        'name',
        'price',
        'interval',      // monthly|yearly
        'entitlements',  // json
        'status',        // active|inactive
        'sort',
    ];

    protected $casts = [
        'entitlements' => 'array',
        'price' => 'decimal:2',
    ];

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }
}

