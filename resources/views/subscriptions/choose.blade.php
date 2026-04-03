@extends('layouts.tailwind')

@section('no-sidebar', true)
@section('title', 'Choose Your Plan')
@section('search_placeholder', 'Search...')

@section('content')
  <div class="min-h-[80vh] flex items-center justify-center">
    <div class="w-full max-w-2xl bg-surface-container-lowest rounded-2xl p-8 shadow border border-outline-variant/10">
      <h1 class="text-2xl font-extrabold mb-2">Welcome! Pick how you’d like to start</h1>
      <p class="text-on-surface-variant mb-6">You can begin a 14-day trial or select a plan to activate immediately.</p>

      @if (session('success'))
        <div class="mb-4 p-3 rounded bg-primary/10 text-primary text-sm font-semibold">{{ session('success') }}</div>
      @endif

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="rounded-xl border border-outline-variant/10 p-5 bg-surface-container">
          <h3 class="font-bold text-lg">Start Trial</h3>
          <p class="text-sm text-on-surface-variant mt-1">Try all core features free for 14 days.</p>
          <form method="POST" action="{{ route('subscriptions.start_trial') }}" class="mt-4">
            @csrf
            <button class="w-full px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Start 14‑day Trial</button>
          </form>
        </div>

        <div class="rounded-xl border border-outline-variant/10 p-5 bg-surface-container">
          <h3 class="font-bold text-lg">Choose a Plan</h3>
          <p class="text-sm text-on-surface-variant mt-1">Activate a subscription now.</p>
          <form method="POST" action="{{ route('subscriptions.choose_plan') }}" class="mt-4 space-y-3">
            @csrf
            <select name="plan" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
              @foreach($plans as $key => $p)
                <option value="{{ $key }}">{{ $p['label'] }} — {{ $p['price'] }}</option>
              @endforeach
            </select>
            <button class="w-full px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Activate Plan</button>
          </form>
        </div>
      </div>

      <p class="text-xs text-on-surface-variant mt-6">This step is required only once for new companies.</p>
    </div>
  </div>
@endsection
