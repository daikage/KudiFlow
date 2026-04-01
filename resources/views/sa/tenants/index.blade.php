@extends('layouts.tailwind')

@section('title', 'Companies')
@section('search_placeholder', 'Search companies...')

@section('content')
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold">Companies</h2>
    <form action="{{ route('sa.tenants.store') }}" method="POST" class="flex gap-2">
      @csrf
      <input name="name" class="bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2 text-sm" placeholder="New company name" required>
      <input name="subdomain" class="bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2 text-sm" placeholder="subdomain (optional)">
      <button class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Create</button>
    </form>
  </div>

  @if(session('success'))
    <div class="mb-4 p-3 rounded bg-primary/10 text-primary text-sm font-semibold">{{ session('success') }}</div>
  @endif

  <div class="bg-surface-container-lowest rounded-xl p-0 shadow-sm border border-outline-variant/5 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full">
        <thead class="bg-surface-container">
          <tr class="text-left text-[12px] text-on-surface-variant uppercase tracking-widest">
            <th class="px-4 py-3">ID</th>
            <th class="px-4 py-3">Name</th>
            <th class="px-4 py-3">Subdomain</th>
            <th class="px-4 py-3">Joined</th>
            <th class="px-4 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($tenants as $t)
            <tr class="border-t border-outline-variant/10">
              <td class="px-4 py-3">#{{ $t->id }}</td>
              <td class="px-4 py-3">{{ $t->name }}</td>
              <td class="px-4 py-3">{{ $t->subdomain ?? '—' }}</td>
              <td class="px-4 py-3">{{ $t->created_at->format('Y-m-d') }}</td>
              <td class="px-4 py-3 text-right">
                <a href="{{ route('sa.tenants.dashboard', $t) }}" class="px-3 py-1 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant">Open Dashboard</a>
                <a href="{{ route('ui.dashboard', ['tenant_id' => $t->id]) }}" class="px-3 py-1 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">Open App</a>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="px-4 py-6 text-center text-on-surface-variant">No companies.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-4">{{ $tenants->links() }}</div>
@endsection
