<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();                 // machine name, e.g. basic, pro
            $table->decimal('amount', 12, 2)->default(0);     // 0 for free/trial
            $table->string('currency', 3)->default('NGN');    // ISO code
            $table->string('interval')->default('monthly');   // monthly|yearly|lifetime
            $table->unsignedInteger('interval_count')->default(1);
            $table->unsignedInteger('trial_days')->default(0);
            $table->json('modules')->nullable();              // e.g. {"inventory":true,"sales":true}
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
