<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('withdrawal_requests',function(Blueprint $table){$table->id();$table->foreignId('user_id')->constrained()->cascadeOnDelete();$table->decimal('amount',10,2);$table->string('method',50);$table->string('account');$table->string('status',30)->default('pending')->index();$table->text('admin_note')->nullable();$table->timestamp('processed_at')->nullable();$table->timestamps();}); }
 public function down(): void { Schema::dropIfExists('withdrawal_requests'); }
};