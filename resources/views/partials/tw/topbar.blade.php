<header class="bg-emerald-50/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-40 flex justify-between items-center w-full px-8 py-3">
  <div class="flex items-center gap-6">
    <div class="relative group">
      <span class="absolute inset-y-0 left-3 flex items-center text-on-surface-variant">
        <span class="material-symbols-outlined text-xl">search</span>
      </span>
      <input
        class="bg-white/50 border-none rounded-full pl-10 pr-4 py-2 text-sm w-80 focus:ring-2 focus:ring-primary outline-none transition-all"
        placeholder="@yield('search_placeholder', 'Search…')" type="text"/>
    </div>
  </div>
  <div class="flex items-center gap-4">
    <button class="p-2 text-emerald-900 dark:text-emerald-500 hover:text-emerald-700 transition-colors active:scale-95 duration-150">
      <span class="material-symbols-outlined">notifications</span>
    </button>
    <button class="p-2 text-emerald-900 dark:text-emerald-500 hover:text-emerald-700 transition-colors active:scale-95 duration-150">
      <span class="material-symbols-outlined">help_outline</span>
    </button>
    <div class="h-8 w-8 rounded-full overflow-hidden bg-surface-container-high border border-outline-variant">
      <img alt="User profile photo" class="w-full h-full object-cover"
           src="https://lh3.googleusercontent.com/aida-public/AB6AXuD-4aup12ahkVA7Fjum8jzsIadjcSvnNZWTSofbqA2xRHRvhWLwJW2jU_xqqF1zPTTsaqaNJ5zugOwrYJesApZuhtmG_-oY6n9u6jwGmfuW5kkOiDxLW2en7qm5NMi7pnkLWESeaQ9-SXnHdNKOHu_uXkoS3llgSkI-3OHtaWeR2pPpV1xfftQEUUuO4HGasJFA77Ka5qBB54pM0vsl9DlrHXuH1IkuKafq7omurINPAoMtMpqfOlNRqJMn-_4q3fbSgl7TVVhOEQ"/>
    </div>
  </div>
</header>
