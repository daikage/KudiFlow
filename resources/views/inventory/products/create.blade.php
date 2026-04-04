@extends('layouts.tailwind')

@section('title', 'Create Product')
@section('search_placeholder', 'Search products...')

@section('content')
  <section class="space-y-6">
    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h2 class="text-xl font-bold mb-4">New Product</h2>

      @if($errors->any())
        <div class="mb-4 p-3 rounded bg-error/10 text-error text-sm font-semibold">Please fix the errors below.</div>
      @endif

      <form action="{{ route('ui.products.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Product Name</label>
          <input name="name" value="{{ old('name') }}" class="w-full bg-surface-container-low border @error('name') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2" placeholder="e.g. Pepsi 50cl">
          @error('name')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">SKU</label>
          <input name="sku" value="{{ old('sku') }}" class="w-full bg-surface-container-low border @error('sku') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2" placeholder="e.g. PEP-50">
          @error('sku')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <!-- NEW: Barcode -->
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Barcode (optional)</label>
          <input name="barcode" value="{{ old('barcode') }}" class="w-full bg-surface-container-low border @error('barcode') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2" placeholder="EAN-13/Code-128">
          @error('barcode')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Category</label>
          <select name="category_id" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
            <option value="">— None —</option>
            @foreach($categories as $c)
              <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Status</label>
          <select name="status" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
            <option value="active" @selected(old('status','active')=='active')>Active</option>
            <option value="inactive" @selected(old('status')=='inactive')>Inactive</option>
          </select>
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Cost</label>
          <input name="cost" inputmode="decimal" value="{{ old('cost') }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="0.00">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Price</label>
          <input name="price" inputmode="decimal" value="{{ old('price') }}" class="w-full bg-surface-container-low border @error('price') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2" placeholder="0.00">
          @error('price')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Stock</label>
          <input name="stock" inputmode="numeric" value="{{ old('stock',0) }}" class="w-full bg-surface-container-low border @error('stock') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2" placeholder="0">
          @error('stock')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Min Stock (Alert)</label>
          <input name="min_stock" inputmode="numeric" value="{{ old('min_stock',0) }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="0">
        </div>
        <div class="md:col-span-2 flex gap-2 pt-2">
          <a href="{{ route('ui.products.index') }}" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Cancel</a>
          <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Save Product</button>
        </div>
      </form>
    </div>
  </section>
@endsection