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
    <button data-toggle-notify class="relative p-2 rounded-full hover:bg-surface-variant/30">
        <span class="material-symbols-outlined">notifications</span>
        <span id="notify-badge" class="absolute -top-1 -right-1 bg-error text-on-error text-xs rounded-full w-5 h-5 flex items-center justify-center hidden">0</span>
    </button>
    <a href="{{ route('support.index') }}" class="p-2 text-emerald-900 dark:text-emerald-500 hover:text-emerald-700 transition-colors active:scale-95 duration-150">
      <span class="material-symbols-outlined">help_outline</span>
    </a>

    @auth
      <!-- Sign out -->
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
      </form>
      <button class="p-2 text-emerald-900 dark:text-emerald-500 hover:text-emerald-700 transition-colors active:scale-95 duration-150"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span class="material-symbols-outlined">logout</span>
      </button>

      <!-- Avatar -> link to Profile -->
      <a href="{{ route('ui.profile.show') }}" class="h-8 w-8 rounded-full overflow-hidden bg-surface-container-high border border-outline-variant block">
        <img alt="User profile photo" class="w-full h-full object-cover"
             src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=10b981&color=fff"/>
      </a>
    @endauth

    @guest
      <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-lg border border-outline-variant/30">Sign in</a>
      <a href="{{ route('register') }}" class="px-3 py-1.5 rounded-lg bg-primary text-on-primary">Register</a>
    @endguest
  </div>
</header>