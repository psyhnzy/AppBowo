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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('deposit_id')->nullable();
            $table->string('type', 20);  // 'setoran_masuk' | 'penarikan'
            $table->decimal('amount', 12, 2);
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Foreign Key Constraints
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('deposit_id')
                  ->references('id')->on('deposits')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
