@extends('layouts.tailwind')

@section('no-sidebar', true)
@section('title', 'Create account')

@section('content')
  <div class="min-h-[80vh] flex items-center justify-center">
    <div class="w-full max-w-md bg-surface-container-lowest rounded-2xl p-8 shadow border border-outline-variant/10">
      <h1 class="text-2xl font-extrabold mb-6">Create your account</h1>

      @if ($errors->any())
        <div class="mb-4 p-3 rounded bg-error/10 text-error text-sm font-semibold">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div>
          <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-1">Full name</label>
          <input name="name" value="{{ old('name') }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" required>
        </div>
        <div>
          <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-1">Email</label>
          <input name="email" type="email" value="{{ old('email') }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" required>
        </div>
        <div>
          <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-1">Password</label>
          <input name="password" type="password" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" required>
        </div>
        <div>
          <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-1">Confirm Password</label>
          <input name="password_confirmation" type="password" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" required>
        </div>
        <div>
          <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-1">Store name (optional)</label>
          <input name="store_name" value="{{ old('store_name') }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2">
        </div>
        <button class="w-full px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Create account</button>
      </form>

      <p class="mt-4 text-sm text-on-surface-variant">
        Already have an account? <a class="text-primary font-bold" href="{{ route('login') }}">Sign in</a>
      </p>
    </div>
  </div>
@endsection
