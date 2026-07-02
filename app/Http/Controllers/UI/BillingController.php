<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

class BillingController extends Controller
{
    // [NEW] Upgrade from trial/inactive to a selected plan
    public function upgrade(Request $request)
    {
        $tenantId = app('tenant_id');
        $tenant   = Tenant::findOrFail($tenantId);

        $data = $request->validate([
            'plan_id' => ['required','integer','exists:plans,id'],
        ]);

        $plan = Plan::findOrFail($data['plan_id']);

        // Compute end date based on interval
        $startsAt = now();
        $endsAt = null;
        if ($plan->interval !== 'lifetime') {
            $endsAt = match ($plan->interval) {
                'monthly'  => $startsAt->copy()->addMonths($plan->interval_count ?: 1),
                'yearly'   => $startsAt->copy()->addYears($plan->interval_count ?: 1),
                default    => null,
            };
        }

        // Upsert tenant subscription
        $sub = Subscription::updateOrCreate(
            ['tenant_id' => $tenantId],
            [
                'plan'         => $plan->code,
                'status'       => 'active',
                'modules'      => $plan->modules ?? [],
                'starts_at'    => $startsAt,
                'trial_ends_at'=> null,
                'ends_at'      => $endsAt,
            ]
        );

        // Ensure tenant is not paused after upgrade
        if ($tenant->isPaused()) {
            $tenant->resume();
        }

        return redirect()->route('ui.settings.billing')->with('success', 'Subscription upgraded to '.$plan->name.'.');
    }
}
