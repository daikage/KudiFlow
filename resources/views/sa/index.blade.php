@extends('layouts.tailwind')

@section('title', 'Platform Admin')
@section('search_placeholder', 'Search companies, users...')

@section('content')
  <section class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="bg-surface-container-low rounded-xl p-6">
      <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant mb-2">Companies</p>
      <p class="font-headline text-3xl font-extrabold">{{ $tenantsCount }}</p>
      <p class="text-xs text-on-surface-variant mt-1">Registered</p>
    </div>
    <div class="bg-surface-container-low rounded-xl p-6">
      <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant mb-2">Users</p>
      <p class="font-headline text-3xl font-extrabold">{{ $usersCount }}</p>
      <p class="text-xs text-on-surface-variant mt-1">Across platform</p>
    </div>
    <div class="bg-surface-container-low rounded-xl p-6">
      <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant mb-2">MRR</p>
      <p class="font-headline text-3xl font-extrabold">₦{{ number_format($mrr, 2) }}</p>
      <p class="text-xs text-on-surface-variant mt-1">Monthly recurring</p>
    </div>
    <div class="bg-surface-container-low rounded-xl p-6">
      <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant mb-2">Inventory Value</p>
      <p class="font-headline text-3xl font-extrabold">₦{{ number_format($inventoryValue, 0) }}</p>
      <p class="text-xs text-on-surface-variant mt-1">All companies</p>
    </div>
  </section>

  <section class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-headline text-lg font-bold">Recent Companies</h3>
        <a href="{{ route('sa.tenants.index') }}" class="text-xs text-primary font-bold">View All</a>
      </div>
      <div class="divide-y divide-outline-variant/10">
        @forelse($recentTenants as $t)
          <div class="py-3 flex items-center justify-between">
            <div>
              <p class="font-semibold">{{ $t->name }}</p>
              <p class="text-xs text-on-surface-variant">ID: {{ $t->id }} • Joined {{ $t->created_at->format('Y-m-d') }}</p>
            </div>
            <a class="text-primary text-sm font-bold" href="{{ route('sa.tenants.dashboard', $t) }}">Open Dashboard</a>
          </div>
        @empty
          <p class="text-sm text-on-surface-variant">No companies yet.</p>
        @endforelse
      </div>
    </div>

    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h3 class="font-headline text-lg font-bold mb-4">Quick Actions</h3>
      <div class="space-y-2">
        <a href="{{ route('sa.subscriptions.index') }}" class="w-full inline-flex items-center justify-between px-4 py-3 rounded-xl border border-outline-variant/30 hover:bg-surface-variant/30">
          <span>Manage Subscriptions</span> <span class="material-symbols-outlined">arrow_forward</span>
        </a>
        <a href="{{ route('sa.tenants.index') }}" class="w-full inline-flex items-center justify-between px-4 py-3 rounded-xl border border-outline-variant/30 hover:bg-surface-variant/30">
          <span>Companies</span> <span class="material-symbols-outlined">arrow_forward</span>
        </a>
      </div>
    </div>
  </section>
@endsection
