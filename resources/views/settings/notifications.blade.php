@extends('layouts.tailwind')

@section('title', 'Settings • Notifications')
@section('search_placeholder', 'Search notifications...')

@section('content')
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-bold">Notifications</h2>
    <a href="/ui/settings/general" class="px-3 py-2 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">General</a>
  </div>

  <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
    <form class="space-y-4">
      <div class="flex items-center justify-between p-4 rounded-lg bg-surface-container">
        <div>
          <p class="font-semibold">Low Stock Alerts</p>
          <p class="text-sm text-on-surface-variant">Email me when products go below threshold</p>
        </div>
        <label class="inline-flex items-center cursor-pointer">
          <input type="checkbox" class="sr-only">
          <span class="w-10 h-6 bg-surface-variant rounded-full relative">
            <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition"></span>
          </span>
        </label>
      </div>

      <div class="flex items-center justify-between p-4 rounded-lg bg-surface-container">
        <div>
          <p class="font-semibold">Daily Summary</p>
          <p class="text-sm text-on-surface-variant">Sales & expenses snapshot</p>
        </div>
        <label class="inline-flex items-center cursor-pointer">
          <input type="checkbox" class="sr-only" checked>
          <span class="w-10 h-6 bg-primary/40 rounded-full relative">
            <span class="absolute left-5 top-1 w-4 h-4 bg-primary rounded-full transition"></span>
          </span>
        </label>
      </div>

      <button type="button" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Save Preferences</button>
    </form>
  </div>
@endsection
