@extends('layouts.tailwind')

@section('title', 'Settings • General')
@section('search_placeholder', 'Search settings...')

@section('content')
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-bold">General Settings</h2>
    <div class="flex gap-2">
      <a href="/ui/settings/billing" class="px-3 py-2 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">Billing</a>
      <a href="/ui/settings/notifications" class="px-3 py-2 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">Notifications</a>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h3 class="font-bold mb-4">Store Profile</h3>
      <form class="space-y-3">
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Store Name</label>
          <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="Your Store Ltd.">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Tagline</label>
          <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="e.g. Quality Everyday">
        </div>
        <button type="button" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Save Changes</button>
      </form>
    </div>

    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h3 class="font-bold mb-4">Regional</h3>
      <form class="grid grid-cols-2 gap-3">
        <div class="col-span-2">
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Address</label>
          <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Currency</label>
          <select class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
            <option>NGN</option>
          </select>
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Timezone</label>
          <select class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
            <option>Africa/Lagos</option>
          </select>
        </div>
        <div class="col-span-2">
          <button type="button" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Update Regional</button>
        </div>
      </form>
    </div>
  </div>
@endsection
