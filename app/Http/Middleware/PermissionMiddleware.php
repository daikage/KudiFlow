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

        // Super admin bypass: access to all modules/companies
        if ($user && ($user->super_admin ?? false)) {
            return $next($request);
        }

        $tenantId = app('tenant_id');

        // 1) Subscription / plan entitlement gate
        if (!PlanManager::isServiceEntitled($tenantId, $module)) {
            // 402 Payment Required is semantically correct; some apps prefer 403 + message
            abort(402, 'Your current subscription does not include access to this feature. Please upgrade your plan.');
        }

        // 2) Role-based permissions (existing model)
        $permissions = TenantRolePermission::where('tenant_id', $tenantId)
            ->where('role', $user->role ?? 'staff')
            ->value('permissions');

        $allowed = is_array($permissions) && !empty($permissions[$module]) && $permissions[$module] === true;

        if (!$allowed) {
            abort(403, 'You do not have permission to access this module.');
        }

        return $next($request);
    }
}
