<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Subscription;

class PlanManager
{
    // Core module keys your app recognizes
    public const MODULES = ['inventory','sales','finance','people','admin'];

    public static function entitlementsForTenant(int $tenantId): array
    {
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
    }

    // NEW: quick check for trial tenants
    public static function isTrialingTenant(int $tenantId): bool
    {
        $sub = Subscription::where('tenant_id', $tenantId)->latest()->first();
        return $sub?->isTrialing() ?? false;
    }
}
