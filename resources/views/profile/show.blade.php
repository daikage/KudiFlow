@extends('layouts.tailwind')

@section('title', 'My Profile')
@section('search_placeholder', 'Search settings...')

@section('content')
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5 text-center">
      <img class="w-24 h-24 rounded-full object-cover mx-auto mb-3 ring-2 ring-white shadow-sm" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD-4aup12ahkVA7Fjum8jzsIadjcSvnNZWTSofbqA2xRHRvhWLwJW2jU_xqqF1zPTTsaqaNJ5zugOwrYJesApZuhtmG_-oY6n9u6jwGmfuW5kkOiDxLW2en7qm5NMi7pnkLWESeaQ9-SXnHdNKOHu_uXkoS3llgSkI-3OHtaWeR2pPpV1xfftQEUUuO4HGasJFA77Ka5qBB54pM0vsl9DlrHXuH1IkuKafq7omurINPAoMtMpqfOlNRqJMn-_4q3fbSgl7TVVhOEQ" alt="Profile">
      <h2 class="font-bold text-lg">Your Name</h2>
      <p class="text-sm text-on-surface-variant">Admin</p>
      <a href="/ui/profile/edit" class="mt-3 inline-flex px-4 py-2 rounded-lg border border-outline-variant/30 hover:bg-surface-variant/30">Edit Profile</a>
    </div>

    <div class="lg:col-span-2 space-y-6">
      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <h3 class="font-bold mb-4">Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Full Name</p>
            <p class="font-semibold">Your Name</p>
          </div>
          <div>
            <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Email</p>
            <p class="font-semibold">you@domain.com</p>
          </div>
          <div>
            <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Phone</p>
            <p class="font-semibold">—</p>
          </div>
          <div>
            <p class="text-[12px] text-on-surface-variant uppercase font-bold tracking-widest">Role</p>
            <p class="font-semibold">Admin</p>
          </div>
        </div>
      </div>

      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/5">
        <h3 class="font-bold mb-4">Security</h3>
        <p class="text-sm text-on-surface-variant mb-3">Update your password regularly.</p>
        <a href="/ui/settings/general" class="px-4 py-2 rounded-lg bg-primary text-on-primary shadow-sm">Go to Settings</a>
      </div>
    </div>
  </div>
@endsection
