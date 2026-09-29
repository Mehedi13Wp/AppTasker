<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('worker_tasks', function (Blueprint $table) {
   $table->id(); $table->foreignId('task_id')->constrained()->cascadeOnDelete(); $table->foreignId('user_id')->constrained()->cascadeOnDelete();
   $table->string('status')->default('started'); $table->string('token')->unique(); $table->timestamp('started_at')->nullable();
   $table->timestamp('submitted_at')->nullable(); $table->timestamp('completed_at')->nullable(); $table->timestamps();
   $table->unique(['task_id','user_id']); $table->index(['user_id','status']);
  });
 }
 public function down(): void { Schema::dropIfExists('worker_tasks'); }
};