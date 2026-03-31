@extends('layouts.tailwind')

@section('title', 'Create Category')
@section('search_placeholder', 'Search categories...')

@section('content')
  <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
    <h2 class="text-xl font-bold mb-4">New Category</h2>
    <form action="#" method="POST" class="grid grid-cols-1 gap-4">
      @csrf
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Name</label>
        <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="e.g. Beverages">
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Description</label>
        <textarea rows="4" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="Optional"></textarea>
      </div>
      <div class="flex gap-2">
        <a href="/ui/categories" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Cancel</a>
        <button type="button" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Save</button>
      </div>
    </form>
  </div>
@endsection