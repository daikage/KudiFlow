<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Subscription extends Model
{
    protected $fillable = [
        'tenant_id','plan','status','modules','starts_at','trial_ends_at','ends_at',
    ];

    protected $casts = [
        'modules' => 'array',
        'starts_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public static function defaultModules(): array
    {
        return [
            'inventory' => true,
            'sales' => true,
            'finance' => true,
            'people' => true,
            'analytics' => true,
        ];
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function scopeForTenant(Builder $q, int $tenantId): Builder
    {
        return $q->where('tenant_id', $tenantId);
    }

    public function isTrialActive(): bool
    {
        return $this->status === 'trial' && $this->trial_ends_at && now()->lt($this->trial_ends_at);
    }

    public function isActive(): bool
    {
        if ($this->isTrialActive()) return true;
        if ($this->status !== 'active') return false;

        // If ends_at is null, treat as active subscription; otherwise check end
        return $this->ends_at ? now()->lt($this->ends_at) : true;
    }
}
