@extends('layouts.tailwind')

@section('no-sidebar', true)
@section('title', 'Account Paused')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="w-full max-w-md bg-surface-container-lowest rounded-2xl p-8 shadow border border-outline-variant/10">
        <div class="text-center mb-6">
            <span class="material-symbols-outlined text-5xl text-error mb-4">pause_circle</span>
            <h1 class="text-2xl font-extrabold mb-2">Account Paused</h1>
            <p class="text-on-surface-variant">Your account has been temporarily suspended.</p>
        </div>
        
        <div class="bg-error-container/20 p-4 rounded-lg mb-6">
            <p class="text-sm text-on-surface-variant"><strong>Reason:</strong> {{ $reason }}</p>
            <p class="text-sm text-on-surface-variant"><strong>Paused on:</strong> {{ $paused_at->format('M j, Y g:i A') }}</p>
        </div>
        
        <p class="text-sm text-on-surface-variant text-center">
            Please contact support if you believe this is an error.
        </p>
    </div>
</div>
@endsection
