<?php

namespace App\Http\Middleware;

use App\Models\TenantRolePermission;
use App\Services\PlanManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $user = $request->user();

        // Super admin bypass
        if ($user && ($user->super_admin ?? false)) {
            return $next($request);
        }

        $tenantId = (int) app('tenant_id');

        // NEW: During trial, grant full access (menus and routes)
        if (PlanManager::isTrialingTenant($tenantId)) {
            return $next($request);
        }

        // Plan entitlement gate first
        if (!PlanManager::isServiceEntitled($tenantId, $module)) {
            abort(402, 'Your current subscription does not include access to this feature.');
        }

        // Role-based permissions next
        $permissions = TenantRolePermission::where('tenant_id', $tenantId)
            ->where('role', $user->role ?? 'staff')
            ->value('permissions');

        $allowed = is_array($permissions) && (($permissions[$module] ?? false) === true);

        if (!$allowed) {
            abort(403, 'You do not have permission to access this module.');
        }

        return $next($request);
    }
}
