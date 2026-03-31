@extends('layouts.tailwind')

@section('title', 'Expense Details')
@section('search_placeholder', 'Search expenses...')

@section('content')
  <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
    <h2 class="text-xl font-bold mb-4">Expense Details</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div><p class="text-[12px] text-on-surface-variant uppercase font-bold">Title</p><p>—</p></div>
      <div><p class="text-[12px] text-on-surface-variant uppercase font-bold">Date</p><p>—</p></div>
      <div><p class="text-[12px] text-on-surface-variant uppercase font-bold">Amount</p><p>₦0.00</p></div>
    </div>
    <div class="mt-4">
      <p class="text-[12px] text-on-surface-variant uppercase font-bold">Notes</p>
      <p class="text-on-surface-variant">—</p>
    </div>
    <div class="mt-4">
      <a href="/ui/expenses" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Back</a>
    </div>
  </div>
@endsection