@extends('layouts.tailwind')

@section('title', 'Edit Expense')
@section('search_placeholder', 'Search expenses...')

@section('content')
  <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
    <h2 class="text-xl font-bold mb-4">Edit Expense</h2>
    <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
      @csrf
      <div class="md:col-span-2">
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Title</label>
        <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="—">
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Date</label>
        <input type="date" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Amount</label>
        <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="0.00">
      </div>
      <div class="md:col-span-3">
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Notes</label>
        <textarea rows="4" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">—</textarea>
      </div>

      <div class="md:col-span-3 flex gap-2">
        <a href="/ui/expenses" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Back</a>
        <button type="button" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Update</button>
      </div>
    </form>
  </div>
@endsection