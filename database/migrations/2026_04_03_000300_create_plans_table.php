<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();                  // e.g. basic, pro, enterprise
            $table->string('name');
            $table->decimal('price', 12, 2)->default(0);       // in NGN for now
            $table->string('interval')->default('monthly');    // monthly|yearly
            $table->json('entitlements')->nullable();          // {"inventory":true,"sales":true,"finance":false,...}
            $table->string('status')->default('active');       // active|inactive
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

