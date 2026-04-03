<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
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

        // If tenant already has any subscription, proceed to dashboard
        $tenantId = (int) $user->tenant_id;
        if (Subscription::where('tenant_id', $tenantId)->exists()) {
            return redirect()->route('ui.dashboard');
        }

        // Show subscription selection (trial + plans)
        $plans = [
            'basic' => ['label' => 'Basic', 'price' => '₦0.00 (stub)'],
            'pro' => ['label' => 'Pro', 'price' => '₦0.00 (stub)'],
            'enterprise' => ['label' => 'Enterprise', 'price' => '₦0.00 (stub)'],
        ];

        return view('subscriptions.choose', compact('plans'));
    }

    public function startTrial(Request $request)
    {
        $user = $request->user();
        if ($user->super_admin ?? false) {
            return redirect()->route('ui.dashboard');
        }

        $tenantId = (int) $user->tenant_id;

        // Create a 14-day trial subscription (stub)
        Subscription::create([
            'tenant_id'     => $tenantId,
            'plan'          => 'trial',
            'status'        => 'trialing',
            'trial_ends_at' => now()->addDays(14),
            'renews_at'     => null,
            'ends_at'       => null,
        ]);

        return redirect()->route('ui.dashboard')->with('success', 'Your 14-day trial has started.');
    }

    public function choosePlan(Request $request)
    {
        $data = $request->validate([
            'plan' => ['required', 'in:basic,pro,enterprise'],
        ]);

        $user = $request->user();
        if ($user->super_admin ?? false) {
            return redirect()->route('ui.dashboard');
        }

        $tenantId = (int) $user->tenant_id;

        // Create an active subscription record (stub: no billing integration yet)
        Subscription::create([
            'tenant_id' => $tenantId,
            'plan'      => $data['plan'],
            'status'    => 'active',
            'renews_at' => now()->addMonth(),
            'ends_at'   => null,
        ]);

        return redirect()->route('ui.dashboard')->with('success', 'Subscription activated.');
    }
}

