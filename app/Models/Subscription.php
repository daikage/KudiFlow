<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Subscription extends Model
{
    protected $fillable = [
        'tenant_id',
        'plan',           // basic|pro|enterprise|trial
        'status',         // active|trialing|canceled|past_due|paused
        'trial_ends_at',
        'renews_at',
        'ends_at',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'renews_at'     => 'datetime',
        'ends_at'       => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where(function ($qq) {
            $qq->where('status', 'active')
               ->where(function ($q2) {
                   $q2->whereNull('ends_at')->orWhere('ends_at', '>', now());
               });
        })->orWhere(function ($qq) {
            $qq->where('status', 'trialing')
               ->where('trial_ends_at', '>', now());
        });
    }
}
