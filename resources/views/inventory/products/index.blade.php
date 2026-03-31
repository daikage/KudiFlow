@extends('layouts.tailwind')

@section('title', 'Sales POS - The Sovereign Ledger')
@section('search_placeholder', 'Search products (SKU or name)...')
@section('main_classes', 'p-8 w-full') {{-- POS needs full width, not centered container --}}

@section('content')
  <div class="flex gap-8 h-[calc(100vh-64px)] overflow-hidden">
    <!-- Left Column: Product Selection -->
    <section class="flex-grow flex flex-col gap-6 overflow-hidden">
      <div class="flex justify-between items-end">
        <div>
          <h2 class="text-3xl font-extrabold text-on-surface tracking-tight mb-1">Product Catalog</h2>
          <p class="text-on-surface-variant text-sm font-medium">Select items to add to current transaction</p>
        </div>
        <div class="flex gap-2">
          <button class="px-4 py-2 rounded-xl bg-surface-container-high text-on-surface-variant text-sm font-semibold hover:bg-surface-variant transition-colors">Popular</button>
          <button class="px-4 py-2 rounded-xl bg-primary text-on-primary text-sm font-semibold shadow-sm">All Categories</button>
        </div>
      </div>

      <!-- Category Grid -->
      <div class="grid grid-cols-4 gap-4 overflow-y-auto pr-2 pb-4">
        <button class="group flex flex-col p-4 bg-surface-container-low rounded-xl hover:bg-white hover:shadow-xl hover:shadow-primary/5 transition-all text-left">
          <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-2xl">local_drink</span>
          </div>
          <span class="font-bold text-on-surface text-sm uppercase tracking-wider opacity-60 mb-1">Bevs</span>
          <span class="font-headline font-extrabold text-lg text-on-surface">Beverages</span>
        </button>
        <button class="group flex flex-col p-4 bg-surface-container-low rounded-xl hover:bg-white hover:shadow-xl hover:shadow-primary/5 transition-all text-left">
          <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-2xl">bakery_dining</span>
          </div>
          <span class="font-bold text-on-surface text-sm uppercase tracking-wider opacity-60 mb-1">Food</span>
          <span class="font-headline font-extrabold text-lg text-on-surface">Bakery</span>
        </button>
        <button class="group flex flex-col p-4 bg-surface-container-low rounded-xl hover:bg-white hover:shadow-xl hover:shadow-primary/5 transition-all text-left">
          <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-800 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-2xl">cleaning_services</span>
          </div>
          <span class="font-bold text-on-surface text-sm uppercase tracking-wider opacity-60 mb-1">Home</span>
          <span class="font-headline font-extrabold text-lg text-on-surface">Toiletries</span>
        </button>
        <button class="group flex flex-col p-4 bg-surface-container-low rounded-xl hover:bg-white hover:shadow-xl hover:shadow-primary/5 transition-all text-left">
          <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-800 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-2xl">kitchen</span>
          </div>
          <span class="font-bold text-on-surface text-sm uppercase tracking-wider opacity-60 mb-1">Cold</span>
          <span class="font-headline font-extrabold text-lg text-on-surface">Dairy &amp; Eggs</span>
        </button>
      </div>

      <!-- Product Grid -->
      <div class="grid grid-cols-3 gap-4 overflow-y-auto pr-2">
        @foreach ([
          ['Super Malt (330ml)','₦450.00','24 in stock','https://lh3.googleusercontent.com/aida-public/AB6AXuAY3DGOxij_8TQfcikwdpgCYC6POPEqTzAfDwBnydVt_mcH7UoOkxwixfF9kFAy2wxdnLjffR5OaxejK8wkYidAid_VsZusWQoQO13aKTIz6pFD41fuONBSuGX_X3C6Wfpz3NRT3aV5CmS5ITF9XWobmgGXcG0-N_90QyiyZ5DRsj3VHncWKk3kooQuFhJHDBtYLFmUzzbk_lA9DsZSmFkjUhnuaoKJO2ujIGnK304xfWUhi6zksfCZrC333YCCda01gjTmRMW9tw'],
          ['Indomie Regular (70g)','₦180.00','112 in stock','https://lh3.googleusercontent.com/aida-public/AB6AXuBEFeu0HjHeMtsMQMYQWZ993U_FLoSv1GxRMKhpweTk_wddXnXL05vkAS2ZIC3uC77yR0victnkk0J-6zwM3h67VSsR_7UJJ-ESe_CZx6lDzGCiazNkpV-TNNVSViPOHI64D6I31-OylSKplJQ9vzGmUGrF9os0frKkcR8z0-LusZ8q6228HBauQF635FBJEo0ZFdeO3V3xDhL4rJ_GhUm8cubh0MGjyx2qbfEjKOs9QDzWa7mfDloIpN850h3tswgg8VQ5fR03XA'],
          ['Premium Loaf (Large)','₦950.00','12 in stock','https://lh3.googleusercontent.com/aida-public/AB6AXuAiVvxXmKHAxkgdxZz_a6ytah-rmgHKfSWTeibGYrRot4jQZJXGxsA031Y32s4JslT28ijknWX6ArmI0XvjKrgA1R8O7_DI1kbPU0k-67KGlmuNgZpMosYSLZbqmkI5W_uSG1GBnLeayls1WhhvKQVUEOzkPMa_yxVgZaDa7Zdl9u5_W1NGi8lVeSksCDT0fDYBWTHKjf3zHARH2dBFZpg-HaVJbcWu1NaDAjyi-zIXAmJn6JDACNpxT7B6B77rp5fK-uyjZuzWxQ'],
          ['Peak Milk (Tin)','₦720.00','34 in stock','https://lh3.googleusercontent.com/aida-public/AB6AXuBrnUUTP6XWDycqbfeSnDgKaM40snw25w1xGX86iVmD7apbLaQxM3XUoPa7o8QYIxi9CgEdwaWpDZRD9r9V7KS1DVgBrNNyRYDroDrWyC8k_1KyoACoF6-P0aqH9cTcHfmaHnDt30ClNJmbC8NsYVP21m8uoH4M_t76zUe2WgSwqQFaw2uYkeAxTTQbZzE2LEolrJ2pHR_BbtOEezXag0uTShoiiqHn2FnXspeId2f4QypQwHEDeGd1lr9u5d9h2vUdFnuSvZxD2g'],
          ['Ariel Powder (400g)','₦1,200.00','18 in stock','https://lh3.googleusercontent.com/aida-public/AB6AXuADaaZkhF7i802Nz21fBxNwtw9dQ2FTtpnnvo64S5RL1OhfAqZuovyDjA4TIbHuXDRHsKW9s8xhDGYjv8QKFGdi4yk9TnT9YYrXWdoAcxIED1JwzA-1LpM_k-1BvR0e3SSFFUgPeLEwRR3eG9Hf2DCDfsHuTS_hp7Wf9h6VVJS-2YsqVxVX0lRuqFROtzdHlqn4nbM1bvwnqOcsdC-RSFPqiznZhz0On-n2On94Ud8IVXtS1Bn4ylEZFES8z-nKx7wqPCD_I6lL3w'],
        ] as [$name,$price,$stock,$img])
          <div class="bg-surface-container-lowest p-4 rounded-xl shadow-sm border border-outline-variant/5 hover:border-primary/20 cursor-pointer group transition-all">
            <div class="aspect-square bg-surface-container rounded-lg mb-3 overflow-hidden">
              <img class="w-full h-full object-cover group-hover:scale-105 transition-transform" src="{{ $img }}" alt="{{ $name }}">
            </div>
            <h4 class="font-bold text-on-surface mb-1">{{ $name }}</h4>
            <div class="flex justify-between items-center">
              <span class="text-primary font-bold">{{ $price }}</span>
              <span class="text-xs font-semibold text-on-surface-variant bg-surface-container-high px-2 py-1 rounded">{{ $stock }}</span>
            </div>
          </div>
        @endforeach
      </div>
    </section>

    <!-- Right Column: Cart Summary -->
    <section class="w-[420px] bg-white rounded-2xl flex flex-col shadow-2xl shadow-emerald-900/5 relative">
      <div class="p-6 border-b border-surface-container-high">
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-xl font-extrabold text-on-surface">Current Order</h3>
          <span class="bg-primary-fixed text-on-primary-fixed text-xs font-bold px-3 py-1 rounded-full">3 Items</span>
        </div>
        <div class="space-y-4">
          <div class="relative">
            <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-1 ml-1">Customer (Optional)</label>
            <div class="flex items-center gap-2 bg-surface-container-low p-3 rounded-xl border-b-2 border-transparent focus-within:border-primary transition-all">
              <span class="material-symbols-outlined text-on-surface-variant">person</span>
              <input class="bg-transparent border-none outline-none text-sm w-full placeholder:text-on-surface-variant/50" placeholder="Walk-in Customer" type="text"/>
            </div>
          </div>
        </div>
      </div>

      <!-- Items List -->
      <div class="flex-grow overflow-y-auto p-6 space-y-6">
        @foreach ([
          ['Super Malt (330ml)','2','₦450.00 per unit','₦900.00'],
          ['Premium Loaf (Large)','1','₦950.00 per unit','₦950.00'],
          ['Indomie Regular (70g)','5','₦180.00 per unit','₦900.00'],
        ] as [$item,$qty,$meta,$total])
          <div class="flex items-center justify-between group">
            <div class="flex gap-4 items-center">
              <div class="w-12 h-12 rounded-lg bg-surface-container flex items-center justify-center font-bold text-primary">{{ $qty }}x</div>
              <div>
                <h5 class="font-bold text-on-surface text-sm">{{ $item }}</h5>
                <p class="text-on-surface-variant text-xs font-medium">{{ $meta }}</p>
              </div>
            </div>
            <div class="text-right">
              <p class="font-bold text-on-surface">{{ $total }}</p>
              <button class="text-error opacity-0 group-hover:opacity-100 transition-opacity">
                <span class="material-symbols-outlined text-sm">delete</span>
              </button>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Footer Summary -->
      <div class="p-6 bg-surface-container-low rounded-b-2xl">
        <div class="space-y-2 mb-6">
          <div class="flex justify-between items-center text-sm font-medium text-on-surface-variant">
            <span>Subtotal</span>
            <span>₦2,750.00</span>
          </div>
          <div class="flex justify-between items-center text-sm font-medium text-on-surface-variant">
            <span>VAT (0%)</span>
            <span>₦0.00</span>
          </div>
          <div class="flex justify-between items-center pt-2">
            <span class="text-lg font-bold text-on-surface">Total Amount</span>
            <span class="text-2xl font-black text-primary font-headline">₦2,750.00</span>
          </div>
        </div>
        <div class="flex flex-col gap-3">
          <button class="w-full bg-primary hover:bg-primary-container text-on-primary py-4 rounded-xl font-bold text-lg flex items-center justify-center gap-2 shadow-lg shadow-primary/20 transition-all active:scale-[0.98]">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            Complete Sale
          </button>
          <button class="w-full bg-white border border-outline-variant/30 text-on-surface-variant py-3 rounded-xl font-semibold text-sm hover:bg-error/5 hover:text-error hover:border-error/20 transition-all">
            Clear Cart
          </button>
        </div>
      </div>
    </section>
  </div>
@endsection