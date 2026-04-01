<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['name', 'subdomain', 'status', 'paused_at', 'pause_reason'];
    
    protected $casts = [
        'paused_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePaused($query)
    {
        return $query->where('status', 'paused');
    }

    public function pause(string $reason): void
    {
        $this->update([
            'status' => 'paused',
            'paused_at' => now(),
            'pause_reason' => $reason,
        ]);
    }

    public function resume(): void
    {
        $this->update([
            'status' => 'active',
            'paused_at' => null,
            'pause_reason' => null,
        ]);
    }

    public function isPaused(): bool
    {
        return $this->status === 'paused';
    }

    public function owner()
    {
        return $this->hasOne(User::class, 'tenant_id')->where('role', 'admin')->oldest();
    }
}