@extends('layouts.tailwind')

@section('title', 'Sale Details')
@section('search_placeholder', 'Search receipts...')

@section('content')
  <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
    <h2 class="text-xl font-bold mb-4">Sale Details</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
      <div><p class="text-[12px] text-on-surface-variant uppercase font-bold">Receipt</p><p>#R-0001</p></div>
      <div><p class="text-[12px] text-on-surface-variant uppercase font-bold">Date</p><p>—</p></div>
      <div><p class="text-[12px] text-on-surface-variant uppercase font-bold">Staff</p><p>—</p></div>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full">
        <thead class="bg-surface-container">
          <tr class="text-left text-[12px] text-on-surface-variant uppercase tracking-widest">
            <th class="px-4 py-3">Item</th>
            <th class="px-4 py-3 text-right">Price</th>
            <th class="px-4 py-3 text-right">Qty</th>
            <th class="px-4 py-3 text-right">Total</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-t border-outline-variant/10">
            <td class="px-4 py-3">—</td>
            <td class="px-4 py-3 text-right">₦0.00</td>
            <td class="px-4 py-3 text-right">0</td>
            <td class="px-4 py-3 text-right">₦0.00</td>
          </tr>
        </tbody>
        <tfoot>
          <tr class="border-t border-outline-variant/10 bg-surface-container-low">
            <th colspan="3" class="px-4 py-3 text-right">Grand Total</th>
            <th class="px-4 py-3 text-right">₦0.00</th>
          </tr>
        </tfoot>
      </table>
    </div>

    <div class="mt-4">
      <a href="/ui/sales" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Back</a>
    </div>
  </div>
@endsection