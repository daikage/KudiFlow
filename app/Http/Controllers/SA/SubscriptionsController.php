<?php

namespace App\Http\Controllers\SA;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class SubscriptionsController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::orderBy('active', 'desc')->orderBy('amount')->get();

        return view('sa.subscriptions.index', compact('plans'));
    }

    public function storePlan(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:100'],
            'slug' => ['nullable','string','max:50', Rule::unique('subscription_plans','slug')],
            'amount' => ['required','numeric','min:0'],
            'currency' => ['required','string','size:3'],
            'interval' => ['required','in:monthly,yearly,lifetime'],
            'interval_count' => ['required','integer','min:1'],
            'trial_days' => ['nullable','integer','min:0'],
            'modules' => ['array'],
            'modules.*' => ['boolean'],
            'active' => ['nullable','boolean'],
        ]);

        $slug = $data['slug'] ?: Str::slug($data['name']);
        $modules = $data['modules'] ?? [];

        SubscriptionPlan::create([
            'name' => $data['name'],
            'slug' => $slug,
            'amount' => $data['amount'],
            'currency' => strtoupper($data['currency']),
            'interval' => $data['interval'],
            'interval_count' => $data['interval_count'],
            'trial_days' => $data['trial_days'] ?? 0,
            'modules' => $modules,
            'active' => (bool)($data['active'] ?? true),
        ]);

        return back()->with('success', 'Plan created.');
    }

    public function destroyPlan(SubscriptionPlan $plan)
    {
        $plan->delete();

        return back()->with('success', 'Plan deleted.');
    }
}
