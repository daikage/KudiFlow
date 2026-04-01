<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUsersSeeder extends Seeder
{
    /**
     * Seed default users for each role under tenant #1.
     *
     * Credentials (dev only):
     * - Admin:   admin@example.com / password
     * - Manager: manager@example.com / password
     * - Staff:   staff@example.com / password
     */
    public function run(): void
    {
        // Ensure a default tenant exists
        $tenant = Tenant::firstOrCreate(['id' => 1], ['name' => 'Default Tenant']);

        $users = [
            [
                'name'  => 'Admin User',
                'email' => 'admin@example.com',
                'role'  => 'admin',
            ],
            [
                'name'  => 'Manager User',
                'email' => 'manager@example.com',
                'role'  => 'manager',
            ],
            [
                'name'  => 'Staff User',
                'email' => 'staff@example.com',
                'role'  => 'staff',
            ],
        ];

        foreach ($users as $u) {
            // Upsert by email; set password to a known value for dev
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name'      => $u['name'],
                    'password'  => Hash::make('password'),
                    'tenant_id' => $tenant->id,
                    'role'      => $u['role'],
                ]
            );
        }
    }
}
