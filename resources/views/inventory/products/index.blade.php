@extends('layouts.tailwind')

@section('title', 'Sales POS - The Sovereign Ledger')
@section('search_placeholder', 'Search products (SKU or name)...')
@section('main_classes', 'p-8 w-full') {{-- POS needs full width, not centered container --}}

@section('content')
  @if(session('success'))
    <div class="mb-4 p-3 rounded bg-primary/10 text-primary text-sm font-semibold">{{ session('success') }}</div>
  @endif

  <div class="flex gap-8 h-[calc(100vh-64px)] overflow-hidden">
    <!-- Left Column -->
    <section class="flex-grow flex flex-col gap-6 overflow-hidden">
      <div class="flex justify-between items-end">
        <div>
          <h2 class="text-3xl font-extrabold text-on-surface tracking-tight mb-1">Product Catalog</h2>
          <p class="text-on-surface-variant text-sm font-medium">Select items to add to current transaction</p>
        </div>
        <div class="flex gap-2">
          <a href="{{ route('ui.products.create') }}" class="px-4 py-2 rounded-xl bg-primary text-on-primary text-sm font-semibold shadow-sm">Add Product</a>
        </div>
      </div>

      <!-- Product Grid -->
      <div class="grid grid-cols-3 gap-4 overflow-y-auto pr-2">
        @forelse ($products as $p)
          <a href="{{ route('ui.products.show', $p) }}" class="bg-surface-container-lowest p-4 rounded-xl shadow-sm border border-outline-variant/5 hover:border-primary/20 group transition-all">
            <div class="aspect-square bg-surface-container rounded-lg mb-3 overflow-hidden">
              @if($p->image_url)
                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform" src="{{ $p->image_url }}" alt="{{ $p->name }}">
              @else
                <div class="w-full h-full flex items-center justify-center text-on-surface-variant">No Image</div>
              @endif
            </div>
            <h4 class="font-bold text-on-surface mb-1">{{ $p->name }}</h4>
            <div class="flex justify-between items-center">
              <span class="text-primary font-bold">₦{{ number_format($p->price, 2) }}</span>
              <span class="text-xs font-semibold text-on-surface-variant bg-surface-container-high px-2 py-1 rounded">{{ $p->stock }} in stock</span>
            </div>
            <div class="mt-2 text-[10px] text-on-surface-variant">SKU: {{ $p->sku }} @if($p->category) • {{ $p->category->name }} @endif</div>
          </a>
        @empty
          <div class="col-span-3 text-on-surface-variant">No products yet.</div>
        @endforelse
      </div>

      <div class="mt-2">{{ $products->withQueryString()->links() }}</div>
    </section>

    <!-- Right Column could host POS cart later -->
    <section class="w-[420px] rounded-2xl"></section>
  </div>
@endsection