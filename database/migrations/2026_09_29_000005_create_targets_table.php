<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(){Schema::create('targets',function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained('users')->cascadeOnDelete();$t->decimal('target_weight',8,2)->default(10);$t->string('period',20)->default('Bulan Ini');$t->timestamp('created_at')->useCurrent();});} public function down(){Schema::dropIfExists('targets');} };
