<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('phone', 20);
            $table->text('address');
            $table->string('password', 255);
            $table->string('role', 10)->default('nasabah');   // 'admin' | 'nasabah'
            $table->decimal('balance', 12, 2)->default(0.00);
            $table->integer('points')->default(0);
            $table->string('status', 10)->default('active');  // 'active' | 'inactive'
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
