@extends('layouts.tailwind')

@section('title', 'Billing & Subscription')
@section('search_placeholder', 'Search billing...')

@section('content')
  @php
    // Use the consolidated Subscription model + PlanManager. Avoid columns/methods that don't exist.
    $tenantId     = app('tenant_id');
    $subscription = \App\Models\Subscription::where('tenant_id', $tenantId)->latest('id')->first();
    $isTrial      = $subscription?->isTrialing() ?? false;
    $trialEnds    = $subscription?->trial_ends_at;
    $isActive     = $subscription?->isActive() ?? false;

    // Entitlements for the current tenant (trial => all true, paid => per-plan)
    $entitled     = \App\Services\PlanManager::entitlementsForTenant((int) $tenantId);

    // Keep $modules alias for downstream template code that referenced it previously
    $modules      = $entitled;

    // Show real, active plans created by Super Admin
    $plans        = \App\Models\Plan::active()->orderBy('price')->get();
  @endphp

  @if(session('success'))
    <div class="mb-4 p-3 rounded bg-primary/10 text-primary text-sm font-semibold">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="mb-4 p-3 rounded bg-error/10 text-error text-sm font-semibold">{{ $errors->first() }}</div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <div class="flex items-start justify-between">
          <div>
            <h2 class="text-xl font-extrabold tracking-tight">Subscription</h2>
            <p class="text-on-surface-variant text-sm">
              @if($isTrial)
                Trial active
                @if($trialEnds) — ends {{ $trialEnds->diffForHumans() }} ({{ $trialEnds->format('M j, Y') }}) @endif
              @elseif($isActive)
                Active plan: {{ ucfirst($subscription->plan) }}
                @if($subscription->ends_at) — renews {{ $subscription->ends_at->diffForHumans() }} ({{ $subscription->ends_at->format('M j, Y') }}) @endif
              @else
                Inactive — please upgrade to continue using the app.
              @endif
            </p>
          </div>
          <div>
            @if(!$isActive || $isTrial)
              <a href="#upgrade" class="inline-flex px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Upgrade</a>
            @else
              <a href="#upgrade" class="inline-flex px-4 py-2 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">Change Plan</a>
            @endif
          </div>
        </div>
      </div>

      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <h3 class="font-bold mb-4">Included Modules</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          @php
            $moduleMeta = [
              'inventory' => ['icon' => 'inventory_2', 'label' => 'Inventory'],
              'sales' => ['icon' => 'receipt_long', 'label' => 'Sales'],
              'finance' => ['icon' => 'account_balance_wallet', 'label' => 'Finance'],
              'people' => ['icon' => 'group', 'label' => 'People'],
              'analytics' => ['icon' => 'stacked_bar_chart', 'label' => 'Analytics'],
            ];
          @endphp
          @foreach($moduleMeta as $key => $meta)
            @php $enabled = (bool)($modules[$key] ?? false); @endphp
            <div class="p-4 rounded-xl border border-outline-variant/10 shadow-sm {{ $enabled ? 'bg-surface-container-low' : 'bg-surface-container' }}">
              <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                  <span class="material-symbols-outlined">{{ $meta['icon'] }}</span>
                  <span class="font-semibold">{{ $meta['label'] }}</span>
                </div>
                <span class="text-[10px] font-bold px-2 py-1 rounded-full {{ $enabled ? 'bg-primary text-on-primary' : 'bg-outline-variant/30 text-on-surface-variant' }}">
                  {{ $enabled ? 'ACTIVE' : 'LOCKED' }}
                </span>
              </div>
              <p class="text-sm text-on-surface-variant">
                {{ $enabled ? 'This module is included in your current plan.' : 'Upgrade to unlock this module.' }}
              </p>
            </div>
          @endforeach
        </div>
      </div>

      <!-- [NEW] Upgrade / Plan selection -->
      <div id="upgrade" class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <div class="flex items-center justify-between mb-4">
          <h3 class="font-bold">Choose a Plan</h3>
          @if($isTrial)<span class="text-xs font-bold bg-secondary-container/40 text-on-secondary-container px-2 py-1 rounded-full">Trial ends {{ optional($trialEnds)->diffForHumans() }}</span>@endif
        </div>
        @if($plans->isEmpty())
          <p class="text-on-surface-variant">No plans available. Please contact support.</p>
        @else
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($plans as $plan)
              <div class="p-4 rounded-xl border border-outline-variant/10 shadow-sm bg-surface-container">
                <div class="flex items-start justify-between">
                  <div>
                    <h4 class="font-bold">{{ $plan->name }}</h4>
                    <p class="text-xs text-on-surface-variant uppercase tracking-widest">{{ strtoupper($plan->currency) }} {{ number_format($plan->price,2) }}</p>
                  </div>
                  <span class="text-[10px] font-bold px-2 py-1 rounded-full {{ $plan->active ? 'bg-primary text-on-primary' : 'bg-outline-variant/30 text-on-surface-variant' }}">
                    {{ $plan->active ? 'ACTIVE' : 'INACTIVE' }}
                  </span>
                </div>
                <p class="mt-1 text-sm text-on-surface-variant">Every {{ $plan->interval_count }} {{ $plan->interval }}</p>
                <div class="mt-2 flex flex-wrap gap-2">
                  @php $mods = $plan->modules ?? []; @endphp
                  @foreach($moduleMeta as $key => $meta)
                    <span class="text-[11px] px-2 py-0.5 rounded-full {{ ($mods[$key] ?? false) ? 'bg-primary text-on-primary' : 'bg-outline-variant/30 text-on-surface-variant' }}">
                      {{ $meta['label'] }}
                    </span>
                  @endforeach
                </div>
                <form action="{{ route('ui.billing.upgrade') }}" method="POST" class="mt-3">
                  @csrf
                  <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                  <button class="w-full px-4 py-2 rounded-lg {{ $plan->active ? 'bg-primary text-on-primary' : 'bg-outline-variant/30 text-on-surface-variant cursor-not-allowed' }}" {{ $plan->active ? '' : 'disabled' }}>
                    {{ $isTrial || !$isActive ? 'Upgrade' : 'Switch to this plan' }}
                  </button>
                </form>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>

    <div class="space-y-6">
      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <h3 class="font-bold mb-2">Billing Summary</h3>
        <p class="text-sm text-on-surface-variant">
          Plan: <span class="font-semibold">{{ ucfirst($subscription->plan ?? 'trial') }}</span>
        </p>
        <p class="text-sm text-on-surface-variant">
          Status: <span class="font-semibold">{{ strtoupper($subscription->status ?? 'trial') }}</span>
        </p>
        @if($trialEnds)
          <p class="text-sm text-on-surface-variant">
            Trial ends: <span class="font-semibold">{{ $trialEnds->format('M j, Y') }}</span>
          </p>
        @endif
        @if($subscription?->ends_at)
          <p class="text-sm text-on-surface-variant">
            Renews: <span class="font-semibold">{{ $subscription->ends_at->format('M j, Y') }}</span>
          </p>
        @endif
        <a href="#" class="mt-3 inline-flex px-4 py-2 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">View Invoices</a>
      </div>

      <div class="bg-secondary-container/20 border border-secondary/10 rounded-xl p-4">
        <p class="text-sm text-on-surface-variant">
          You’re on a trial. Upgrade anytime to avoid interruptions.
        </p>
      </div>
    </div>
  </div>
@endsection
