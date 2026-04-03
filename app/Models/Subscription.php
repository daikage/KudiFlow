<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Subscription extends Model
{
    protected $fillable = [
        'tenant_id',
        'plan',           // plan code or 'trial'
        'status',         // active|trial|trialing|canceled|expired|past_due|paused
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

    // Consider both 'trial' and 'trialing' as trial states for compatibility
    public function isTrialing(): bool
    {
        if (!in_array($this->status, ['trial', 'trialing'], true)) {
            return false;
        }
        return $this->trial_ends_at?->isFuture() ?? false;
    }

    public function isActive(): bool
    {
        $now = now();

        if (in_array($this->status, ['trial', 'trialing'], true)) {
            return $this->trial_ends_at?->gt($now) ?? false;
        }

        if ($this->status === 'active') {
            return $this->ends_at === null || $this->ends_at->gt($now);
        }

        // paused/past_due/canceled/expired -> not active
        return false;
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where(function ($w) {
            $now = now();
            $w->where(function ($qq) use ($now) {
                $qq->whereIn('status', ['trial', 'trialing'])
                   ->where('trial_ends_at', '>', $now);
            })->orWhere(function ($qq) use ($now) {
                $qq->where('status', 'active')
                   ->where(function ($x) use ($now) {
                       $x->whereNull('ends_at')->orWhere('ends_at', '>', $now);
                   });
            });
        });
    }
}
