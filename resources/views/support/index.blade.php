@extends('layouts.tailwind')

@section('title', 'Support')
@section('search_placeholder', 'Search help articles...')

@section('content')
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <h2 class="text-xl font-bold mb-4">Contact Support</h2>
        <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="md:col-span-2">
            <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Subject</label>
            <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="Brief description">
          </div>
          <div>
            <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Your Email</label>
            <input type="email" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="you@domain.com">
          </div>
          <div>
            <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Priority</label>
            <select class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2"><option>Normal</option><option>High</option></select>
          </div>
          <div class="md:col-span-2">
            <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Message</label>
            <textarea rows="6" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="Describe your issue..."></textarea>
          </div>
          <div class="md:col-span-2">
            <button type="button" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Send</button>
          </div>
        </form>
      </div>
    </div>

    <div class="space-y-6">
      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <h3 class="font-bold mb-4">FAQ</h3>
        <div class="space-y-3">
          <details class="rounded-lg bg-surface-container p-4">
            <summary class="font-semibold cursor-pointer">How do I add products?</summary>
            <p class="text-sm text-on-surface-variant mt-2">Go to Products → New Product and fill the form.</p>
          </details>
          <details class="rounded-lg bg-surface-container p-4">
            <summary class="font-semibold cursor-pointer">How to record a sale?</summary>
            <p class="text-sm text-on-surface-variant mt-2">Open Sales POS and add items to the cart, then complete payment.</p>
          </details>
        </div>
      </div>

      <div class="bg-secondary-container/30 border border-secondary/10 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-2">
          <span class="material-symbols-outlined">lightbulb</span>
          <h4 class="font-bold text-secondary">Tip</h4>
        </div>
        <p class="text-sm text-secondary/80">Use categories to keep your inventory organized and speed up sales.</p>
      </div>
    </div>
  </div>
@endsection
