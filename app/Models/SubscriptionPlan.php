<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name',
        'code',       // e.g. basic, pro, enterprise
        'price',      // decimal
        'interval',   // monthly|yearly
        'active',     // bool
        'features',   // json: {"inventory":true,"sales":true,...}
    ];

    protected $casts = [
        'price'    => 'decimal:2',
        'active'   => 'boolean',
        'features' => 'array',
    ];

    public function scopeActive($q)
    {
        return $q->where('active', true);
    }
}
