@extends('layouts.tailwind')

@section('title', 'Edit Staff')
@section('search_placeholder', 'Search staff...')

@section('content')
  <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
    <h2 class="text-xl font-bold mb-4">Edit Staff</h2>
    @if(session('success'))
      <div class="mb-4 p-3 rounded bg-primary/10 text-primary text-sm font-semibold">{{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="mb-4 p-3 rounded bg-error/10 text-error text-sm font-semibold">Please fix the errors below.</div>
    @endif
    @php $updated = session('updated_staff'); @endphp
    @if($updated)
      <div class="mb-4 p-3 rounded bg-surface-container text-on-surface text-sm">
        <p class="font-semibold">Updated staff credentials</p>
        <p>Email: <span class="font-mono">{{ $updated['email'] }}</span></p>
        <p>Password: <span class="font-mono">{{ $updated['password'] }}</span></p>
        <p class="text-[12px] text-on-surface-variant mt-1">Share this securely. It will not be shown again.</p>
      </div>
    @endif
    <form action="{{ route('ui.staff.update', $staff->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      @csrf
      @method('PUT')
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Name</label>
        <input name="name" class="w-full bg-surface-container-low border @error('name') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2" value="{{ old('name', $staff->name) }}">
        @error('name')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Email</label>
        <input type="email" name="email" class="w-full bg-surface-container-low border @error('email') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2" value="{{ old('email', $staff->email) }}">
        @error('email')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div class="md:col-span-2 md:max-w-xs">
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Role</label>
        <select name="role" class="w-full bg-surface-container-low border @error('role') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2">
          <option value="admin" @selected(old('role', $staff->role)==='admin')>Admin</option>
          <option value="manager" @selected(old('role', $staff->role)==='manager')>Manager</option>
          <option value="staff" @selected(old('role', $staff->role)==='staff')>Staff</option>
        </select>
        @error('role')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">New Password (optional)</label>
        <input type="password" name="password" class="w-full bg-surface-container-low border @error('password') border-error @else border-outline-variant/30 @enderror rounded-lg px-3 py-2" placeholder="Leave blank to keep current">
        @error('password')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Confirm Password</label>
        <input type="password" name="password_confirmation" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="Re-enter new password">
      </div>
      <div class="md:col-span-2 flex gap-2">
        <a href="{{ route('ui.staff.index') }}" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Back</a>
        <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Update</button>
      </div>
    </form>
  </div>
@endsection