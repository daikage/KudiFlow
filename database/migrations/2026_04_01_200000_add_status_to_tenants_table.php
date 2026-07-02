<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('status')->default('active')->after('subdomain');
            $table->timestamp('paused_at')->nullable()->after('status');
            $table->text('pause_reason')->nullable()->after('paused_at');
        });
    }

    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['status', 'paused_at', 'pause_reason']);
        });
    }
};
