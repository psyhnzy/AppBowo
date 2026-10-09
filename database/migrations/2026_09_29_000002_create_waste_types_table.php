<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(){Schema::create('waste_types',function(Blueprint $t){$t->id();$t->string('name',50);$t->string('category',50);$t->decimal('price_per_kg',10,2);$t->text('description')->nullable();$t->enum('status',['active','inactive'])->default('active');$t->timestamp('created_at')->useCurrent();});} public function down(){Schema::dropIfExists('waste_types');} };
