@extends('layouts.tailwind')

@section('title', 'Sales')
@section('search_placeholder', 'Search receipts or products...')

@section('content')
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-bold">Sales</h2>
    <a href="/ui/sales/create" class="px-4 py-2 rounded-xl bg-primary text-on-primary shadow-sm">Record Sale</a>
  </div>

  <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5 mb-4">
    <form class="grid grid-cols-1 md:grid-cols-4 gap-3">
      <input class="bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="Search receipt or product...">
      <input type="date" class="bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
      <select class="bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
        <option value="">All Staff</option>
      </select>
      <button type="button" class="px-4 py-2 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">Filter</button>
    </form>
  </div>

  <div class="bg-surface-container-lowest rounded-xl p-0 shadow-sm border border-outline-variant/5 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full">
        <thead class="bg-surface-container">
          <tr class="text-left text-[12px] text-on-surface-variant uppercase tracking-widest">
            <th class="px-4 py-3">Receipt</th>
            <th class="px-4 py-3">Date</th>
            <th class="px-4 py-3">Items</th>
            <th class="px-4 py-3 text-right">Subtotal</th>
            <th class="px-4 py-3 text-right">Total</th>
            <th class="px-4 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-t border-outline-variant/10">
            <td class="px-4 py-3">#R-0001</td>
            <td class="px-4 py-3">—</td>
            <td class="px-4 py-3">—</td>
            <td class="px-4 py-3 text-right">₦0.00</td>
            <td class="px-4 py-3 text-right">₦0.00</td>
            <td class="px-4 py-3 text-right">
              <a href="/ui/sales/1" class="px-3 py-1 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant">View</a>
            </td>
          </tr>
          <tr>
            <td colspan="6" class="px-4 py-6 text-center text-on-surface-variant">No sales recorded yet.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
@endsection