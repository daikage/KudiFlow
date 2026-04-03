@extends('layouts.tailwind')

@section('title', 'New Plan')
@section('search_placeholder', 'Search...')

@section('content')
  <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
    <h2 class="text-xl font-bold mb-4">Create Plan</h2>

    @if ($errors->any())
      <div class="mb-4 p-3 rounded bg-error/10 text-error text-sm font-semibold">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('sa.subscriptions.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      @csrf
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Code</label>
        <input name="code" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="e.g. pro" value="{{ old('code') }}" required>
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Name</label>
        <input name="name" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="e.g. Pro" value="{{ old('name') }}" required>
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Price</label>
        <input name="price" inputmode="decimal" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="{{ old('price', 0) }}" required>
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Interval</label>
        <select name="interval" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
          <option value="monthly" @selected(old('interval','monthly')==='monthly')>Monthly</option>
          <option value="yearly" @selected(old('interval')==='yearly')>Yearly</option>
        </select>
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Status</label>
        <select name="status" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
          <option value="active" @selected(old('status','active')==='active')>Active</option>
          <option value="inactive" @selected(old('status')==='inactive')>Inactive</option>
        </select>
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Sort</label>
        <input name="sort" inputmode="numeric" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="{{ old('sort', 0) }}">
      </div>

      <div class="md:col-span-2">
        <p class="text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-2">Entitlements</p>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
          @foreach($modules as $m)
            <label class="inline-flex items-center gap-2">
              <input type="checkbox" name="entitlements[{{ $m }}]" value="1" @checked(old('entitlements.'.$m,false))>
              <span class="text-sm">{{ ucfirst($m) }}</span>
            </label>
          @endforeach
        </div>
      </div>

      <div class="md:col-span-2 flex gap-2">
        <a href="{{ route('sa.subscriptions.index') }}" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Cancel</a>
        <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Save Plan</button>
      </div>
    </form>
  </div>
@endsection
