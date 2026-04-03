<?php

namespace App\Services;

use App\Models\Subscription;
use Illuminate\Support\Arr;

class PlanManager
{
    // Centralized entitlements by plan
    protected static array $plans = [
        'basic' => [
            'inventory' => true,
            'sales'     => true,
            'finance'   => false,
            'people'    => false,
            'admin'     => false,
        ],
        'pro' => [
            'inventory' => true,
            'sales'     => true,
            'finance'   => true,
            'people'    => true,
            'admin'     => false,
        ],
        'enterprise' => [
            'inventory' => true,
            'sales'     => true,
            'finance'   => true,
            'people'    => true,
            'admin'     => true,
        ],
        // Treat trial as Pro by default
        'trial' => [
            'inventory' => true,
            'sales'     => true,
            'finance'   => true,
            'people'    => true,
            'admin'     => false,
        ],
    ];

    public static function entitlementsForTenant(int $tenantId): array
    {
        $sub = Subscription::active()->where('tenant_id', $tenantId)->latest()->first();

        // Fallback to 'basic' if no subscription; adjust if you prefer stricter default
        $plan = $sub?->plan ?: 'basic';

        return self::$plans[$plan] ?? self::$plans['basic'];
    }

    public static function isServiceEntitled(int $tenantId, string $service): bool
    {
        $entitled = self::entitlementsForTenant($tenantId);
        return (bool) Arr::get($entitled, $service, false);
    }
}

