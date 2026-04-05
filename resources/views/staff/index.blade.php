@extends('layouts.tailwind')

@section('title', 'Staff')
@section('search_placeholder', 'Search staff...')

@section('content')
   @if(session('success'))
    <div class="mb-4 p-3 rounded bg-primary/10 text-primary text-sm font-semibold">
      {{ session('success') }}
    </div>
  @endif
  @if(session('new_staff'))
    <div class="mb-4 p-3 rounded bg-surface-container text-on-surface text-sm">
      <p class="font-semibold">New staff credentials</p>
      <p>Email: <span class="font-mono">{{ session('new_staff.email') }}</span></p>
      <p>Password: <span class="font-mono">{{ session('new_staff.password') }}</span></p>
      <p class="text-[12px] text-on-surface-variant mt-1">Share this with the staff member securely. It will not be shown again.</p>
    </div>
  @endif

  <div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-bold">Staff</h2>
    <a href="{{ route('ui.staff.create') }}" class="px-4 py-2 rounded-xl bg-primary text-on-primary shadow-sm">Add Staff</a>
  </div>

  <div class="bg-surface-container-lowest rounded-xl p-0 shadow-sm border border-outline-variant/5 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full">
        <thead class="bg-surface-container">
          <tr class="text-left text-[12px] text-on-surface-variant uppercase tracking-widest">
            <th class="px-4 py-3">Name</th>
            <th class="px-4 py-3">Email</th>
            <th class="px-4 py-3">Role</th>
            <th class="px-4 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($staff ?? [] as $member)
            <tr class="border-t border-outline-variant/10">
              <td class="px-4 py-3">{{ $member->name }}</td>
              <td class="px-4 py-3">{{ $member->email }}</td>
              <td class="px-4 py-3">{{ ucfirst($member->role) }}</td>
              <td class="px-4 py-3 text-right">
                <a href="{{ route('ui.staff.show', $member->id) }}" class="px-3 py-1 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant">View</a>
                <a href="{{ route('ui.staff.edit', $member->id) }}" class="px-3 py-1 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">Edit</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="px-4 py-6 text-center text-on-surface-variant">Invite your team to collaborate.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection