@extends('layouts.tailwind')

@section('title', 'Platform — Subscription Plans')
@section('search_placeholder', 'Search plans...')

@section('content')
  @if(session('success'))
    <div class="mb-4 p-3 rounded bg-primary/10 text-primary text-sm font-semibold">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="mb-4 p-3 rounded bg-error/10 text-error text-sm font-semibold">{{ $errors->first() }}</div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Create Plan (Card) -->
    <div class="lg:col-span-1 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h2 class="text-lg font-bold mb-4">New Plan</h2>
      <form action="{{ route('sa.subscriptions.plans.store') }}" method="POST" class="grid grid-cols-1 gap-3">
        @csrf
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Plan Name</label>
          <input name="name" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="e.g. Pro" required>
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Slug (optional)</label>
          <input name="slug" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="e.g. pro">
        </div>
        <div class="grid grid-cols-3 gap-2">
          <div>
            <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Amount</label>
            <input name="amount" inputmode="decimal" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="0" required>
          </div>
          <div>
            <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Currency</label>
            <input name="currency" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="NGN" maxlength="3" required>
          </div>
          <div>
            <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Trial Days</label>
            <input name="trial_days" inputmode="numeric" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="0">
          </div>
        </div>
        <div class="grid grid-cols-2 gap-2">
          <div>
            <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Interval</label>
            <select name="interval" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
              <option value="monthly">Monthly</option>
              <option value="yearly">Yearly</option>
              <option value="lifetime">Lifetime</option>
            </select>
          </div>
          <div>
            <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Every</label>
            <input name="interval_count" inputmode="numeric" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="1">
          </div>
        </div>

        <div class="mt-2">
          <p class="text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-2">Modules</p>
          <div class="grid grid-cols-2 gap-2">
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
              <label class="flex items-center gap-2 bg-surface-container rounded-lg px-3 py-2 border border-outline-variant/20">
                <input type="checkbox" name="modules[{{ $key }}]" value="1" class="rounded">
                <span class="material-symbols-outlined text-sm">{{ $meta['icon'] }}</span>
                <span class="text-sm">{{ $meta['label'] }}</span>
              </label>
            @endforeach
          </div>
        </div>

        <label class="inline-flex items-center gap-2 mt-2">
          <input type="checkbox" name="active" value="1" class="rounded" checked>
          <span class="text-sm">Active</span>
        </label>

        <div class="pt-2">
          <button class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Create Plan</button>
        </div>
      </form>
    </div>

    <!-- Plans List (Cards) -->
    <div class="lg:col-span-2">
      <h3 class="font-headline text-lg font-bold mb-4">Plans</h3>
      @if($plans->isEmpty())
        <p class="text-on-surface-variant">No plans yet. Create your first plan.</p>
      @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @foreach($plans as $plan)
            <div class="p-4 rounded-xl border border-outline-variant/10 shadow-sm bg-surface-container-lowest">
              <div class="flex items-start justify-between">
                <div>
                  <h4 class="font-bold">{{ $plan->name }}</h4>
                  <p class="text-xs text-on-surface-variant uppercase tracking-widest">Slug: {{ $plan->slug }}</p>
                </div>
                <span class="text-[10px] font-bold px-2 py-1 rounded-full {{ $plan->active ? 'bg-primary text-on-primary' : 'bg-outline-variant/30 text-on-surface-variant' }}">
                  {{ $plan->active ? 'ACTIVE' : 'INACTIVE' }}
                </span>
              </div>
              <div class="mt-2 text-sm">
                <p><span class="font-semibold">Price:</span> {{ $plan->currency }} {{ number_format($plan->amount, 2) }}</p>
                <p><span class="font-semibold">Interval:</span> Every {{ $plan->interval_count }} {{ $plan->interval }}</p>
                <p><span class="font-semibold">Trial:</span> {{ $plan->trial_days }} days</p>
              </div>
              <div class="mt-3">
                <p class="text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Modules</p>
                <div class="flex flex-wrap gap-2">
                  @php $mods = $plan->modules ?? []; @endphp
                  @forelse($moduleMeta as $key => $meta)
                    <span class="text-[11px] px-2 py-0.5 rounded-full {{ ($mods[$key] ?? false) ? 'bg-primary text-on-primary' : 'bg-outline-variant/30 text-on-surface-variant' }}">
                      {{ $meta['label'] }}
                    </span>
                  @empty
                    <span class="text-[11px] text-on-surface-variant">—</span>
                  @endforelse
                </div>
              </div>
              <div class="mt-4 flex gap-2">
                <form action="{{ route('sa.subscriptions.plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Delete this plan?');">
                  @csrf @method('DELETE')
                  <button class="px-3 py-1.5 rounded-lg border border-error text-error hover:bg-error/5">Delete</button>
                </form>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
@endsection
