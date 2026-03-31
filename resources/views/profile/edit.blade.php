@extends('layouts.tailwind')

@section('title', 'Edit Profile')
@section('search_placeholder', 'Search settings...')

@section('content')
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5 text-center">
      <img class="w-24 h-24 rounded-full object-cover mx-auto mb-3 ring-2 ring-white shadow-sm" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD-4aup12ahkVA7Fjum8jzsIadjcSvnNZWTSofbqA2xRHRvhWLwJW2jU_xqqF1zPTTsaqaNJ5zugOwrYJesApZuhtmG_-oY6n9u6jwGmfuW5kkOiDxLW2en7qm5NMi7pnkLWESeaQ9-SXnHdNKOHu_uXkoS3llgSkI-3OHtaWeR2pPpV1xfftQEUUuO4HGasJFA77Ka5qBB54pM0vsl9DlrHXuH1IkuKafq7omurINPAoMtMpqfOlNRqJMn-_4q3fbSgl7TVVhOEQ" alt="Profile">
      <p class="text-sm text-on-surface-variant">Update your avatar via your connected account.</p>
    </div>

    <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
      <h3 class="font-bold mb-4">Edit Details</h3>
      <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Full Name</label>
          <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="Your Name">
        </div>
        <div class="md:col-span-2">
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Email</label>
          <input type="email" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="you@domain.com">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Phone</label>
          <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" placeholder="Optional">
        </div>
        <div>
          <label class="block text-[12px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Role</label>
          <input class="w-full bg-surface-container-low border border-outline-variant/30 rounded-lg px-3 py-2" value="Admin" disabled>
        </div>
        <div class="md:col-span-2">
          <button type="button" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Save Profile</button>
          <a href="/ui/profile" class="ml-2 px-4 py-2 rounded-lg bg-white border border-outline-variant/30 text-on-surface-variant hover:bg-surface-variant/30">Cancel</a>
        </div>
      </form>
    </div>
  </div>
@endsection
