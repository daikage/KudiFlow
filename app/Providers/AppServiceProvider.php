<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use App\Models\TenantRolePermission;
use App\Models\Product;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Sale;
use App\Services\ActivityNotifier;
use App\Services\PlanManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        View::composer(['partials.sidebar', 'partials.tw.sidebar'], function ($view) {
            $user = auth()->user();

            $tenantId = app()->bound('tenant_id')
                ? app('tenant_id')
                : (request('tenant_id') ?? session('tenant_id', $user->tenant_id ?? 1));

            $super = $user && ($user->super_admin ?? false);

            if ($super) {
                // Super admin: show everything
                $perm = array_fill_keys(PlanManager::MODULES, true);
                $entitled = array_fill_keys(PlanManager::MODULES, true);
            } else {
                // Role-based permissions (cached)
                $role = $user->role ?? 'staff';
                $rolePerms = Cache::remember("tenant:{$tenantId}:role:{$role}", 60, function () use ($tenantId, $role) {
                    return TenantRolePermission::where('tenant_id', $tenantId)
                        ->where('role', $role)
                        ->value('permissions') ?? [];
                });

                // Plan entitlements (modules included in current plan)
                $entitled = PlanManager::entitlementsForTenant((int) $tenantId);

                // Combine: only show modules both entitled by plan AND allowed by role
                $perm = [];
                foreach (PlanManager::MODULES as $m) {
                    $perm[$m] = (bool) (($rolePerms[$m] ?? false) && ($entitled[$m] ?? false));
                }
            }

            $view->with(compact('perm', 'super', 'entitled'));
        });

        // Activity notifications on new data (tenant-scoped + platform)
        Product::created(function (Product $p) {
            $title = 'New Product';
            $msg   = "“{$p->name}” was created.";
            ActivityNotifier::notifyTenantAdmins($p->tenant_id, $title, $msg, [
                'tenant_id' => $p->tenant_id,
                'type' => 'product',
                'id'   => $p->id,
                'route'=> route('ui.products.show', $p),
            ]);
            ActivityNotifier::notifySuperAdmins($title, "[T{$p->tenant_id}] {$p->name} created", [
                'tenant_id' => $p->tenant_id,
                'type' => 'product',
                'id'   => $p->id,
            ]);
        });

        Category::created(function (Category $c) {
            $title = 'New Category';
            $msg   = "“{$c->name}” category created.";
            ActivityNotifier::notifyTenantAdmins($c->tenant_id, $title, $msg, [
                'tenant_id' => $c->tenant_id,
                'type' => 'category',
                'id'   => $c->id,
                'route'=> route('ui.categories.show', $c),
            ]);
            ActivityNotifier::notifySuperAdmins($title, "[T{$c->tenant_id}] {$c->name} created", [
                'tenant_id' => $c->tenant_id,
                'type' => 'category',
                'id'   => $c->id,
            ]);
        });

        Expense::created(function (Expense $e) {
            $title = 'New Expense';
            $amt   = number_format($e->amount, 2);
            $msg   = "Expense {$e->title} recorded (₦{$amt}).";
            ActivityNotifier::notifyTenantAdmins($e->tenant_id, $title, $msg, [
                'tenant_id' => $e->tenant_id,
                'type' => 'expense',
                'id'   => $e->id,
                'route'=> route('ui.expenses.show', $e),
            ]);
            ActivityNotifier::notifySuperAdmins($title, "[T{$e->tenant_id}] {$e->title} (₦{$amt})", [
                'tenant_id' => $e->tenant_id,
                'type' => 'expense',
                'id'   => $e->id,
            ]);
        });

        Sale::created(function (Sale $s) {
            $title = 'New Sale';
            $amt   = number_format($s->total, 2);
            $msg   = "Sale recorded (₦{$amt}).";
            ActivityNotifier::notifyTenantAdmins($s->tenant_id, $title, $msg, [
                'tenant_id' => $s->tenant_id,
                'type' => 'sale',
                'id'   => $s->id,
                'route'=> route('ui.sales.show', $s),
            ]);
            ActivityNotifier::notifySuperAdmins($title, "[T{$s->tenant_id}] Sale (₦{$amt})", [
                'tenant_id' => $s->tenant_id,
                'type' => 'sale',
                'id'   => $s->id,
            ]);
        });
    }
}