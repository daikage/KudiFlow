@extends('layouts.tailwind')

@section('title', 'My Profile')
@section('search_placeholder', 'Search settings...')

@section('content')
  @if(session('success'))
    <div class="mb-4 p-3 rounded bg-primary/10 text-primary text-sm font-semibold">{{ session('success') }}</div>
  @endif

  @php
    $user = auth()->user();
    $tenantName = \App\Models\Tenant::find($user->tenant_id)?->name;
    $roleLabel = ($user->super_admin ?? false) ? 'Platform Super Admin' : ucfirst($user->role ?? 'staff');
  @endphp

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5 text-center">
      <div class="w-24 h-24 rounded-full overflow-hidden object-cover mx-auto mb-3 ring-2 ring-white shadow-sm">
        <img class="w-full h-full object-cover"
             src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10b981&color=fff"
             alt="Profile">
      </div>
      <h2 class="font-bold text-lg">{{ $user->name }}</h2>
      <p class="text-sm text-on-surface-variant">{{ $roleLabel }}</p>
      <p class="text-xs text-on-surface-variant mt-1">{{ $tenantName }}</p>
      <a href="{{ route('ui.profile.edit') }}" class="mt-3 inline-flex px-4 py-2 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">Edit Profile</a>
    </div>

    <div class="lg:col-span-2 space-y-6">
      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <h3 class="font-bold mb-4">Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Full Name</p>
            <p class="font-semibold">{{ $user->name }}</p>
          </div>
          <div>
            <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Email</p>
            <p class="font-semibold">{{ $user->email }}</p>
          </div>
          <div>
            <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Company</p>
            <p class="font-semibold">{{ $tenantName ?? '—' }}</p>
          </div>
          <div>
            <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Role</p>
            <p class="font-semibold">{{ $roleLabel }}</p>
          </div>
        </div>
      </div>

      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <h3 class="font-bold mb-4">Security</h3>
        <p class="text-sm text-on-surface-variant mb-3">Change your password from the Edit Profile page.</p>
        <a href="{{ route('ui.profile.edit') }}" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Edit Profile</a>
      </div>
    </div>
  </div>
@endsection
