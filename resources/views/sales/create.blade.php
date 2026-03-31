@extends('layouts.tailwind')

@section('title', 'Record Sale')
@section('search_placeholder', 'Search products (SKU or name)...')
@section('main_classes', 'p-8 w-full')

@section('content')
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 h-[calc(100vh-64px)] overflow-hidden">
    <div class="lg:col-span-2 flex flex-col gap-6 overflow-hidden">
      <div>
        <h2 class="text-2xl font-extrabold tracking-tight mb-1">Record Sale</h2>
        <p class="text-on-surface-variant text-sm">Add items and complete payment</p>
      </div>

      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <form class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
          <div class="md:col-span-2">
            <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Find Product</label>
            <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="Search by name or SKU">
          </div>
          <div>
            <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Qty</label>
            <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" inputmode="numeric" value="1">
          </div>
          <div class="md:col-span-3">
            <button type="button" class="px-4 py-2 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">Add Item</button>
          </div>
        </form>

        <div class="mt-4 overflow-x-auto">
          <table class="min-w-full">
            <thead class="bg-surface-container">
              <tr class="text-left text-[12px] text-on-surface-variant uppercase tracking-widest">
                <th class="px-4 py-3">Item</th>
                <th class="px-4 py-3 text-right">Price</th>
                <th class="px-4 py-3 text-right">Qty</th>
                <th class="px-4 py-3 text-right">Line Total</th>
                <th class="px-4 py-3 text-right">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr><td class="px-4 py-3 text-on-surface-variant" colspan="5">No items in cart</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-2xl flex flex-col shadow-2xl shadow-emerald-900/5 relative">
      <div class="p-6 border-b border-surface-container-high">
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-xl font-extrabold text-on-surface">Payment</h3>
          <span class="bg-primary-fixed text-on-primary-fixed text-xs font-bold px-3 py-1 rounded-full">0 Items</span>
        </div>
        <div class="space-y-3">
          <div>
            <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Customer (Optional)</label>
            <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="Walk-in Customer">
          </div>
          <div>
            <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Notes</label>
            <textarea rows="3" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="Optional"></textarea>
          </div>
        </div>
      </div>

      <div class="p-6 space-y-3">
        <div class="flex justify-between text-sm text-on-surface-variant">
          <span>Subtotal</span><span>₦0.00</span>
        </div>
        <div class="flex justify-between text-sm text-on-surface-variant">
          <span>VAT (0%)</span><span>₦0.00</span>
        </div>
        <div class="flex justify-between items-center pt-2">
          <span class="text-lg font-bold">Total</span>
          <span class="text-2xl font-black text-primary font-headline">₦0.00</span>
        </div>

        <div class="flex flex-col gap-2 pt-2">
          <button class="w-full bg-primary hover:bg-primary-container text-on-primary py-3 rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span> Complete Sale
          </button>
          <a href="/ui/sales" class="w-full text-center px-4 py-3 rounded-xl bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Cancel</a>
        </div>
      </div>
    </div>
  </div>
@endsection