@extends('layouts.tailwind')

@section('no-sidebar', true)
@section('title', 'Kudiflow — Simple POS and Inventory for Small Businesses')
@section('main_classes', 'p-0 w-full')

@section('content')
  <section class="relative overflow-hidden">
    <!-- Background decorations -->
    <div class="absolute -top-24 -left-24 w-[36rem] h-[36rem] rounded-full bg-primary/10 blur-3xl"></div>
    <div class="absolute -bottom-24 -right-24 w-[28rem] h-[28rem] rounded-full bg-secondary/10 blur-3xl"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-primary/5 via-transparent to-transparent pointer-events-none"></div>

    <!-- Top nav -->
    <header class="relative z-10">
      <div class="max-w-7xl mx-auto px-6 lg:px-8 py-5 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-primary">storefront</span>
          <span class="font-extrabold text-lg">Kudiflow</span>
        </div>
        <nav class="hidden md:flex items-center gap-6 text-sm text-on-surface-variant">
          <a href="#features" class="hover:text-on-surface">Features</a>
          <a href="#pricing" class="hover:text-on-surface">Pricing</a>
          <a href="{{ route('support.index') }}" class="hover:text-on-surface">Support</a>
        </nav>
        <div class="flex items-center gap-2">
          <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg border border-outline-variant/30 bg-white hover:bg-surface-variant/30">Sign in</a>
          <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Get Started</a>
        </div>
      </div>
    </header>

    <!-- Hero -->
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 pt-8 lg:pt-16 pb-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
        <div class="space-y-6">
          <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-[12px] font-bold uppercase tracking-widest">
            <span class="material-symbols-outlined text-base">auto_awesome</span>
            Built-in POS • Inventory • Insights
          </span>

          <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">
            Run your shop with clarity.
            <span class="text-primary block">Sell faster. Stock smarter.</span>
          </h1>

          <p class="text-lg text-on-surface-variant">
            Kudiflow helps market owners and small businesses record sales in seconds, track stock without stress,
            and see what’s really driving profit — all in one simple app.
          </p>

          <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('register') }}" class="px-5 py-3 rounded-xl bg-primary text-on-primary shadow-sm hover:opacity-90">
              Start free trial
            </a>
            <a href="{{ route('login') }}" class="px-5 py-3 rounded-xl bg-white border border-outline-variant/30 text-on-surface hover:bg-surface-variant/30">
              Sign in
            </a>
            <span class="text-sm text-on-surface-variant">No credit card required</span>
          </div>

          <div class="flex items-center gap-4 text-sm text-on-surface-variant">
            <div class="flex -space-x-2">
              <img class="w-8 h-8 rounded-full ring-2 ring-white" src="https://i.pravatar.cc/40?img=12" alt="">
              <img class="w-8 h-8 rounded-full ring-2 ring-white" src="https://i.pravatar.cc/40?img=32" alt="">
              <img class="w-8 h-8 rounded-full ring-2 ring-white" src="https://i.pravatar.cc/40?img=48" alt="">
            </div>
            <span>Trusted by growing shops and market owners</span>
          </div>

          <div class="grid grid-cols-3 gap-4 pt-2">
            <div class="rounded-xl p-4 bg-surface">
              <p class="text-[12px] font-bold text-on-surface-variant uppercase tracking-widest">Today</p>
              <p class="mt-1 text-2xl font-extrabold">₦54,300</p>
              <p class="text-xs text-on-surface-variant">Sales recorded</p>
            </div>
            <div class="rounded-xl p-4 bg-surface">
              <p class="text-[12px] font-bold text-on-surface-variant uppercase tracking-widest">Stock</p>
              <p class="mt-1 text-2xl font-extrabold">132</p>
              <p class="text-xs text-on-surface-variant">Items in inventory</p>
            </div>
            <div class="rounded-xl p-4 bg-surface">
              <p class="text-[12px] font-bold text-on-surface-variant uppercase tracking-widest">Low stock</p>
              <p class="mt-1 text-2xl font-extrabold">7</p>
              <p class="text-xs text-on-surface-variant">Restock reminders</p>
            </div>
          </div>
        </div>

        <div class="relative">
          <div class="rounded-2xl border border-outline-variant/20 shadow-sm bg-surface-container overflow-hidden">
            <img src="https://images.unsplash.com/photo-1556741533-411cf82e4e2d?q=80&w=1200&auto=format&fit=crop" alt="POS demo" class="w-full h-64 md:h-80 object-cover">
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="p-4 rounded-xl bg-surface">
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Fast Checkout</p>
                <p class="mt-1 text-sm text-on-surface-variant">Scan barcodes with your phone camera or type SKU. Receipts in seconds.</p>
              </div>
              <div class="p-4 rounded-xl bg-surface">
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Works Offline</p>
                <p class="mt-1 text-sm text-on-surface-variant">Keep selling even when internet drops. Sync when you’re back.</p>
              </div>
            </div>
          </div>
          <div class="absolute -bottom-4 -left-4 bg-white/70 backdrop-blur border border-outline-variant/20 rounded-xl p-3 shadow-sm hidden md:flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">qr_code_scanner</span>
            <div>
              <p class="text-sm font-semibold">Barcode-ready</p>
              <p class="text-[12px] text-on-surface-variant">No special hardware needed</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Logos / Social proof -->
    <div class="max-w-7xl mx-auto px-6 lg:px-8 pb-8">
      <p class="text-center text-xs uppercase tracking-widest text-on-surface-variant mb-4">Built for Nigerian MSMEs</p>
      <div class="flex flex-wrap justify-center gap-8 opacity-70">
        <span class="font-bold">Provisions</span>
        <span class="font-bold">Minimarts</span>
        <span class="font-bold">Pharmacy</span>
        <span class="font-bold">Drinks & Bars</span>
        <span class="font-bold">Beauty</span>
      </div>
    </div>

    <!-- Features -->
    <section id="features" class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="rounded-xl p-6 bg-surface-container-lowest border border-outline-variant/10">
          <span class="material-symbols-outlined text-primary text-2xl mb-2">point_of_sale</span>
          <h3 class="font-bold mb-1">Simple POS</h3>
          <p class="text-sm text-on-surface-variant">Record sales in seconds with cash or transfer. Share receipts via WhatsApp.</p>
        </div>
        <div class="rounded-xl p-6 bg-surface-container-lowest border border-outline-variant/10">
          <span class="material-symbols-outlined text-primary text-2xl mb-2">inventory_2</span>
          <h3 class="font-bold mb-1">Easy Inventory</h3>
          <p class="text-sm text-on-surface-variant">Track SKU, barcode, unit conversions, low-stock alerts, and categories.</p>
        </div>
        <div class="rounded-xl p-6 bg-surface-container-lowest border border-outline-variant/10">
          <span class="material-symbols-outlined text-primary text-2xl mb-2">insights</span>
          <h3 class="font-bold mb-1">Sales Insights</h3>
          <p class="text-sm text-on-surface-variant">See best sellers, daily totals, and smart reorder suggestions.</p>
        </div>
        <div class="rounded-xl p-6 bg-surface-container-lowest border border-outline-variant/10">
          <span class="material-symbols-outlined text-primary text-2xl mb-2">shield_lock</span>
          <h3 class="font-bold mb-1">Roles & Permissions</h3>
          <p class="text-sm text-on-surface-variant">Admin, manager, staff — simple controls to protect your business data.</p>
        </div>
        <div class="rounded-xl p-6 bg-surface-container-lowest border border-outline-variant/10">
          <span class="material-symbols-outlined text-primary text-2xl mb-2">cloud_sync</span>
          <h3 class="font-bold mb-1">Sync Across Devices</h3>
          <p class="text-sm text-on-surface-variant">Use your phone at the counter and your laptop for back-office — stays in sync.</p>
        </div>
        <div class="rounded-xl p-6 bg-surface-container-lowest border border-outline-variant/10">
          <span class="material-symbols-outlined text-primary text-2xl mb-2">chat</span>
          <h3 class="font-bold mb-1">WhatsApp-first</h3>
          <p class="text-sm text-on-surface-variant">Send receipts and low-stock notifications via WhatsApp. Email optional.</p>
        </div>
      </div>
    </section>

    <!-- How it works -->
    <section class="max-w-7xl mx-auto px-6 lg:px-8 py-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-xl p-6 bg-surface">
          <span class="text-[12px] font-bold uppercase tracking-widest text-on-surface-variant">Step 1</span>
          <h4 class="font-bold mt-1 mb-2">Add your products</h4>
          <p class="text-sm text-on-surface-variant">Import via CSV or add quickly with SKU/barcode and price.</p>
        </div>
        <div class="rounded-xl p-6 bg-surface">
          <span class="text-[12px] font-bold uppercase tracking-widest text-on-surface-variant">Step 2</span>
          <h4 class="font-bold mt-1 mb-2">Record sales</h4>
          <p class="text-sm text-on-surface-variant">Scan with your phone camera or type SKU. Print/share receipts.</p>
        </div>
        <div class="rounded-xl p-6 bg-surface">
          <span class="text-[12px] font-bold uppercase tracking-widest text-on-surface-variant">Step 3</span>
          <h4 class="font-bold mt-1 mb-2">Track and grow</h4>
          <p class="text-sm text-on-surface-variant">See what’s selling, get low-stock alerts, and restock with confidence.</p>
        </div>
      </div>
    </section>

    <!-- Testimonial -->
    <section class="max-w-5xl mx-auto px-6 lg:px-8 py-10">
      <div class="rounded-2xl border border-outline-variant/20 bg-surface-container p-6 md:p-10">
        <div class="flex items-start gap-4">
          <img class="w-12 h-12 rounded-full" src="https://i.pravatar.cc/96?img=16" alt="">
          <div>
            <p class="text-lg leading-relaxed">“Kudiflow made our checkout twice as fast. My staff can record sales easily even when internet is poor, and I get alerts when stock is low. It just works.”</p>
            <p class="mt-2 text-sm text-on-surface-variant">— Ada, Minimart Owner, Surulere</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Pricing preview -->
    <section id="pricing" class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
      <h3 class="text-2xl font-extrabold text-center mb-6">Simple, honest pricing</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="rounded-2xl border border-outline-variant/20 bg-surface p-6">
          <h4 class="font-bold text-lg">Starter</h4>
          <p class="text-sm text-on-surface-variant mb-4">Perfect for solo shops</p>
          <p class="text-3xl font-extrabold mb-4">Free</p>
          <ul class="text-sm space-y-2 text-on-surface-variant">
            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-primary">check</span> POS and sales recording</li>
            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-primary">check</span> Basic inventory tracking</li>
            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-primary">check</span> WhatsApp receipts</li>
          </ul>
        </div>
        <div class="rounded-2xl border-2 border-primary bg-surface p-6 relative">
          <span class="absolute -top-3 right-4 text-[10px] font-bold uppercase bg-primary text-on-primary px-2 py-1 rounded">Most Popular</span>
          <h4 class="font-bold text-lg">Pro</h4>
          <p class="text-sm text-on-surface-variant mb-4">For growing businesses</p>
          <p class="text-3xl font-extrabold mb-4">₦2,500<span class="text-base font-semibold text-on-surface-variant">/mo</span></p>
          <ul class="text-sm space-y-2 text-on-surface-variant">
            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-primary">check</span> Everything in Starter</li>
            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-primary">check</span> Low-stock alerts & insights</li>
            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-primary">check</span> Roles & permissions</li>
          </ul>
        </div>
      </div>
      <div class="text-center mt-6">
        <a href="{{ route('register') }}" class="px-6 py-3 rounded-xl bg-primary text-on-primary shadow-sm">Start free trial</a>
      </div>
    </section>

    <!-- FAQ -->
    <section class="max-w-5xl mx-auto px-6 lg:px-8 pb-12">
      <h3 class="text-2xl font-extrabold text-center mb-6">Common questions</h3>
      <div class="space-y-3">
        <details class="rounded-xl bg-surface p-4 border border-outline-variant/10">
          <summary class="cursor-pointer font-semibold">Does it work without internet?</summary>
          <p class="mt-2 text-sm text-on-surface-variant">Yes. You can keep recording sales during outages and your data syncs when back online.</p>
        </details>
        <details class="rounded-xl bg-surface p-4 border border-outline-variant/10">
          <summary class="cursor-pointer font-semibold">Do I need a barcode scanner?</summary>
          <p class="mt-2 text-sm text-on-surface-variant">No. Your phone camera scans barcodes. You can also type SKU or select products.</p>
        </details>
        <details class="rounded-xl bg-surface p-4 border border-outline-variant/10">
          <summary class="cursor-pointer font-semibold">How do I get support?</summary>
          <p class="mt-2 text-sm text-on-surface-variant">We’re available on WhatsApp and email. Visit the Support page to reach us.</p>
        </details>
      </div>
    </section>

    <!-- Final CTA -->
    <section class="max-w-6xl mx-auto px-6 lg:px-8 pb-16">
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
      <p class="mt-6 text-center text-sm text-on-surface-variant">
        Need help? <a class="text-primary font-semibold" href="{{ route('support.index') }}">Contact Support</a>
      </p>
    </section>
  </section>
@endsection