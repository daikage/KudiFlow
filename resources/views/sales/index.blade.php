@extends('layouts.tailwind')

@section('title', 'Sales')
@section('search_placeholder', 'Search receipts or products...')

@section('content')
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-bold">Sales</h2>
    <a href="{{ route('ui.sales.create') }}" class="px-4 py-2 rounded-xl bg-primary text-on-primary shadow-sm">Record Sale</a>
  </div>

  @if(session('success'))
    <div class="mb-4 p-3 rounded bg-primary/10 text-primary text-sm font-semibold">{{ session('success') }}</div>
  @endif

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
            <th class="px-4 py-3">ID</th>
            <th class="px-4 py-3">Date</th>
            <th class="px-4 py-3 text-right">Subtotal</th>
            <th class="px-4 py-3 text-right">Total</th>
            <th class="px-4 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sales as $s)
            <tr class="border-t border-outline-variant/10">
              <td class="px-4 py-3">#{{ $s->id }}</td>
              <td class="px-4 py-3">{{ $s->created_at->format('Y-m-d H:i') }}</td>
              <td class="px-4 py-3 text-right">₦{{ number_format($s->subtotal,2) }}</td>
              <td class="px-4 py-3 text-right">₦{{ number_format($s->total,2) }}</td>
              <td class="px-4 py-3 text-right">
                <a href="{{ route('ui.sales.show', $s) }}" class="px-3 py-1 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant">View</a>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="px-4 py-6 text-center text-on-surface-variant">No sales recorded yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-4">{{ $sales->links() }}</div>
@endsection