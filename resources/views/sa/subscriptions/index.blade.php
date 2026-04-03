@extends('layouts.tailwind')

@section('title', 'Platform Subscriptions')
@section('search_placeholder', 'Search subscriptions...')

@section('content')
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-bold">Plans</h2>
    <a href="{{ route('sa.subscriptions.create') }}" class="px-4 py-2 rounded-xl bg-primary text-on-primary shadow-sm">New Plan</a>
  </div>

  @if(session('success'))
    <div class="mb-4 p-3 rounded bg-primary/10 text-primary text-sm font-semibold">{{ session('success') }}</div>
  @endif

  <div class="bg-surface-container-lowest rounded-xl p-0 shadow-sm border border-outline-variant/5 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full">
        <thead class="bg-surface-container">
          <tr class="text-left text-[12px] text-on-surface-variant uppercase tracking-widest">
            <th class="px-4 py-3">Code</th>
            <th class="px-4 py-3">Name</th>
            <th class="px-4 py-3">Price</th>
            <th class="px-4 py-3">Interval</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Entitlements</th>
            <th class="px-4 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($plans as $plan)
            <tr class="border-t border-outline-variant/10">
              <td class="px-4 py-3 font-mono text-sm">{{ $plan->code }}</td>
              <td class="px-4 py-3">{{ $plan->name }}</td>
              <td class="px-4 py-3">₦{{ number_format($plan->price, 2) }}</td>
              <td class="px-4 py-3">{{ ucfirst($plan->interval) }}</td>
              <td class="px-4 py-3">
                <span class="text-[10px] font-bold px-2 py-1 rounded-full {{ $plan->status === 'active' ? 'bg-primary-container/40 text-on-primary-container' : 'bg-surface-container-high text-on-surface-variant' }}">
                  {{ strtoupper($plan->status) }}
                </span>
              </td>
              <td class="px-4 py-3 text-[11px] text-on-surface-variant">
                @php $e = $plan->entitlements ?? []; @endphp
                <div class="flex flex-wrap gap-1">
                  @foreach (['inventory','sales','finance','people','admin'] as $m)
                    <span class="px-2 py-0.5 rounded-full {{ ($e[$m] ?? false) ? 'bg-primary/10 text-primary' : 'bg-surface-container-high text-on-surface-variant' }}">
                      {{ ucfirst($m) }}
                    </span>
                  @endforeach
                </div>
              </td>
              <td class="px-4 py-3 text-right">
                <div class="inline-flex gap-2">
                  <a href="{{ route('sa.subscriptions.edit', $plan) }}" class="px-3 py-1 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">Edit</a>
                  <form action="{{ route('sa.subscriptions.destroy', $plan) }}" method="POST" onsubmit="return confirm('Delete this plan?')" class="inline-block">
                    @csrf @method('DELETE')
                    <button class="px-3 py-1 rounded-lg border border-error text-error hover:bg-error/5" type="submit">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-4 py-6 text-center text-on-surface-variant">No plans yet. Create your first plan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
