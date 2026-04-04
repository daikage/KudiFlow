<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('plan_code');
            $table->string('provider');                 // paystack|flutterwave
            $table->string('reference')->unique();
            $table->string('provider_ref')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 8)->default('NGN');
            $table->string('status')->default('pending'); // pending|success|failed|canceled
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['tenant_id','status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
