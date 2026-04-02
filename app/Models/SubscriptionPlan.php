<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name','slug','amount','currency','interval','interval_count','trial_days','modules','active',
    ];

    protected $casts = [
        'modules' => 'array',
        'active' => 'bool',
    ];
}
