<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Ensure tenant #1 exists
        if (Schema::hasTable('tenants')) {
            DB::table('tenants')->insertOrIgnore([
                'id' => 1,
                'name' => 'Default Tenant',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create a default admin if none exists (dev convenience)
        if (Schema::hasTable('users')) {
            $exists = DB::table('users')->where('email', 'admin@example.com')->exists();
            if (!$exists) {
                DB::table('users')->insert([
                    'name' => 'Admin',
                    'email' => 'admin@example.com',
                    'password' => Hash::make('password'),
                    'tenant_id' => 1,
                    'role' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users')) {
            DB::table('users')->where('email', 'admin@example.com')->delete();
        }
    }
};
