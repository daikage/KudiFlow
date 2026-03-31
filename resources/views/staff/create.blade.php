@extends('layouts.tailwind')

@section('title', 'Add Staff')
@section('search_placeholder', 'Search staff...')

@section('content')
  <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
    <h2 class="text-xl font-bold mb-4">Add Staff</h2>
    <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      @csrf
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Name</label>
        <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="Full name">
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Email</label>
        <input type="email" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="email@example.com">
      </div>
      <div class="md:col-span-2 md:max-w-xs">
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Role</label>
        <select class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
          <option>Staff</option><option>Manager</option><option>Admin</option>
        </select>
      </div>
      <div class="md:col-span-2 flex gap-2">
        <a href="/ui/staff" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Cancel</a>
        <button type="button" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Invite</button>
      </div>
    </form>
  </div>
@endsection