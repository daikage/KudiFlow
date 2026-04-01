@extends('layouts.tailwind')

@section('title', 'Record Sale')
@section('search_placeholder', 'Search products (SKU or name)...')
@section('main_classes', 'p-8 w-full')

@section('content')
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h2 class="text-2xl font-extrabold tracking-tight mb-1">Record Sale</h2>
      <p class="text-on-surface-variant text-sm mb-4">Add item and complete payment</p>

      @if($errors->any())
        <div class="mb-4 p-3 rounded bg-error/10 text-error text-sm font-semibold">Please fix the errors below.</div>
      @endif

      <form action="{{ route('ui.sales.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
        @csrf
        <div class="md:col-span-2">
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Product</label>
          <select name="product_id" class="w-full bg-surface-container-low border @error('product_id') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2">
            <option value="">— Select —</option>
            @foreach($products as $p)
              <option value="{{ $p->id }}" @selected(old('product_id')==$p->id)>{{ $p->name }} — ₦{{ number_format($p->price,2) }} ({{ $p->stock }} left)</option>
            @endforeach
          </select>
          @error('product_id')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Qty</label>
          <input name="qty" value="{{ old('qty',1) }}" class="w-full bg-surface-container-low border @error('qty') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2" inputmode="numeric">
          @error('qty')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="md:col-span-3">
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Payment Method</label>
          <input name="payment_method" value="{{ old('payment_method','cash') }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
        </div>
        <div class="md:col-span-3">
          <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Complete Sale</button>
          <a href="{{ route('ui.sales.index') }}" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Cancel</a>
        </div>
      </form>
    </div>

    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h3 class="text-lg font-bold mb-4">Tips</h3>
      <p class="text-sm text-on-surface-variant">This simple form records a sale with one product line and decrements stock. The POS cart experience can be wired next.</p>
    </div>
  </div>
@endsection