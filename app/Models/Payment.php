<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'tenant_id','user_id','plan_code','provider','reference','provider_ref',
        'amount','currency','status','meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'amount' => 'decimal:2',
    ];

    public function tenant() { return $this->belongsTo(\App\Models\Tenant::class); }
    public function user() { return $this->belongsTo(\App\Models\User::class); }
}
