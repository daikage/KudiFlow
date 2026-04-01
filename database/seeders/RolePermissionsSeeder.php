<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\TenantRolePermission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolePermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::firstOrCreate(['id' => 1], ['name' => 'Default Tenant']);

        // Defaults by role (per-tenant)
        $defaults = [
            'admin' => ['inventory' => true, 'sales' => true, 'finance' => true, 'people' => true, 'admin' => true],
            'manager' => ['inventory' => true, 'sales' => true, 'finance' => true, 'people' => true, 'admin' => false],
            'staff' => ['inventory' => false, 'sales' => true, 'finance' => false, 'people' => false, 'admin' => false],
        ];

        foreach ($defaults as $role => $perms) {
            TenantRolePermission::updateOrCreate(
                ['tenant_id' => $tenant->id, 'role' => $role],
                ['permissions' => $perms]
            );
        }

        // Ensure demo users exist and set super_admin for admin@example.com
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'tenant_id' => $tenant->id,
                'role' => 'admin',
                'super_admin' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password'),
                'tenant_id' => $tenant->id,
                'role' => 'manager',
                'super_admin' => false,
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Staff User',
                'password' => Hash::make('password'),
                'tenant_id' => $tenant->id,
                'role' => 'staff',
                'super_admin' => false,
            ]
        );
    }
}
