<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop any existing unique index on sku
            try {
                $table->dropUnique(['sku']);
            } catch (\Throwable $e) {
                // Fallback if the index name is different
                try { $table->dropUnique('products_sku_unique'); } catch (\Throwable $e2) {}
            }

            // Ensure indexes exist for performance
            if (! app()->runningUnitTests()) {
                $table->index('tenant_id');
            }

            // Add composite unique index tenant_id + sku
            $table->unique(['tenant_id', 'sku'], 'products_tenant_sku_unique');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Revert to global unique on sku (not recommended, but for rollback completeness)
            try { $table->dropUnique('products_tenant_sku_unique'); } catch (\Throwable $e) {}
            $table->unique('sku');
        });
    }
};
