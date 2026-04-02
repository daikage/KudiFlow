@extends('layouts.tailwind')

@section('title', 'Support')
@section('search_placeholder', 'Search help topics...')

@section('content')
  <div class="max-w-3xl">
    <h2 class="text-2xl font-extrabold tracking-tight mb-2">Support</h2>
    <p class="text-on-surface-variant mb-6">How can we help you today?</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <a href="#" class="p-4 rounded-xl border border-outline-variant/30 hover:bg-surface-variant/30">
        <div class="flex items-center gap-2 mb-2">
          <span class="material-symbols-outlined">receipt_long</span>
          <span class="font-bold">Sales & POS</span>
        </div>
        <p class="text-sm text-on-surface-variant">Recording sales, refunds, and receipts.</p>
      </a>

      <a href="#" class="p-4 rounded-xl border border-outline-variant/30 hover:bg-surface-variant/30">
        <div class="flex items-center gap-2 mb-2">
          <span class="material-symbols-outlined">inventory_2</span>
          <span class="font-bold">Inventory</span>
        </div>
        <p class="text-sm text-on-surface-variant">Products, categories, and stock alerts.</p>
      </a>

      <a href="#" class="p-4 rounded-xl border border-outline-variant/30 hover:bg-surface-variant/30">
        <div class="flex items-center gap-2 mb-2">
          <span class="material-symbols-outlined">account_balance_wallet</span>
          <span class="font-bold">Expenses</span>
        </div>
        <p class="text-sm text-on-surface-variant">Tracking costs and spending.</p>
      </a>

      <a href="#" class="p-4 rounded-xl border border-outline-variant/30 hover:bg-surface-variant/30">
        <div class="flex items-center gap-2 mb-2">
          <span class="material-symbols-outlined">public</span>
          <span class="font-bold">Platform</span>
        </div>
        <p class="text-sm text-on-surface-variant">Super admin and company management.</p>
      </a>
    </div>

    <div class="mt-6 p-4 rounded-xl bg-surface-container-low border border-outline-variant/10">
      <p class="text-sm text-on-surface-variant">
        Can’t find what you need? Contact support at
        <a href="mailto:support@example.com" class="text-primary font-bold">support@example.com</a>.
      </p>
    </div>
  </div>
@endsection
