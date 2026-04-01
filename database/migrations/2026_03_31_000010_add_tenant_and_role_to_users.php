<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Ensure a default tenant exists BEFORE adding FK on users. This prevents FK violation.
        if (Schema::hasTable('tenants')) {
            DB::table('tenants')->insertOrIgnore([
                'id' => 1,
                'name' => 'Default Tenant',
                'subdomain' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 1) Add columns (no FK yet)
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'tenant_id')) {
                $table->unsignedBigInteger('tenant_id')->default(1)->after('id');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('admin')->after('password');
            }
        });

        // 2) Backfill nulls (safety)
        DB::table('users')->whereNull('tenant_id')->update(['tenant_id' => 1]);

        // 3) Add FK after data is valid (without Doctrine)
        $fkExists = DB::selectOne("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'users'
              AND COLUMN_NAME = 'tenant_id'
              AND REFERENCED_TABLE_NAME IS NOT NULL
            LIMIT 1
        ");

        if (!$fkExists) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop FK safely without relying on constraint name
            try {
                $table->dropForeign(['tenant_id']);
            } catch (\Throwable $e) {
                // ignore
            }

            if (Schema::hasColumn('users', 'tenant_id')) {
                $table->dropColumn('tenant_id');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
