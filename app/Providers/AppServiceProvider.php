<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\TenantRolePermission;
use App\Models\Product;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Sale;
use App\Services\ActivityNotifier;
use App\Services\PlanManager;
use App\Contracts\ForecastProvider;
use App\Services\Forecast\Providers\OpenAiForecaster;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the forecast provider based on config, fallback to a null binding to keep baseline
        $driver = config('ai.forecast.driver', 'baseline');

        if ($driver === 'openai' && config('ai.forecast.openai.api_key')) {
            $this->app->singleton(ForecastProvider::class, function () {
                return new OpenAiForecaster();
            });
        } else {
            // Bind to a no-op provider so app(ForecastProvider::class) exists but returns []
            $this->app->singleton(ForecastProvider::class, function () {
                return new class implements \App\Contracts\ForecastProvider {
                    public function forecast(array $context): array { return []; }
                };
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Share permissions and super_admin flag with both sidebars
        View::composer(['partials.sidebar', 'partials.tw.sidebar'], function ($view) {
            $user = auth()->user();

            $tenantId = app()->bound('tenant_id')
                ? app('tenant_id')
                : (request('tenant_id') ?? session('tenant_id', $user->tenant_id ?? 1));

            $super = $user && ($user->super_admin ?? false);

            $perm = $super
                ? ['inventory' => true, 'sales' => true, 'finance' => true, 'people' => true, 'admin' => true]
                : (TenantRolePermission::where('tenant_id', $tenantId)
                        ->where('role', $user->role ?? 'staff')
                        ->value('permissions') ?? []);

            // NEW: plan entitlements for current tenant
            $entitled = PlanManager::entitlementsForTenant((int) $tenantId);

            // NEW: If tenant is on trial (and not super admin), force all perms to true so menus appear
            if (!$super && PlanManager::isTrialingTenant((int) $tenantId)) {
                $perm = array_fill_keys(PlanManager::MODULES, true);
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