@extends('layouts.tailwind')

@section('title', 'Create Category')
@section('search_placeholder', 'Search categories...')

@section('content')
  <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
    <h2 class="text-xl font-bold mb-4">New Category</h2>
    <form action="{{ route('ui.categories.store') }}" method="POST" class="grid grid-cols-1 gap-4">
      @csrf
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Name</label>
        <input name="name" value="{{ old('name') }}" class="w-full bg-surface-container-low border @error('name') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2" placeholder="e.g. Beverages">
        @error('name')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Description</label>
        <textarea name="description" rows="4" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="Optional">{{ old('description') }}</textarea>
      </div>
      <div class="flex gap-2">
        <a href="{{ route('ui.categories.index') }}" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Cancel</a>
        <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Save</button>
      </div>
    </form>
  </div>
@endsection