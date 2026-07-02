<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'superadmin'    => \App\Http\Middleware\SuperAdminMiddleware::class,
            'sa'            => \App\Http\Middleware\SuperAdminMiddleware::class, // optional alias
            'tenant'        => \App\Http\Middleware\TenantMiddleware::class,
            'perm'          => \App\Http\Middleware\PermissionMiddleware::class,
            'role'          => \App\Http\Middleware\RoleMiddleware::class,
            'tenant.status' => \App\Http\Middleware\CheckTenantStatus::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
