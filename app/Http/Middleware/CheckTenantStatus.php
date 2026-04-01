<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTenantStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenantId = app('tenant_id');
        $tenant = Tenant::find($tenantId);

        if ($tenant && $tenant->isPaused()) {
            return response()->view('errors.tenant-paused', [
                'reason' => $tenant->pause_reason,
                'paused_at' => $tenant->paused_at,
            ], 403);
        }

        return $next($request);
    }
}
