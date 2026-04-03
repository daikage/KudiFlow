<?php

namespace App\Http\Controllers\SA;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function index()
    {
        $plans = Plan::orderBy('sort')->orderBy('price')->get();
        return view('sa.subscriptions.index', compact('plans'));
    }

    public function create()
    {
        $modules = ['inventory','sales','finance','people','admin'];
        return view('sa.subscriptions.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'   => ['required','string','max:64','alpha_dash','unique:plans,code'],
            'name'   => ['required','string','max:255'],
            'price'  => ['required','numeric','min:0'],
            'interval' => ['required','in:monthly,yearly'],
            'status' => ['required','in:active,inactive'],
            'sort'   => ['nullable','integer','min:0'],
            'entitlements' => ['array'],
        ]);

        $modules = ['inventory','sales','finance','people','admin'];
        $entitlements = [];
        foreach ($modules as $m) {
            $entitlements[$m] = (bool) ($data['entitlements'][$m] ?? false);
        }

        Plan::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'price' => $data['price'],
            'interval' => $data['interval'],
            'status' => $data['status'],
            'sort' => $data['sort'] ?? 0,
            'entitlements' => $entitlements,
        ]);

        return redirect()->route('sa.subscriptions.index')->with('success', 'Plan created.');
    }

    public function edit(Plan $plan)
    {
        $modules = ['inventory','sales','finance','people','admin'];
        return view('sa.subscriptions.edit', compact('plan','modules'));
    }

    public function update(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'name'   => ['required','string','max:255'],
            'price'  => ['required','numeric','min:0'],
            'interval' => ['required','in:monthly,yearly'],
            'status' => ['required','in:active,inactive'],
            'sort'   => ['nullable','integer','min:0'],
            'entitlements' => ['array'],
        ]);

        $modules = ['inventory','sales','finance','people','admin'];
        $entitlements = [];
        foreach ($modules as $m) {
            $entitlements[$m] = (bool) ($data['entitlements'][$m] ?? false);
        }

        $plan->update([
            'name' => $data['name'],
            'price' => $data['price'],
            'interval' => $data['interval'],
            'status' => $data['status'],
            'sort' => $data['sort'] ?? 0,
            'entitlements' => $entitlements,
        ]);

        return redirect()->route('sa.subscriptions.index')->with('success', 'Plan updated.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('sa.subscriptions.index')->with('success', 'Plan deleted.');
    }
}
