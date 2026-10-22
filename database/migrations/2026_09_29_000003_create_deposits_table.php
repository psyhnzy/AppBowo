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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('waste_type_id');
            $table->decimal('weight', 8, 2);
            $table->decimal('price_per_kg', 10, 2);
            $table->decimal('total_value', 12, 2);
            $table->integer('points');
            $table->date('deposit_date');
            $table->text('notes')->nullable();
            $table->string('status', 15)->default('menunggu'); // 'menunggu' | 'diverifikasi' | 'ditolak'
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Foreign Key Constraints
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('waste_type_id')
                  ->references('id')->on('waste_types')
                  ->onDelete('cascade');

            $table->foreign('verified_by')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
