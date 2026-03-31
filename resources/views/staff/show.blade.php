@extends('layouts.tailwind')

@section('title', 'Staff Details')
@section('search_placeholder', 'Search staff...')

@section('content')
  <div class="space-y-6">
    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">Staff Details</h2>
        <div class="flex gap-2">
          <a href="/ui/staff/1/edit" class="px-4 py-2 rounded-xl border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Edit</a>
          <a href="/ui/staff" class="px-4 py-2 rounded-xl bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Back</a>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Name</p>
          <p class="font-semibold">Test User</p>
        </div>
        <div>
          <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Email</p>
          <p class="font-semibold">test@example.com</p>
        </div>
        <div>
          <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Role</p>
          <p class="font-semibold">Admin</p>
        </div>
        <div>
          <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Status</p>
          <p class="font-semibold">Active</p>
        </div>
        <div>
          <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Joined</p>
          <p class="text-on-surface-variant">—</p>
        </div>
        <div>
          <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Last Login</p>
          <p class="text-on-surface-variant">—</p>
        </div>
      </div>
    </div>

    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold">Recent Activity</h3>
        <span class="text-[12px] text-on-surface-variant uppercase tracking-widest">Preview</span>
      </div>
      <div class="space-y-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
              <span class="material-symbols-outlined">receipt_long</span>
            </div>
            <div>
              <p class="text-sm font-bold">Recorded Sale #R-0001</p>
              <p class="text-[12px] text-on-surface-variant">—</p>
            </div>
          </div>
          <span class="text-sm font-semibold">₦0.00</span>
        </div>
        <p class="text-on-surface-variant text-sm">No more activity.</p>
      </div>
    </div>
  </div>
@endsection