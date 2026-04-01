<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure a base tenant exists to satisfy FK
        $tenant = Tenant::firstOrCreate(['id' => 1], ['name' => 'Platform']);

        User::updateOrCreate(
            ['email' => 'root@example.com'],
            [
                'name' => 'Platform Root',
                'password' => Hash::make('password'),
                'tenant_id' => $tenant->id,
                'role' => 'admin',    // role field unused for super_admin permissions
                'super_admin' => true,
            ]
        );
    }
}
