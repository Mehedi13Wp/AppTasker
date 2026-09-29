<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('campaigns',function(Blueprint $table){$table->id();$table->foreignId('user_id')->constrained()->cascadeOnDelete();$table->string('app_name');$table->text('app_url');$table->string('plan',50);$table->decimal('amount',10,2)->default(0);$table->unsignedInteger('duration_days')->default(30);$table->string('status',30)->default('pending')->index();$table->timestamp('accepted_at')->nullable();$table->timestamp('ends_at')->nullable();$table->timestamps();}); }
 public function down(): void { Schema::dropIfExists('campaigns'); }
};