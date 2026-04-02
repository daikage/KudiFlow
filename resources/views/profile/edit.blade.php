@extends('layouts.tailwind')

@section('title', 'Edit Profile')
@section('search_placeholder', 'Search settings...')

@section('content')
  @php $user = auth()->user(); @endphp

  @if ($errors->any())
    <div class="mb-4 p-3 rounded bg-error/10 text-error text-sm font-semibold">
      {{ $errors->first() }}
    </div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5 text-center">
      <div class="w-24 h-24 rounded-full overflow-hidden object-cover mx-auto mb-3 ring-2 ring-white shadow-sm">
        <img class="w-full h-full object-cover"
             src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10b981&color=fff"
             alt="Profile">
      </div>
      <p class="text-sm text-on-surface-variant">Avatar is generated from your name.</p>
    </div>

    <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h3 class="font-bold mb-4">Edit Details</h3>
      <form action="{{ route('ui.profile.update') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf
        @method('PUT')

        <div class="md:col-span-2">
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Full Name</label>
          <input name="name" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="md:col-span-2">
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Email</label>
          <input name="email" type="email" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="{{ old('email', $user->email) }}" required>
        </div>

        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">New Password</label>
          <input name="password" type="password" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="Leave blank to keep current">
        </div>

        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Confirm Password</label>
          <input name="password_confirmation" type="password" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="Re-enter new password">
        </div>

        <div class="md:col-span-2">
          <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Save Profile</button>
          <a href="{{ route('ui.profile.show') }}" class="ml-2 px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Cancel</a>
        </div>
      </form>
    </div>
  </div>
@endsection
