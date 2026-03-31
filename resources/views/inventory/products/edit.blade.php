@extends('layouts.tailwind')

@section('title', 'Edit Product')
@section('search_placeholder', 'Search products...')

@section('content')
  <section class="space-y-6">
    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h2 class="text-xl font-bold mb-4">Edit Product</h2>
      <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Product Name</label>
          <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="Sample Product">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">SKU</label>
          <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="SKU-001">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Category</label>
          <select class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2"><option>General</option></select>
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Status</label>
          <select class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2"><option>Active</option><option>Inactive</option></select>
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Cost</label>
          <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="0.00">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Price</label>
          <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="0.00">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Stock</label>
          <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="0">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Min Stock (Alert)</label>
          <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="0">
        </div>

        <div class="md:col-span-2 flex gap-2 pt-2">
          <a href="/ui/products" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Back</a>
          <button type="button" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Update Product</button>
        </div>
      </form>
    </div>
  </section>
@endsection