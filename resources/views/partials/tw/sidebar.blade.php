@php
    $is = fn($pattern) => request()->is($pattern);
    $user = auth()->user();

    // Determine if user is super admin
    $super = $super ?? ($user && ($user->super_admin ?? false));

    // Resolve tenant context safely
    $tenantId = app()->bound('tenant_id')
        ? app('tenant_id')
        : (request('tenant_id') ?? session('tenant_id', $user->tenant_id ?? 1));

    // Resolve permissions (tenant-scoped unless super admin)
    $perm = $perm ?? (
        $super
            ? ['inventory'=>true,'sales'=>true,'finance'=>true,'people'=>true,'admin'=>true]
            : (\App\Models\TenantRolePermission::where('tenant_id', $tenantId)
                ->where('role', $user->role ?? 'staff')
                ->value('permissions') ?? [])
    );

    // Show company-bound menus only when:
    // - user is NOT super admin, or
    // - user is super admin AND currently inside the company app area (/ui/*).
    $showCompanyMenus = (!$super) || request()->is('ui/*');

    // NEW: flag to know when we're inside company area
    $inCompanyArea = request()->is('ui/*');
@endphp

<aside class="h-screen w-64 fixed left-0 top-0 bg-emerald-50 dark:bg-slate-950 flex flex-col p-4 gap-2 z-50">
  <div class="mb-6 px-2">
    <h1 class="text-lg font-black text-emerald-900 dark:text-emerald-500 tracking-tight">Sovereign Ledger</h1>
    <p class="text-xs text-on-surface-variant opacity-70">Digital Estate Admin</p>
  </div>

  <nav class="flex-1 flex flex-col gap-1">
    @if($showCompanyMenus)
      <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70">Overview</p>
      <a href="{{ route('ui.dashboard') }}"
         class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
         {{ $is('ui/dashboard') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined" style="{{ $is('ui/dashboard') ? "font-variation-settings: 'FILL' 1" : '' }}">dashboard</span>
        <span class="font-medium text-sm">Dashboard</span>
      </a>
    @endif

    @if($showCompanyMenus && ($perm['inventory'] ?? false))
      <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Inventory</p>
      <a href="{{ route('ui.products.index') }}"
         class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
         {{ $is('ui/products*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined">inventory_2</span>
        <span class="font-medium text-sm">Products</span>
      </a>
      <a href="{{ route('ui.categories.index') }}"
         class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
         {{ $is('ui/categories*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined">category</span>
        <span class="font-medium text-sm">Categories</span>
      </a>
    @endif

    @if($showCompanyMenus && ($perm['sales'] ?? false))
      <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Sales</p>
      <a href="{{ route('ui.sales.index') }}"
         class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
         {{ $is('ui/sales*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined">receipt_long</span>
        <span class="font-medium text-sm">Sales Ledger</span>
      </a>
    @endif

    @if($showCompanyMenus && ($perm['finance'] ?? false))
      <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Finance</p>
      <a href="{{ route('ui.expenses.index') }}"
         class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
         {{ $is('ui/expenses*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined">account_balance_wallet</span>
        <span class="font-medium text-sm">Expenses</span>
      </a>
    @endif

    @if($showCompanyMenus && ($perm['people'] ?? false))
      <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">People</p>
      <a href="{{ route('ui.staff.index') }}"
         class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
         {{ $is('ui/staff*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined">group</span>
        <span class="font-medium text-sm">Staff</span>
      </a>
    @endif

    @if($showCompanyMenus && ($perm['admin'] ?? false))
      <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Admin</p>
      <a href="{{ route('admin.roles.index') }}"
         class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
         {{ $is('ui/admin/roles') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
        <span class="material-symbols-outlined">lock_open_right</span>
        <span class="font-medium text-sm">Permissions</span>
      </a>
    @endif

    @if($super)
      @if($inCompanyArea)
        <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Platform</p>
        <a href="{{ route('sa.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
           {{ $is('sa') || $is('sa/*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
          <span class="material-symbols-outlined">public</span>
          <span class="font-medium text-sm">Back to Platform</span>
        </a>
      @else
        <p class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mt-2">Platform</p>
        <a href="{{ route('sa.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
           {{ $is('sa') || $is('sa/*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
          <span class="material-symbols-outlined">public</span>
          <span class="font-medium text-sm">Platform Dashboard</span>
        </a>
        <a href="{{ route('sa.tenants.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
           {{ $is('sa/tenants*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
          <span class="material-symbols-outlined">domain</span>
          <span class="font-medium text-sm">Companies</span>
        </a>
        <a href="{{ route('sa.subscriptions.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all group
           {{ $is('sa/subscriptions*') ? 'bg-white dark:bg-emerald-900/20 text-emerald-900 dark:text-emerald-400 shadow-sm font-semibold translate-x-1' : 'text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800' }}">
          <span class="material-symbols-outlined">autorenew</span>
          <span class="font-medium text-sm">Subscriptions</span>
        </a>
      @endif
    @endif
  </nav>

  <div class="mt-auto flex flex-col gap-1 pt-4 border-t border-outline-variant/10">
    <a href="{{ route('ui.settings.general') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all group
       text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800">
      <span class="material-symbols-outlined">settings</span>
      <span class="text-sm">Settings</span>
    </a>
    <a href="{{ route('ui.settings.billing') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all group
       text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800">
      <span class="material-symbols-outlined">receipt_long</span>
      <span class="text-sm">Billing</span>
    </a>
    <a href="{{ route('ui.settings.notifications') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all group
       text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800">
      <span class="material-symbols-outlined">notifications</span>
      <span class="text-sm">Notifications</span>
    </a>
    <a href="{{ route('support.index') }}"
       class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 hover:bg-emerald-100/50 dark:hover:bg-slate-800 transition-all rounded-lg">
      <span class="material-symbols-outlined">contact_support</span>
      <span class="text-sm">Support</span>
    </a>
  </div>
</aside>sition-all rounded-lg">
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