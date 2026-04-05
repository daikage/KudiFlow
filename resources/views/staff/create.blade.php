@extends('layouts.tailwind')

@section('title', 'Add Staff')
@section('search_placeholder', 'Search staff...')

@section('content')
  <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
    <h2 class="text-xl font-bold mb-4">Add Staff</h2>
    @if($errors->any())
      <div class="mb-4 p-3 rounded bg-error/10 text-error text-sm font-semibold">Please fix the errors below.</div>
    @endif
    <form action="{{ route('ui.staff.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      @csrf
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Name</label>
        <input name="name" value="{{ old('name') }}" class="w-full bg-surface-container-low border @error('name') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2" placeholder="Full name">
        @error('name')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-surface-container-low border @error('email') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2" placeholder="email@example.com">
        @error('email')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div class="md:col-span-2 md:max-w-xs">
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Role</label>
        <select name="role" class="w-full bg-surface-container-low border @error('role') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2">
          <option value="staff" @selected(old('role','staff')==='staff')>Staff</option>
          <option value="manager" @selected(old('role')==='manager')>Manager</option>
          <option value="admin" @selected(old('role')==='admin')>Admin</option>
        </select>
        @error('role')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Password (optional)</label>
        <input type="password" name="password" class="w-full bg-surface-container-low border @error('password') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2" placeholder="Set a password or leave blank">
        @error('password')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
        <p class="text-[12px] text-on-surface-variant mt-1">Leave blank to auto-generate a strong password.</p>
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Confirm Password</label>
        <input type="password" name="password_confirmation" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="Confirm password">
      </div>
      <div class="md:col-span-2 flex gap-2">
        <a href="/ui/staff" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Cancel</a>
        <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Invite</button>
      </div>
    </form>
  </div>
@endsection