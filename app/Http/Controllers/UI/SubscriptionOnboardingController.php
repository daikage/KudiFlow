<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Plan;
use Illuminate\Http\Request;

class SubscriptionOnboardingController extends Controller
{
    public function choose(Request $request)
    {
        $user = $request->user();

        // Super admin unaffected
        if ($user->super_admin ?? false) {
            return redirect()->route('ui.dashboard');
        }

        $tenantId = (int) $user->tenant_id;

        // If already has an active subscription, proceed
        if (Subscription::active()->where('tenant_id', $tenantId)->exists()) {
            return redirect()->route('ui.dashboard');
        }

        // LOAD REAL PLANS created by Super Admin
        $plans = Plan::active()->orderBy('sort')->orderBy('price')->get(['id','code','name','price','interval','entitlements','status']);

        return view('subscriptions.choose', compact('plans'));
    }

    public function startTrial(Request $request)
    {
        $user = $request->user();
        if ($user->super_admin ?? false) {
            return redirect()->route('ui.dashboard');
        }

        $tenantId = (int) $user->tenant_id;

        // End any previous non-active records (optional clean up)
        // Create 14-day trial
        Subscription::create([
            'tenant_id'     => $tenantId,
            'plan'          => 'trial',
            'status'        => 'trialing',
            'trial_ends_at' => now()->addDays(14),
            'renews_at'     => null,
            'ends_at'       => null,
        ]);

        return redirect()->route('ui.dashboard')->with('success', 'Your 14-day trial has started. All features are unlocked during the trial.');
    }

    public function choosePlan(Request $request)
    {
        $data = $request->validate([
            'plan' => ['required', 'string'], // plan code
        ]);

        $user = $request->user();
        if ($user->super_admin ?? false) {
            return redirect()->route('ui.dashboard');
        }

        $tenantId = (int) $user->tenant_id;

        // Verify the plan exists and is active
        $plan = Plan::active()->where('code', $data['plan'])->firstOrFail();

        // Create an active subscription record
        Subscription::create([
            'tenant_id' => $tenantId,
            'plan'      => $plan->code,
            'status'    => 'active',
            'renews_at' => now()->addMonth(), // placeholder for monthly billing
            'ends_at'   => null,
        ]);

        return redirect()->route('ui.dashboard')->with('success', 'Subscription activated.');
    }
}
