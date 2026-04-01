@extends('layouts.tailwind')

@section('title', 'Tenants')
@section('search_placeholder', 'Search tenants...')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-bold">Tenants</h2>
    <a href="{{ route('sa.tenants.store') }}" class="px-4 py-2 rounded-xl bg-primary text-on-primary shadow-sm">New Tenant</a>
</div>

@if(session('success'))
    <div class="mb-4 p-3 rounded bg-primary/10 text-primary text-sm font-semibold">{{ session('success') }}</div>
@endif

<div class="bg-surface-container-lowest rounded-xl p-0 shadow-sm border border-outline-variant/5 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-surface-container">
                <tr class="text-left text-[12px] text-on-surface-variant uppercase tracking-widest">
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Subdomain</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Created</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                <tr class="border-t border-outline-variant/10">
                    <td class="px-4 py-3">{{ $tenant->name }}</td>
                    <td class="px-4 py-3">{{ $tenant->subdomain ?? '—' }}</td>
                    <td class="px-4 py-3">
                        @if($tenant->isPaused())
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-error-container/20 text-error-container text-xs">
                                <span class="material-symbols-outlined text-sm">pause</span>
                                Paused
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-primary-container/20 text-primary-container text-xs">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                Active
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ $tenant->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex gap-2 justify-end">
                            @if($tenant->isPaused())
                                <form method="POST" action="{{ route('admin.tenants.resume', $tenant) }}">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-lg bg-primary text-on-primary text-sm">
                                        Resume
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.tenants.pause', $tenant) }}" class="flex gap-2">
                                    @csrf
                                    <input type="text" name="reason" placeholder="Reason" class="text-sm border rounded-lg px-2 py-1" required>
                                    <button type="submit" class="px-3 py-1 rounded-lg bg-error text-on-error text-sm">
                                        Pause
                                    </button>
                                </form>
                            @endif
                            
                            <form method="POST" action="{{ route('admin.tenants.destroy', $tenant) }}" onsubmit="return confirm('Delete this tenant? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1 rounded-lg border border-error text-error text-sm hover:bg-error/5">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-on-surface-variant">No tenants found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $tenants->links() }}</div>
@endsection
