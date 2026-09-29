<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('task_submissions', function (Blueprint $table) {
   $table->id(); $table->foreignId('worker_task_id')->unique()->constrained()->cascadeOnDelete();
   $table->string('result_file'); $table->string('original_name')->nullable(); $table->string('mime_type')->nullable();
   $table->unsignedBigInteger('file_size')->nullable(); $table->string('status')->default('pending');
   $table->text('verification_notes')->nullable(); $table->timestamp('submitted_at')->nullable(); $table->timestamps();
   $table->index('status');
  });
 }
 public function down(): void { Schema::dropIfExists('task_submissions'); }
};