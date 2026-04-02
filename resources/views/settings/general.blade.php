@extends('layouts.tailwind')

@section('title', 'Store Settings')
@section('search_placeholder', 'Search settings...')

@section('content')
  @php $tenant = \App\Models\Tenant::find(app('tenant_id')); @endphp

  @if(session('success'))
    <div class="mb-4 p-3 rounded bg-primary/10 text-primary text-sm font-semibold">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="mb-4 p-3 rounded bg-error/10 text-error text-sm font-semibold">{{ $errors->first() }}</div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h2 class="text-xl font-extrabold tracking-tight mb-4">Basic Settings</h2>
      <form action="{{ route('ui.settings.general.update') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf @method('PUT')
        <div class="md:col-span-2">
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Company Name</label>
          <input name="name" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="{{ old('name', $tenant?->name) }}" required>
        </div>
        <div class="md:col-span-2">
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Subdomain (optional)</label>
          <input name="subdomain" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="{{ old('subdomain', $tenant?->subdomain) }}" placeholder="e.g. myshop">
        </div>
        <div class="md:col-span-2">
          <button class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Save Settings</button>
        </div>
      </form>
    </div>

    <div class="space-y-4">
      <div class="bg-surface-container-low rounded-xl p-4">
        <h3 class="font-bold mb-2">Tips</h3>
        <p class="text-sm text-on-surface-variant">Your company name appears on invoices and dashboards.</p>
      </div>
    </div>
  </div>
@endsection
