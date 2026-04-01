<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Map model => policy as needed
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Example gates using the simple role column
        Gate::define('manage-products', fn ($user) => in_array($user->role, ['admin','manager'], true));
        Gate::define('manage-expenses', fn ($user) => in_array($user->role, ['admin','manager'], true));
        Gate::define('record-sales', fn ($user) => in_array($user->role, ['admin','manager','staff'], true));
        Gate::define('admin-only', fn ($user) => $user->role === 'admin');
    }
}
