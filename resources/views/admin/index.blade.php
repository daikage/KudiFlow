@extends('layouts.tailwind')

@section('title', 'Admin Overview')
@section('search_placeholder', 'Search admin items...')

@section('content')
  <section class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="bg-surface-container-low rounded-xl p-6">
      <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant mb-2">Users</p>
      <p class="font-headline text-3xl font-extrabold">0</p>
      <p class="text-xs text-on-surface-variant mt-1">Active users</p>
    </div>
    <div class="bg-surface-container-low rounded-xl p-6">
      <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant mb-2">Stores</p>
      <p class="font-headline text-3xl font-extrabold">0</p>
      <p class="text-xs text-on-surface-variant mt-1">Linked outlets</p>
    </div>
    <div class="bg-surface-container-low rounded-xl p-6">
      <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant mb-2">Subscriptions</p>
      <p class="font-headline text-3xl font-extrabold">0</p>
      <p class="text-xs text-on-surface-variant mt-1">Active plans</p>
    </div>
    <div class="bg-surface-container-low rounded-xl p-6">
      <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant mb-2">MRR</p>
      <p class="font-headline text-3xl font-extrabold">₦0.00</p>
      <p class="text-xs text-on-surface-variant mt-1">Monthly recurring</p>
    </div>
  </section>

  <section class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-headline text-lg font-bold">System Logs</h3>
        <button class="text-xs text-primary font-bold">View All</button>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-surface-container">
            <tr class="text-left text-[12px] text-on-surface-variant uppercase tracking-widest">
              <th class="px-4 py-3">Timestamp</th>
              <th class="px-4 py-3">Event</th>
              <th class="px-4 py-3">Actor</th>
              <th class="px-4 py-3">IP</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="4" class="px-4 py-6 text-center text-on-surface-variant">No logs yet.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h3 class="font-headline text-lg font-bold mb-4">Quick Actions</h3>
      <div class="space-y-2">
        <a href="/ui/admin/subscriptions" class="w-full inline-flex items-center justify-between px-4 py-3 rounded-xl border border-outline-variant/30 hover:bg-surface-variant/30">
          <span>Manage Subscriptions</span> <span class="material-symbols-outlined">arrow_forward</span>
        </a>
        <a href="/ui/staff" class="w-full inline-flex items-center justify-between px-4 py-3 rounded-xl border border-outline-variant/30 hover:bg-surface-variant/30">
          <span>Manage Staff</span> <span class="material-symbols-outlined">arrow_forward</span>
        </a>
        <a href="/ui/settings/general" class="w-full inline-flex items-center justify-between px-4 py-3 rounded-xl border border-outline-variant/30 hover:bg-surface-variant/30">
          <span>Store Settings</span> <span class="material-symbols-outlined">arrow_forward</span>
        </a>
      </div>
    </div>
  </section>
@endsection
