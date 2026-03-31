@extends('layouts.tailwind')

@section('title', 'Subscriptions')
@section('search_placeholder', 'Search subscriptions...')

@section('content')
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-bold">Subscriptions</h2>
    <a href="/ui/admin/subscriptions/create" class="px-4 py-2 rounded-xl bg-primary text-on-primary shadow-sm">New Subscription</a>
  </div>

  <div class="bg-surface-container-lowest rounded-xl p-0 shadow-sm border border-outline-variant/5 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full">
        <thead class="bg-surface-container">
          <tr class="text-left text-[12px] text-on-surface-variant uppercase tracking-widest">
            <th class="px-4 py-3">Store</th>
            <th class="px-4 py-3">Plan</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Renewal</th>
            <th class="px-4 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-t border-outline-variant/10">
            <td class="px-4 py-3">—</td>
            <td class="px-4 py-3">—</td>
            <td class="px-4 py-3">
              <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-secondary-container/40 text-on-secondary-container">INACTIVE</span>
            </td>
            <td class="px-4 py-3">—</td>
            <td class="px-4 py-3 text-right">
              <a href="/ui/admin/subscriptions/1" class="px-3 py-1 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant">View</a>
            </td>
          </tr>
          <tr>
            <td colspan="5" class="px-4 py-6 text-center text-on-surface-variant">No subscriptions yet.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
@endsection