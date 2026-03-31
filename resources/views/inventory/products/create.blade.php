@extends('layouts.tailwind')

@section('title', 'Create Product')
@section('search_placeholder', 'Search products...')

@section('content')
  <section class="space-y-6">
    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h2 class="text-xl font-bold mb-4">New Product</h2>
      <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Product Name</label>
          <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="e.g. Pepsi 50cl">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">SKU</label>
          <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="e.g. PEP-50">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Category</label>
          <select class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
            <option>General</option>
          </select>
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Status</label>
          <select class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
            <option>Active</option>
            <option>Inactive</option>
          </select>
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Cost</label>
          <input inputmode="decimal" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="0.00">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Price</label>
          <input inputmode="decimal" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="0.00">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Stock</label>
          <input inputmode="numeric" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="0">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Min Stock (Alert)</label>
          <input inputmode="numeric" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="0">
        </div>

        <div class="md:col-span-2 flex gap-2 pt-2">
          <a href="/ui/products" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Cancel</a>
          <button type="button" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Save Product</button>
        </div>
      </form>
    </div>
  </section>
@endsection