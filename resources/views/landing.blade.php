@extends('layouts.tailwind')

@section('no-sidebar', true)
@section('title', 'Kudiflow — Simple POS and Inventory for Small Businesses')
@section('main_classes', 'p-0 w-full')

@section('content')
  <section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-primary/5 via-transparent to-transparent pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
        <div class="space-y-6">
          <p class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-[12px] font-bold uppercase tracking-widest">
            <span class="material-symbols-outlined text-base">auto_awesome</span>
            New: Built-in POS, Inventory, and Sales Analytics
          </p>
          <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">
            Run your shop with clarity.<br>
            Record sales, manage stock, and grow — fast.
          </h1>
          <p class="text-lg text-on-surface-variant">
            Kudiflow is a lightweight POS and inventory system for market owners and small businesses.
            Keep track of products, record sales in seconds, and understand your performance at a glance.
          </p>
          <div class="flex flex-wrap gap-3">
            <a href="{{ route('register') }}" class="px-5 py-3 rounded-xl bg-primary text-on-primary shadow-sm hover:opacity-90">
              Get Started Free
            </a>
            <a href="{{ route('login') }}" class="px-5 py-3 rounded-xl bg-white border border-outline-variant/30 text-on-surface hover:bg-surface-variant/30">
              Sign In
            </a>
          </div>
          <div class="flex items-center gap-4 text-sm text-on-surface-variant">
            <div class="flex -space-x-2">
              <img class="w-8 h-8 rounded-full ring-2 ring-white" src="https://i.pravatar.cc/40?img=12" alt="">
              <img class="w-8 h-8 rounded-full ring-2 ring-white" src="https://i.pravatar.cc/40?img=32" alt="">
              <img class="w-8 h-8 rounded-full ring-2 ring-white" src="https://i.pravatar.cc/40?img=48" alt="">
            </div>
            <span>Trusted by growing shops and market owners.</span>
          </div>
        </div>

        <div class="relative">
          <div class="rounded-2xl border border-outline-variant/20 shadow-sm bg-surface-container overflow-hidden">
            <img src="https://images.unsplash.com/photo-1556741533-411cf82e4e2d?q=80&w=1200&auto=format&fit=crop" alt="POS demo" class="w-full h-64 object-cover">
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="p-4 rounded-xl bg-surface">
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Today</p>
                <p class="mt-1 text-3xl font-extrabold">₦54,300</p>
                <p class="text-sm text-on-surface-variant">Sales recorded</p>
              </div>
              <div class="p-4 rounded-xl bg-surface">
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Stock</p>
                <p class="mt-1 text-3xl font-extrabold">132</p>
                <p class="text-sm text-on-surface-variant">Items in inventory</p>
              </div>
              <div class="p-4 rounded-xl bg-surface md:col-span-2">
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Fast Checkout</p>
                <p class="mt-1 text-sm text-on-surface-variant">Scan barcodes or enter SKU — record a sale in seconds.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-xl p-6 bg-surface-container-lowest border border-outline-variant/10">
          <span class="material-symbols-outlined text-primary text-2xl mb-2">point_of_sale</span>
          <h3 class="font-bold mb-1">Simple POS</h3>
          <p class="text-sm text-on-surface-variant">Quickly record sales with barcode or SKU. Automatic totals and stock updates.</p>
        </div>
        <div class="rounded-xl p-6 bg-surface-container-lowest border border-outline-variant/10">
          <span class="material-symbols-outlined text-primary text-2xl mb-2">inventory_2</span>
          <h3 class="font-bold mb-1">Easy Inventory</h3>
          <p class="text-sm text-on-surface-variant">Track products, prices, stock levels, and categories with a clean interface.</p>
        </div>
        <div class="rounded-xl p-6 bg-surface-container-lowest border border-outline-variant/10">
          <span class="material-symbols-outlined text-primary text-2xl mb-2">insights</span>
          <h3 class="font-bold mb-1">Sales Insights</h3>
          <p class="text-sm text-on-surface-variant">Know what’s selling and when. Make informed decisions with simple reports.</p>
        </div>
      </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 lg:px-8 py-12">
      <div class="rounded-2xl p-6 md:p-8 bg-primary text-on-primary flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <h3 class="text-2xl font-extrabold">Ready to streamline your shop?</h3>
          <p class="opacity-90">Create your account in minutes. No credit card required.</p>
        </div>
        <div class="flex gap-3">
          <a href="{{ route('register') }}" class="px-5 py-3 rounded-xl bg-white text-primary font-bold">Get Started</a>
          <a href="{{ route('login') }}" class="px-5 py-3 rounded-xl border border-white/40">Sign In</a>
        </div>
      </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 lg:px-8 py-12">
      <p class="text-center text-sm text-on-surface-variant">
        Need help? <a class="text-primary font-semibold" href="{{ route('support.index') }}">Contact Support</a>
      </p>
    </div>
  </section>
@endsection