<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Super admin can switch tenant context via query (?tenant_id=) or session
        if ($user && ($user->super_admin ?? false)) {
            $tenantId = (int)($request->query('tenant_id') ?? session('tenant_id', 1));
            session(['tenant_id' => $tenantId]);
            app()->instance('tenant_id', $tenantId);
            return $next($request);
        }

        if ($user && isset($user->tenant_id)) {
            app()->instance('tenant_id', $user->tenant_id);
        } else {
            app()->instance('tenant_id', 1);
        }

        return $next($request);
    }
}