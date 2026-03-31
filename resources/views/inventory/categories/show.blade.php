@extends('layouts.tailwind')

@section('title', 'Category Details')
@section('search_placeholder', 'Search categories...')

@section('content')
  <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
    <h2 class="text-xl font-bold mb-4">Category Details</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Name</p>
        <p class="font-semibold">General</p>
      </div>
      <div class="md:col-span-2">
        <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Description</p>
        <p class="text-on-surface-variant">Default category</p>
      </div>
    </div>
  </div>
@endsection