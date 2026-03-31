@extends('layouts.tailwind')

@section('title', 'Staff')
@section('search_placeholder', 'Search staff...')

@section('content')
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-bold">Staff</h2>
    <a href="/ui/staff/create" class="px-4 py-2 rounded-xl bg-primary text-on-primary shadow-sm">Add Staff</a>
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
          <tr class="border-t border-outline-variant/10">
            <td class="px-4 py-3">Test User</td>
            <td class="px-4 py-3">test@example.com</td>
            <td class="px-4 py-3">Admin</td>
            <td class="px-4 py-3 text-right">
              <a href="/ui/staff/1" class="px-3 py-1 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant">View</a>
              <a href="/ui/staff/1/edit" class="px-3 py-1 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">Edit</a>
            </td>
          </tr>
          <tr>
            <td colspan="4" class="px-4 py-6 text-center text-on-surface-variant">Invite your team to collaborate.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
@endsection