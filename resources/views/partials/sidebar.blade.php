@php
    $is = fn($pattern) => request()->is($pattern);
@endphp

<aside class="h-screen w-64 fixed left-0 top-0 bg-emerald-50 dark:bg-slate-950 flex flex-col p-4 gap-2 z-50">
  <div class="mb-6 px-2">
    <h1 class="text-lg font-black text-emerald-900 dark:text-emerald-500 tracking-tight">Sovereign Ledger</h1>
    <p class="text-xs text-on-surface-variant opacity-70">Digital Estate Admin</p>
  </div>

  <nav class="flex-1 flex flex-col gap-1">
    <!-- Overview -->
    <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70">Overview</p>
    <a href="/ui/dashboard"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
       {{ $is('ui/dashboard') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
      <span class="material-symbols-outlined" style="{{ $is('ui/dashboard') ? "font-variation-settings: 'FILL' 1" : '' }}">dashboard</span>
      <span class="font-medium text-sm">Dashboard</span>
    </a>

    <!-- Inventory -->
    <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Inventory</p>
    <a href="/ui/products"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
       {{ $is('ui/products*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
      <span class="material-symbols-outlined">inventory_2</span>
      <span class="font-medium text-sm">Products</span>
    </a>
    <a href="/ui/categories"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
       {{ $is('ui/categories*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
      <span class="material-symbols-outlined">category</span>
      <span class="font-medium text-sm">Categories</span>
    </a>

    <!-- Sales -->
    <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Sales</p>
    <a href="/ui/products"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
       {{ $is('ui/products') && ! $is('ui/products/*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
      <span class="material-symbols-outlined">point_of_sale</span>
      <span class="font-medium text-sm">Sales POS</span>
    </a>
    <a href="/ui/sales"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
       {{ $is('ui/sales*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
      <span class="material-symbols-outlined">receipt_long</span>
      <span class="font-medium text-sm">Sales Ledger</span>
    </a>

    <!-- Finance -->
    <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Finance</p>
    <a href="/ui/expenses"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
       {{ $is('ui/expenses*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
      <span class="material-symbols-outlined">account_balance_wallet</span>
      <span class="font-medium text-sm">Expenses</span>
    </a>

    <!-- People -->
    <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">People</p>
    <a href="/ui/staff"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
       {{ $is('ui/staff*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
      <span class="material-symbols-outlined">group</span>
      <span class="font-medium text-sm">Staff</span>
    </a>

    <!-- Admin -->
    <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Admin</p>
    <a href="/ui/admin"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
       {{ $is('ui/admin') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
      <span class="material-symbols-outlined">admin_panel_settings</span>
      <span class="font-medium text-sm">Admin Overview</span>
    </a>
    <a href="/ui/admin/subscriptions"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
       {{ $is('ui/admin/subscriptions*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
      <span class="material-symbols-outlined">autorenew</span>
      <span class="font-medium text-sm">Subscriptions</span>
    </a>
  </nav>

  <div class="mt-auto flex flex-col gap-1 pt-4 border-t border-outline-variant/10">
    <a href="/ui/settings/general"
       class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800 transition-all rounded-lg">
      <span class="material-symbols-outlined">settings</span>
      <span class="text-sm">Settings</span>
    </a>
    <a href="/ui/support"
       class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800 transition-all rounded-lg">
      <span class="material-symbols-outlined">contact_support</span>
      <span class="text-sm">Support</span>
    </a>
  </div>
</aside>