<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('tasks', function (Blueprint $table) {
   $table->id(); $table->string('title'); $table->string('type'); $table->text('description')->nullable();
   $table->decimal('reward',8,2)->default(0); $table->string('slot')->default('morning'); $table->string('status')->default('available');
   $table->string('source_file')->nullable(); $table->json('requirements')->nullable(); $table->timestamp('available_from')->nullable();
   $table->timestamp('available_until')->nullable(); $table->timestamps(); $table->index(['status','slot']); $table->index('type');
  });
 }
 public function down(): void { Schema::dropIfExists('tasks'); }
};