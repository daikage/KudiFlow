@php
    // Determine current tenant trial status to control admin menus during trial
    $tenantId = app()->bound('tenant_id') ? app('tenant_id') : (auth()->user()->tenant_id ?? 1);
    $sub = \App\Models\Subscription::where('tenant_id', $tenantId)->latest('id')->first();
    $trialActive = $sub && $sub->status === 'trial' && $sub->trial_ends_at && now()->lt($sub->trial_ends_at);
    // During trial, hide tenant "Admin" section, but show all other company menus.
    $showAdminSection = !$trialActive;
@endphp

@php
    $is = fn($pattern) => request()->is($pattern);
    $user = auth()->user();

    // Ensure fallbacks in case view composer didn't bind values
    $super = $super ?? ($user && ($user->super_admin ?? false));
    $tenantId = app()->bound('tenant_id')
        ? app('tenant_id')
        : (request('tenant_id') ?? session('tenant_id', $user->tenant_id ?? 1));

    $perm = $perm ?? (
        $super
            ? ['inventory'=>true,'sales'=>true,'finance'=>true,'people'=>true,'admin'=>true]
            : (\App\Models\TenantRolePermission::where('tenant_id', $tenantId)
                ->where('role', $user->role ?? 'staff')
                ->value('permissions') ?? [])
    );

    // NEW: Show company-bound menus only when:
    // - user is NOT super admin, or
    // - user is super admin AND currently inside the company app area (/ui/*).
    $showCompanyMenus = (!$super) || request()->is('ui/*');

    // NEW: flag for company area
    $inCompanyArea = request()->is('ui/*');
@endphp

<aside class="h-screen w-64 fixed left-0 top-0 bg-emerald-50 dark:bg-slate-950 flex flex-col p-4 gap-2 z-50 overflow-y-auto overscroll-y-contain">
  <div class="mb-6 px-2">
    <h1 class="text-lg font-black text-emerald-900 dark:text-emerald-500 tracking-tight">Kudiflow</h1>
    <p class="text-xs text-on-surface-variant opacity-70">Market Assistant</p>
  </div>

  <nav class="flex-1 flex flex-col gap-1">
    @if($showCompanyMenus)
      <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70">Overview</p>
      <a href="{{ route('ui.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
        {{ $is('ui/dashboard') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined" style="{{ $is('ui/dashboard') ? "font-variation-settings: 'FILL' 1" : '' }}">dashboard</span>
        <span class="font-medium text-sm">Dashboard</span>
      </a>
    @endif

    @if($showCompanyMenus && ($perm['inventory'] ?? false))
      <!-- Inventory -->
      <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Inventory</p>
      <a href="{{ route('ui.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
        {{ $is('ui/products*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined">inventory_2</span>
        <span class="font-medium text-sm">Products</span>
      </a>
      <a href="{{ route('ui.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
        {{ $is('ui/categories*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined">category</span>
        <span class="font-medium text-sm">Categories</span>
      </a>
    @endif

    @if($showCompanyMenus && ($perm['sales'] ?? false))
      <!-- Sales -->
      <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Sales</p>
      <a href="{{ route('ui.sales.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
        {{ $is('ui/sales*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined">receipt_long</span>
        <span class="font-medium text-sm">Sales Ledger</span>
      </a>
      {{-- NEW: POS entry --}}
      <a href="{{ route('ui.pos.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
        {{ $is('ui/pos*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined">point_of_sale</span>
        <span class="font-medium text-sm">Point of Sale</span>
      </a>
    @endif

    @if($showCompanyMenus && ($perm['finance'] ?? false))
      <!-- Finance -->
      <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Finance</p>
      <a href="{{ route('ui.expenses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
        {{ $is('ui/expenses*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined">account_balance_wallet</span>
        <span class="font-medium text-sm">Expenses</span>
      </a>
      {{-- NEW: Forecast link (Bootstrap sidebar) --}}
      <a href="{{ route('ui.forecast.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
        {{ $is('ui/forecast') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined">trending_up</span>
        <span class="font-medium text-sm">Forecast</span>
      </a>
    @endif

    @if($showCompanyMenus && ($perm['people'] ?? false))
      <!-- People -->
      <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">People</p>
      <a href="{{ route('ui.staff.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
        {{ $is('ui/staff*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined">group</span>
        <span class="font-medium text-sm">Staff</span>
      </a>
    @endif

    @if($showCompanyMenus && ($perm['admin'] ?? false) && $showAdminSection)
      <!-- Company Admin -->
      <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Admin</p>
      <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
        {{ $is('ui/admin/roles') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined">lock_open_right</span>
        <span class="font-medium text-sm">Permissions</span>
      </a>
    @endif

    @if($super)
      @if($inCompanyArea)
        <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Platform</p>
        <a href="{{ route('sa.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
          {{ $is('sa') || $is('sa/*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
          <span class="material-symbols-outlined">public</span>
          <span class="font-medium text-sm">Back to Platform</span>
        </a>
      @else
        <!-- Super Admin Platform Area -->
        <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Platform</p>
        <a href="{{ route('sa.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
          {{ $is('sa') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
          <span class="material-symbols-outlined">public</span>
          <span class="font-medium text-sm">Platform Dashboard</span>
        </a>
        <a href="{{ route('sa.tenants.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
          {{ $is('sa/tenants*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
          <span class="material-symbols-outlined">domain</span>
          <span class="font-medium text-sm">Companies</span>
        </a>
        <a href="{{ route('sa.subscriptions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
          {{ $is('sa/subscriptions*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
          <span class="material-symbols-outlined">autorenew</span>
          <span class="font-medium text-sm">Subscriptions</span>
        </a>
      @endif
    @endif
  </nav>

  <div class="mt-auto flex flex-col gap-1 pt-4 border-t border-outline-variant/10">
    <a href="{{ route('ui.settings.general') }}" class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800 transition-all rounded-lg">
      <span class="material-symbols-outlined">settings</span>
      <span class="text-sm">Settings</span>
    </a>
    <a href="{{ route('ui.settings.billing') }}" class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800 transition-all rounded-lg">
      <span class="material-symbols-outlined">payments</span>
      <span class="text-sm">Billing</span>
    </a>
    <a href="{{ route('ui.settings.notifications') }}" class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800 transition-all rounded-lg">
      <span class="material-symbols-outlined">notifications</span>
      <span class="text-sm">Notifications</span>
    </a>
    <a href="{{ route('support.index') }}" class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800 transition-all rounded-lg">
      <span class="material-symbols-outlined">contact_support</span>
      <span class="text-sm">Support</span>
    </a>
  </div>
</aside>