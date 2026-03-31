@extends('layouts.tailwind')

@section('title', 'Settings • Billing')
@section('search_placeholder', 'Search billing...')

@section('content')
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-bold">Billing</h2>
    <a href="/ui/settings/general" class="px-3 py-2 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">General</a>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h3 class="font-bold mb-4">Payment Method</h3>
      <form class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div class="md:col-span-2">
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Cardholder Name</label>
          <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
        </div>
        <div class="md:col-span-2">
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Card Number</label>
          <input inputmode="numeric" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Expiry</label>
          <input placeholder="MM/YY" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">CVC</label>
          <input inputmode="numeric" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
        </div>
        <div class="md:col-span-2">
          <button type="button" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Save Payment Method</button>
        </div>
      </form>
    </div>

    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h3 class="font-bold mb-4">Plan</h3>
      <p class="text-on-surface-variant text-sm mb-2">Current Plan: —</p>
      <div class="space-y-2">
        <button class="w-full px-4 py-2 rounded-xl border border-outline-variant/30 hover:bg-surface-variant/30">Change Plan</button>
        <button class="w-full px-4 py-2 rounded-xl border border-outline-variant/30 text-error hover:bg-error/5">Cancel Subscription</button>
      </div>
    </div>
  </div>
@endsection
