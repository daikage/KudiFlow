<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Add barcode column if missing (and index it)
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'barcode')) {
                $table->string('barcode')->nullable()->index();
            }
        });

        // Only add tenant_id index if it doesn't already exist
        if (! $this->indexExists('products', 'products_tenant_id_index')) {
            Schema::table('products', function (Blueprint $table) {
                $table->index('tenant_id', 'products_tenant_id_index');
            });
        }
    }

    public function down(): void
    {
        // Drop barcode column if present
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'barcode')) {
                $table->dropColumn('barcode');
            }
        });

        // Drop tenant_id index only if it exists (avoid failures on rollback)
        if ($this->indexExists('products', 'products_tenant_id_index')) {
            try {
                Schema::table('products', function (Blueprint $table) {
                    $table->dropIndex('products_tenant_id_index');
                });
            } catch (\Throwable $e) {
                // ignore
            }
        }
    }

    /**
     * Check if a given index exists on a table (MySQL-safe; falls back gracefully).
     */
    private function indexExists(string $table, string $index): bool
    {
        $conn = Schema::getConnection();
        $driver = $conn->getDriverName();

        // MySQL / MariaDB
        if ($driver === 'mysql') {
            $prefixed = $conn->getTablePrefix().$table;
            $rows = DB::select('SHOW INDEX FROM '.$prefixed.' WHERE Key_name = ?', [$index]);
            return !empty($rows);
        }

        // SQLite / others: attempt a generic check where possible, otherwise assume not present
        try {
            // SQLite pragma returns indexes; not all environments support it consistently
            if ($driver === 'sqlite') {
                $rows = DB::select('PRAGMA index_list("'.$table.'")');
                foreach ($rows as $row) {
                    if (isset($row->name) && $row->name === $index) {
                        return true;
                    }
                }
            }
        } catch (\Throwable $e) {
            // ignore and fall through
        }

        return false;
    }
};
