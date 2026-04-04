<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class PlanManager
{
    public const MODULES = ['inventory','sales','finance','people','admin'];

    public static function entitlementsForTenant(int $tenantId): array
    {
        return Cache::remember("tenant:{$tenantId}:entitlements", 60, function () use ($tenantId) {
            $sub = Subscription::active()->where('tenant_id', $tenantId)->latest()->first();

            if (!$sub) {
                return array_fill_keys(self::MODULES, false);
            }

            if ($sub->isTrialing()) {
                return array_fill_keys(self::MODULES, true);
            }

            $plan = Plan::where('code', $sub->plan)->first();
            if ($plan && is_array($plan->entitlements)) {
                $result = [];
                foreach (self::MODULES as $m) {
                    $result[$m] = (bool) ($plan->entitlements[$m] ?? false);
                }
                return $result;
            }

            return array_fill_keys(self::MODULES, false);
        });
    }

    public static function isServiceEntitled(int $tenantId, string $service): bool
    {
        $entitled = self::entitlementsForTenant($tenantId);
        return (bool) ($entitled[$service] ?? false);
    }

    public static function isTrialingTenant(int $tenantId): bool
    {
        return Cache::remember("tenant:{$tenantId}:trialing", 60, function () use ($tenantId) {
            $sub = Subscription::where('tenant_id', $tenantId)->latest()->first();
            return $sub?->isTrialing() ?? false;
        });
    }

    // NEW: simple limits per plan
    public static function limitsForTenant(int $tenantId): array
    {
        return Cache::remember("tenant:{$tenantId}:limits", 60, function () use ($tenantId) {
            $sub = Subscription::where('tenant_id', $tenantId)->latest()->first();

            // Trial: generous limits
            if ($sub && $sub->isTrialing()) {
                return [
                    'products'       => 5000,
                    'monthly_sales'  => 100000,
                    'users'          => 50,
                ];
            }

            $planCode = $sub?->plan ?? 'basic';
            $plan = Plan::where('code', $planCode)->first();

            // Defaults by code; adjust to your pricing strategy
            $defaults = [
                'basic'       => ['products' => 200,  'monthly_sales' => 2000,   'users' => 5],
                'pro'         => ['products' => 2000, 'monthly_sales' => 20000,  'users' => 20],
                'enterprise'  => ['products' => 50000,'monthly_sales' => 500000, 'users' => 100],
            ];

            return $defaults[$planCode] ?? $defaults['basic'];
        });
    }
}
