<?php

namespace App\Http\Controllers\UI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Tenant;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Payment;
use App\Services\Payments\PaymentService;
use App\Services\Subscriptions\SubscriptionActivator;

class SettingsController extends Controller
{
    public function general() { return view('settings.general'); }
    public function billing() { return view('settings.billing'); }
    public function notifications() { return view('settings.notifications'); }

    // Start checkout for selected plan (keeps existing form design)
    public function upgrade(Request $request)
    {
        $request->validate([
            'plan_id' => ['nullable', 'integer', 'exists:plans,id'],
            'plan'    => ['nullable', 'string', Rule::exists('plans','code')->where('status','active')],
        ]);

        // Resolve selected plan: prefer plan_id
        $plan = null;
        if ($request->filled('plan_id')) {
            $plan = Plan::where('status','active')->findOrFail((int) $request->plan_id);
        } elseif ($request->filled('plan')) {
            $plan = Plan::where('status','active')->where('code', $request->plan)->firstOrFail();
        } else {
            return back()->withErrors(['plan' => 'Please select a valid plan.']);
        }

        $tenantId = (int) app('tenant_id');
        $user = $request->user();

        try {
            $init = PaymentService::initCheckout($tenantId, (int) $user->id, $user->email, $plan);
            return redirect()->away($init['redirect']);
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'Could not start payment: '.$e->getMessage()]);
        }
    }

    // Callback/return URL from gateway
    public function billingCallback(Request $request)
    {
        $driver = config('payments.driver', 'paystack');

        // Locate payment by reference/tx_ref from query
        $reference = $request->input('reference') ?: $request->input('trxref') ?: $request->input('tx_ref');
        if (!$reference) {
            return redirect()->route('ui.settings.billing')->withErrors(['error' => 'Missing payment reference.']);
        }

        $payment = Payment::where('reference', $reference)->first();
        if (!$payment) {
            return redirect()->route('ui.settings.billing')->withErrors(['error' => 'Payment not found.']);
        }

        // Verify with provider
        $result = PaymentService::verifyAndFinalize($driver, $payment, $request->all());

        if (!($result['success'] ?? false)) {
            return redirect()->route('ui.settings.billing')->withErrors(['error' => 'Payment verification failed.']);
        }

        // Reuse activator
        SubscriptionActivator::activate($payment->tenant_id, $payment->plan_code);

        return redirect()->route('ui.settings.billing')->with('success', 'Subscription activated successfully.');
    }
}
