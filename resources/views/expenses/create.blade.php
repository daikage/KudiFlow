@extends('layouts.tailwind')

@section('title', 'Add Expense')
@section('search_placeholder', 'Search expenses...')

@section('content')
  <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
    <h2 class="text-xl font-bold mb-4">Add Expense</h2>
    <form action="{{ route('ui.expenses.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
      @csrf
      <div class="md:col-span-2">
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Title</label>
        <input name="title" value="{{ old('title') }}" class="w-full bg-surface-container-low border @error('title') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2" placeholder="e.g. Diesel">
        @error('title')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Date</label>
        <input type="date" name="date" value="{{ old('date') }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Amount</label>
        <input inputmode="decimal" name="amount" value="{{ old('amount') }}" class="w-full bg-surface-container-low border @error('amount') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2" placeholder="0.00">
        @error('amount')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div class="md:col-span-3">
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Notes</label>
        <textarea rows="4" name="notes" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">{{ old('notes') }}</textarea>
      </div>

      <div class="md:col-span-3 flex gap-2">
        <a href="{{ route('ui.expenses.index') }}" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Cancel</a>
        <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Save</button>
      </div>
    </form>
  </div>
@endsection