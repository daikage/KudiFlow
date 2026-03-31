@extends('layouts.tailwind')

@section('title', 'Product Details')
@section('search_placeholder', 'Search products...')

@section('content')
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <h2 class="text-lg font-bold mb-4">Overview</h2>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Name</p>
            <p class="font-semibold">Sample Product</p>
          </div>
          <div>
            <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">SKU</p>
            <p class="font-semibold">SKU-001</p>
          </div>
          <div>
            <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Category</p>
            <p class="font-semibold">General</p>
          </div>
        </div>
        <div class="grid grid-cols-4 gap-4 mt-4">
          <div><p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Cost</p><p>₦0.00</p></div>
          <div><p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Price</p><p>₦0.00</p></div>
          <div><p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Stock</p><p>0</p></div>
          <div><p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Min Stock</p><p>0</p></div>
        </div>
      </div>

      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <h2 class="text-lg font-bold mb-4">Recent Sales</h2>
        <p class="text-on-surface-variant">No sales yet.</p>
      </div>
    </div>
    <div class="space-y-3">
      <a href="/ui/products/1/edit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Edit</a>
      <a href="/ui/sales/create" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-primary text-on-primary">Sell Item</a>
    </div>
  </div>
@endsection