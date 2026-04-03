<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Tenant;
use App\Models\Plan;
use App\Models\Subscription;

class SettingsController extends Controller
{
    public function general() { return view('settings.general'); }
    public function billing() { return view('settings.billing'); }
    public function notifications() { return view('settings.notifications'); }

    // [NEW] Update basic company settings
    public function updateGeneral(Request $request)
    {
        $tenant = Tenant::findOrFail((int) app('tenant_id'));

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'subdomain' => [
                'nullable',
                'string',
                'max:100',
                'alpha_dash',
                Rule::unique('tenants', 'subdomain')->ignore($tenant->id),
            ],
        ]);

        $tenant->update([
            'name' => $data['name'],
            'subdomain' => $data['subdomain'] ?? null,
        ]);

        return back()->with('success', 'General settings updated.');
    }

    // NEW: Handle Upgrade / Switch Plan from the Billing page
    public function upgrade(Request $request)
    {
        // Support both payloads: {plan_id} (from current design) OR {plan} (plan code)
        $request->validate([
            'plan_id' => ['nullable', 'integer'],
            'plan'    => ['nullable', 'string'],
        ]);

        // Resolve plan: prefer plan_id if present, otherwise look up by code
        $plan = null;
        if ($request->filled('plan_id')) {
            $plan = Plan::where('status', 'active')->findOrFail((int) $request->input('plan_id'));
        } elseif ($request->filled('plan')) {
            $plan = Plan::where('status', 'active')->where('code', $request->input('plan'))->firstOrFail();
        } else {
            return back()->withErrors(['plan' => 'Please select a valid plan.']);
        }

        $tenantId = (int) app('tenant_id');

        // Cancel existing active or trial subs for this tenant
        Subscription::where('tenant_id', $tenantId)
            ->whereIn('status', ['active', 'trial', 'trialing'])
            ->update([
                'status'  => 'canceled',
                'ends_at' => now(),
            ]);

        // Compute renewal based on plan interval (monthly | yearly)
        $renewsAt = $plan->interval === 'yearly' ? now()->addYear() : now()->addMonth();

        // Create new active subscription for selected plan
        Subscription::create([
            'tenant_id'     => $tenantId,
            'plan'          => $plan->code,
            'status'        => 'active',
            'trial_ends_at' => null,
            'renews_at'     => $renewsAt,
            'ends_at'       => null,
        ]);

        return redirect()->route('ui.settings.billing')->with('success', 'Subscription upgraded to '.$plan->name.'.');
    }
}
