<?php

namespace App\Services\Subscriptions;

use App\Models\Plan;
use App\Models\Subscription;

class SubscriptionActivator
{
    public static function activate(int $tenantId, string $planCode): void
    {
        // End existing
        Subscription::where('tenant_id', $tenantId)
            ->whereIn('status', ['active','trial','trialing'])
            ->update(['status' => 'canceled', 'ends_at' => now()]);

        $plan = Plan::where('code', $planCode)->first();
        $renewsAt = $plan && $plan->interval === 'yearly' ? now()->addYear() : now()->addMonth();

        Subscription::create([
            'tenant_id'     => $tenantId,
            'plan'          => $planCode,
            'status'        => 'active',
            'trial_ends_at' => null,
            'renews_at'     => $renewsAt,
            'ends_at'       => null,
        ]);
    }
}
