@extends('layouts.tailwind')

@section('title', 'Forecast')
@section('search_placeholder', 'Search forecast...')

@section('content')
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-3 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <div class="flex items-center justify-between mb-3">
        <h2 class="text-xl font-extrabold">Profit Forecast</h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="p-4 rounded-xl bg-surface-container border border-outline-variant/10">
          <p class="text-[11px] uppercase tracking-widest text-on-surface-variant font-bold">Profit Today</p>
          <p class="text-2xl font-extrabold mt-1">₦{{ number_format($overall['profit_today'], 2) }}</p>
        </div>
        <div class="p-4 rounded-xl bg-surface-container border border-outline-variant/10">
          <p class="text-[11px] uppercase tracking-widest text-on-surface-variant font-bold">Avg (Last 7 Days)</p>
          <p class="text-2xl font-extrabold mt-1">₦{{ number_format($overall['profit_7d_avg'], 2) }}</p>
        </div>
        <div class="p-4 rounded-xl bg-surface-container border border-outline-variant/10">
          <p class="text-[11px] uppercase tracking-widest text-on-surface-variant font-bold">Forecast Next 7 Days</p>
          <p class="text-2xl font-extrabold mt-1">₦{{ number_format($overall['profit_next_7d_sum'], 2) }}</p>
        </div>
      </div>
      <p class="text-xs text-on-surface-variant mt-4">Forecast uses a simple trend from the last 30 days of revenue, COGS, and expenses.</p>
    </div>

    <div class="lg:col-span-3 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h3 class="text-lg font-bold mb-4">Inventory Forecast</h3>
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-surface-container">
            <tr class="text-left text-[12px] text-on-surface-variant uppercase tracking-widest">
              <th class="px-4 py-3">Product</th>
              <th class="px-4 py-3">Stock</th>
              <th class="px-4 py-3">Avg Daily Units</th>
              <th class="px-4 py-3">Days to Deplete</th>
              <th class="px-4 py-3">Price Now</th>
              <th class="px-4 py-3">Price in 30 Days</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products as $p)
              <tr class="border-t border-outline-variant/10">
                <td class="px-4 py-3">{{ $p['name'] }}</td>
                <td class="px-4 py-3">{{ $p['stock'] }}</td>
                <td class="px-4 py-3">{{ number_format($p['avg_daily_units'], 2) }}</td>
                <td class="px-4 py-3">
                  @if($p['days_to_deplete'] !== null)
                    <span class="text-[11px] font-bold px-2 py-1 rounded-full bg-primary/10 text-primary">{{ $p['days_to_deplete'] }} days</span>
                  @else
                    <span class="text-[11px] text-on-surface-variant">No recent sales</span>
                  @endif
                </td>
                <td class="px-4 py-3">
                  {{ $p['price_now'] !== null ? ('₦'.number_format($p['price_now'], 2)) : '—' }}
                </td>
                <td class="px-4 py-3">
                  {{ $p['price_30d'] !== null ? ('₦'.number_format($p['price_30d'], 2)) : '—' }}
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-4 py-6 text-center text-on-surface-variant">No products found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
