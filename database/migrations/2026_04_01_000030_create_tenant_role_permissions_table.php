<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tenant_role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('role'); // admin|manager|staff
            $table->json('permissions'); // e.g. {"inventory":true,"sales":true,"finance":false,"people":false,"admin":false}
            $table->timestamps();

            $table->unique(['tenant_id', 'role']);
        });

        // If you want to allow platform-wide admins
        if (!Schema::hasColumn('users', 'super_admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('super_admin')->default(false)->after('role');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_role_permissions');

        if (Schema::hasColumn('users', 'super_admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('super_admin');
            });
        }
    }
};
