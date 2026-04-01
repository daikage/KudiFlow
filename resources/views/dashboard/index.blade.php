@extends('layouts.tailwind')

@section('title', "Owner's Dashboard")
@section('search_placeholder', 'Search transactions, products...')

@section('content')
  <!-- Hero Section -->
  <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 profit-gradient rounded-xl p-8 text-on-primary-container relative overflow-hidden shadow-xl">
      <div class="relative z-10 flex flex-col h-full justify-between">
        <div>
          <span class="inline-flex items-center gap-2 bg-white/10 px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm">
            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">trending_up</span>
            Real-time Profit Today
          </span>
          <h2 class="font-headline text-5xl md:text-6xl font-extrabold mt-6 tracking-tight">₦{{ number_format($profitToday, 2) }}</h2>
          <p class="text-primary-fixed/80 mt-2 font-medium">
            @if($deltaPercent >= 0)
              +{{ number_format($deltaPercent, 1) }}% from same time yesterday
            @else
              {{ number_format($deltaPercent, 1) }}% from same time yesterday
            @endif
          </p>
        </div>
        <div class="mt-12 flex gap-8">
          <div>
            <p class="text-xs uppercase tracking-widest text-primary-fixed/60 font-bold">Total Sales (Today)</p>
            <p class="text-xl font-bold">₦{{ number_format($salesToday, 0) }}</p>
          </div>
          <div>
            <p class="text-xs uppercase tracking-widest text-primary-fixed/60 font-bold">Expenses (Today)</p>
            <p class="text-xl font-bold">₦{{ number_format($expensesToday, 0) }}</p>
          </div>
        </div>
      </div>
      <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
    </div>

    <div class="flex flex-col gap-6">
      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <div class="flex justify-between items-start mb-4">
          <p class="text-on-surface-variant font-bold text-xs uppercase tracking-wider">Most Sold Today</p>
          <span class="material-symbols-outlined text-primary">stars</span>
        </div>
        @if($topProductToday)
          <p class="font-headline text-xl font-bold">{{ $topProductToday->name }}</p>
          <p class="text-sm text-on-surface-variant mt-1">{{ $topProductToday->units }} units sold today</p>
          @php
            $cap = max(1, $topProductToday->units);
            $pct = min(100, ($topProductToday->units / $cap) * 100);
          @endphp
          <div class="mt-4 w-full bg-surface-container rounded-full h-2">
            <div class="profit-gradient h-full rounded-full" style="width: {{ $pct }}%"></div>
          </div>
        @else
          <p class="text-sm text-on-surface-variant">No sales recorded yet today.</p>
        @endif
      </div>

      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <div class="flex justify-between items-start mb-4">
          <p class="text-error font-bold text-xs uppercase tracking-wider">Low Stock Alerts</p>
          <span class="material-symbols-outlined text-error">warning</span>
        </div>
        @if($lowStock->count())
          <div class="space-y-3">
            @foreach($lowStock as $ls)
              <div class="flex justify-between items-center">
                <span class="text-sm font-medium">{{ $ls->name }}</span>
                <span class="bg-error-container text-on-error-container text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $ls->stock }} LEFT</span>
              </div>
            @endforeach
          </div>
        @else
          <p class="text-sm text-on-surface-variant">No low stock items.</p>
        @endif
        <a href="{{ route('ui.products.index') }}" class="w-full mt-4 text-xs font-bold text-primary hover:underline flex items-center justify-center gap-1">
          Manage Inventory <span class="material-symbols-outlined text-xs">arrow_forward</span>
        </a>
      </div>
    </div>
  </section>

  <!-- Performance & Recent Sales -->
  <section class="grid grid-cols-1 lg:grid-cols-5 gap-8">
    <div class="lg:col-span-3 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <div class="flex justify-between items-center mb-8">
        <div>
          <h3 class="font-headline text-lg font-bold">Weekly Performance</h3>
          <p class="text-xs text-on-surface-variant">Sales vs Expenses (Last 7 Days)</p>
        </div>
        <div class="flex gap-4">
          <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-sm bg-primary"></span>
            <span class="text-[10px] font-bold text-on-surface-variant">SALES</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-sm bg-secondary-container"></span>
            <span class="text-[10px] font-bold text-on-surface-variant">EXPENSES</span>
          </div>
        </div>
      </div>
      <div class="flex items-end justify-between h-48 gap-4 px-2">
        @foreach ($weekly as $point)
          @php
            $sH = $weeklyMax ? round(($point['sales'] / $weeklyMax) * 100) : 0;
            $eH = $weeklyMax ? round(($point['expenses'] / $weeklyMax) * 100) : 0;
          @endphp
          <div class="flex flex-col items-center flex-1 gap-2 h-full">
            <div class="w-full flex items-end justify-center gap-1 h-full">
              <div class="bg-primary w-full rounded-t-sm" style="height: {{ $sH }}%"></div>
              <div class="bg-secondary-container w-full rounded-t-sm" style="height: {{ $eH }}%"></div>
            </div>
            <span class="text-[10px] font-bold text-slate-400">{{ $point['label'] }}</span>
          </div>
        @endforeach
      </div>
    </div>

    <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5 flex flex-col">
      <div class="flex justify-between items-center mb-6">
        <h3 class="font-headline text-lg font-bold">Recent Sales</h3>
        <a href="{{ route('ui.sales.index') }}" class="text-xs text-primary font-bold">View Ledger</a>
      </div>
      <div class="space-y-5 flex-1 overflow-y-auto pr-2">
        @forelse ($recentSales as $s)
          @php
            $meta = $s->created_at->format('h:i A') . ' • ' . strtoupper($s->payment_method ?? 'N/A');
            $cls  = $s->status === 'completed' ? 'text-primary' : ($s->status === 'pending' ? 'text-tertiary' : 'text-on-surface-variant');
          @endphp
          <div class="flex items-center justify-between group">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                <span class="material-symbols-outlined">receipt_long</span>
              </div>
              <div>
                <p class="text-sm font-bold">INV-{{ $s->id }}</p>
                <p class="text-[10px] text-on-surface-variant font-medium">{{ $meta }}</p>
              </div>
            </div>
            <div class="text-right">
              <p class="text-sm font-bold">₦{{ number_format($s->total, 2) }}</p>
              <p class="text-[10px] {{ $cls }} font-bold uppercase tracking-tight">{{ $s->status }}</p>
            </div>
          </div>
        @empty
          <p class="text-on-surface-variant text-sm">No recent sales.</p>
        @endforelse
      </div>
    </div>
  </section>

  <!-- Bottom Highlights -->
  <section class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="md:col-span-1 bg-surface-container-low rounded-xl p-6 flex flex-col justify-center items-center text-center">
      <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant mb-2">Inventory Value</p>
      <p class="font-headline text-2xl font-bold">₦{{ number_format($inventoryValue, 0) }}</p>
      <p class="text-xs text-primary font-medium mt-1">Ready for sale</p>
    </div>
    <div class="md:col-span-1 bg-surface-container-low rounded-xl p-6 flex flex-col justify-center items-center text-center">
      <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant mb-2">Expenses (MTD)</p>
      <p class="font-headline text-2xl font-bold">₦{{ number_format($expensesMTD, 0) }}</p>
      <p class="text-xs text-error font-medium mt-1">Month-to-date</p>
    </div>
    <div class="md:col-span-2 bg-secondary-container/30 border border-secondary/10 rounded-xl p-6 flex items-center gap-6">
      <div class="w-16 h-16 rounded-full bg-secondary-fixed flex items-center justify-center text-secondary">
        <span class="material-symbols-outlined text-3xl">lightbulb</span>
      </div>
      <div>
        <h4 class="font-bold text-secondary">Smart Insight</h4>
        @if($topProductToday)
          <p class="text-sm text-secondary/80 leading-relaxed">
            {{ $topProductToday->name }} is trending today ({{ $topProductToday->units }} units). Consider restocking if below threshold.
          </p>
        @else
          <p class="text-sm text-secondary/80 leading-relaxed">Make your first sale to unlock tailored insights.</p>
        @endif
      </div>
    </div>
  </section>
@endsection