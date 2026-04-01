@extends('layouts.tailwind')

@section('title', 'Role Permissions')
@section('search_placeholder', 'Search settings...')

@section('content')
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold">Role Permissions (Per Company)</h2>
    <a href="{{ route('admin.index') }}" class="px-3 py-2 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">Back to Admin</a>
  </div>

  @if(session('success'))
    <div class="mb-4 p-3 rounded bg-primary/10 text-primary text-sm font-semibold">{{ session('success') }}</div>
  @endif

  <form method="POST" action="{{ route('admin.roles.update') }}">
    @csrf
    <div class="bg-surface-container-lowest rounded-xl p-0 shadow-sm border border-outline-variant/5 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-surface-container">
            <tr class="text-left text-[12px] text-on-surface-variant uppercase tracking-widest">
              <th class="px-4 py-3">Role</th>
              <th class="px-4 py-3">Inventory</th>
              <th class="px-4 py-3">Sales</th>
              <th class="px-4 py-3">Finance</th>
              <th class="px-4 py-3">People</th>
              <th class="px-4 py-3">Admin</th>
            </tr>
          </thead>
          <tbody>
            @php
              $labels = ['admin' => 'Admin', 'manager' => 'Manager', 'staff' => 'Staff'];
            @endphp
            @foreach($roles as $role)
              @php $perms = optional($matrix->get($role))->permissions ?? []; @endphp
              <tr class="border-t border-outline-variant/10">
                <td class="px-4 py-3 font-semibold">{{ $labels[$role] }}</td>
                @foreach($modules as $m)
                  <td class="px-4 py-3">
                    <label class="inline-flex items-center gap-2">
                      <input type="checkbox" name="perm[{{ $role }}][{{ $m }}]" @checked(($perms[$m] ?? false) === true)>
                      <span class="text-sm">{{ ucfirst($m) }}</span>
                    </label>
                  </td>
                @endforeach
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="mt-4 flex gap-2">
      <button class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Save Permissions</button>
      <a href="{{ route('admin.index') }}" class="px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Cancel</a>
    </div>
  </form>

  <div class="mt-6 p-4 bg-secondary-container/20 rounded-lg border border-secondary/10">
    <p class="text-sm text-on-surface-variant">
      Notes:
      - Staff default: Sales only.
      - Manager default: All except Admin.
      - Admin default: All modules. Platform admins (super admins) can access all companies.
    </p>
  </div>
@endsection
