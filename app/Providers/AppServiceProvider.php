<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\TenantRolePermission;

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

            $view->with(compact('perm', 'super'));
        });
    }
}
