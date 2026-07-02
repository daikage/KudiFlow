<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            if (!Schema::hasColumn('tenants', 'status')) {
                $table->string('status')->default('active')->after('subdomain');
            }
            if (!Schema::hasColumn('tenants', 'paused_at')) {
                $table->timestamp('paused_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('tenants', 'pause_reason')) {
                $table->text('pause_reason')->nullable()->after('paused_at');
            }
        });
    }

    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['status', 'paused_at', 'pause_reason']);
        });
    }
};
