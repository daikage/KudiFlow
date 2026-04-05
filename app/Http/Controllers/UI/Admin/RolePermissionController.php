<?php

namespace App\Http\Controllers\UI\Admin;

use App\Http\Controllers\Controller;
use App\Models\TenantRolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RolePermissionController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = app('tenant_id');

        $matrix = TenantRolePermission::where('tenant_id', $tenantId)
            ->get()
            ->keyBy('role');

        // Ensure all roles appear even if not created yet
        $roles = ['admin', 'manager', 'staff'];
        $modules = ['inventory', 'sales', 'finance', 'people', 'admin'];

        return view('admin.roles.index', compact('matrix', 'roles', 'modules'));
    }

    public function update(Request $request)
    {
        $tenantId = app('tenant_id');

        $roles = ['admin', 'manager', 'staff'];
        $modules = ['inventory', 'sales', 'finance', 'people', 'admin'];

        foreach ($roles as $role) {
            $permissions = [];
            foreach ($modules as $m) {
                $permissions[$m] = $request->boolean("perm.{$role}.{$m}");
            }

            TenantRolePermission::updateOrCreate(
                ['tenant_id' => $tenantId, 'role' => $role],
                ['permissions' => $permissions]
            );

            // Invalidate cached permissions so sidebar reflects latest changes
            Cache::forget("tenant:{$tenantId}:role:{$role}");
        }

        return redirect()->route('admin.roles.index')->with('success', 'Permissions updated.');
    }
}
