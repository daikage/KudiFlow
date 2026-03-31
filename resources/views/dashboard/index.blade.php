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
          <h2 class="font-headline text-5xl md:text-6xl font-extrabold mt-6 tracking-tight">₦42,850.00</h2>
          <p class="text-primary-fixed/80 mt-2 font-medium">+12.5% from same time yesterday</p>
        </div>
        <div class="mt-12 flex gap-8">
          <div>
            <p class="text-xs uppercase tracking-widest text-primary-fixed/60 font-bold">Total Sales</p>
            <p class="text-xl font-bold">₦154,200</p>
          </div>
          <div>
            <p class="text-xs uppercase tracking-widest text-primary-fixed/60 font-bold">Expenses</p>
            <p class="text-xl font-bold">₦111,350</p>
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
        <p class="font-headline text-xl font-bold">Indomie Onion (40ct)</p>
        <p class="text-sm text-on-surface-variant mt-1">128 units sold today</p>
        <div class="mt-4 w-full bg-surface-container rounded-full h-2">
          <div class="profit-gradient h-full rounded-full" style="width: 85%"></div>
        </div>
      </div>

      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <div class="flex justify-between items-start mb-4">
          <p class="text-error font-bold text-xs uppercase tracking-wider">Low Stock Alerts</p>
          <span class="material-symbols-outlined text-error">warning</span>
        </div>
        <div class="space-y-3">
          <div class="flex justify-between items-center">
            <span class="text-sm font-medium">Peak Milk (Liquid)</span>
            <span class="bg-error-container text-on-error-container text-[10px] px-2 py-0.5 rounded-full font-bold">4 LEFT</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-sm font-medium">Golden Penny Sugar</span>
            <span class="bg-error-container text-on-error-container text-[10px] px-2 py-0.5 rounded-full font-bold">12 LEFT</span>
          </div>
        </div>
        <button class="w-full mt-4 text-xs font-bold text-primary hover:underline flex items-center justify-center gap-1">
          Restock Inventory <span class="material-symbols-outlined text-xs">arrow_forward</span>
        </button>
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
        @foreach (['MON'=>[60,40],'TUE'=>[75,35],'WED'=>[90,45],'THU'=>[70,55],'FRI'=>[85,30],'SAT'=>[100,20],'SUN'=>[40,15]] as $d => [$s,$e])
          <div class="flex flex-col items-center flex-1 gap-2 h-full">
            <div class="w-full flex items-end justify-center gap-1 h-full">
              <div class="bg-primary w-full rounded-t-sm" style="height: {{ $s }}%"></div>
              <div class="bg-secondary-container w-full rounded-t-sm" style="height: {{ $e }}%"></div>
            </div>
            <span class="text-[10px] font-bold text-slate-400">{{ $d }}</span>
          </div>
        @endforeach
      </div>
    </div>

    <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5 flex flex-col">
      <div class="flex justify-between items-center mb-6">
        <h3 class="font-headline text-lg font-bold">Recent Sales</h3>
        <button class="text-xs text-primary font-bold">View Ledger</button>
      </div>
      <div class="space-y-5 flex-1 overflow-y-auto pr-2">
        @foreach ([
          ['INV-4921','10:45 AM • Cash Sale','₦14,500','Completed','text-primary'],
          ['INV-4920','10:12 AM • POS Terminal','₦2,800','Completed','text-primary'],
          ['INV-4919','09:55 AM • Transfer','₦32,100','Pending','text-tertiary'],
          ['INV-4918','09:30 AM • Cash Sale','₦1,250','Completed','text-primary'],
        ] as [$no,$meta,$amt,$status,$cls])
          <div class="flex items-center justify-between group">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                <span class="material-symbols-outlined">receipt_long</span>
              </div>
              <div>
                <p class="text-sm font-bold">{{ $no }}</p>
                <p class="text-[10px] text-on-surface-variant font-medium">{{ $meta }}</p>
              </div>
            </div>
            <div class="text-right">
              <p class="text-sm font-bold">{{ $amt }}</p>
              <p class="text-[10px] {{ $cls }} font-bold uppercase tracking-tight">{{ $status }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Bottom Highlights -->
  <section class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="md:col-span-1 bg-surface-container-low rounded-xl p-6 flex flex-col justify-center items-center text-center">
      <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant mb-2">Inventory Value</p>
      <p class="font-headline text-2xl font-bold">₦2.4M</p>
      <p class="text-xs text-primary font-medium mt-1">Ready for sale</p>
    </div>
    <div class="md:col-span-1 bg-surface-container-low rounded-xl p-6 flex flex-col justify-center items-center text-center">
      <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant mb-2">Total Expenses</p>
      <p class="font-headline text-2xl font-bold">₦111K</p>
      <p class="text-xs text-error font-medium mt-1">+5% from avg.</p>
    </div>
    <div class="md:col-span-2 bg-secondary-container/30 border border-secondary/10 rounded-xl p-6 flex items-center gap-6">
      <div class="w-16 h-16 rounded-full bg-secondary-fixed flex items-center justify-center text-secondary">
        <span class="material-symbols-outlined text-3xl">lightbulb</span>
      </div>
      <div>
        <h4 class="font-bold text-secondary">Smart Insight</h4>
        <p class="text-sm text-secondary/80 leading-relaxed">Purchasing Indomie Onion 70g in bulk tomorrow could save you ₦4,500 based on supplier price drops.</p>
      </div>
    </div>
  </section>
@endsection