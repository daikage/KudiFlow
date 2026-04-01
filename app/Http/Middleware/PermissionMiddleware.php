<?php

namespace App\Http\Middleware;

use App\Models\TenantRolePermission;
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

        // Fetch tenant-scoped permissions for the user's role
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
