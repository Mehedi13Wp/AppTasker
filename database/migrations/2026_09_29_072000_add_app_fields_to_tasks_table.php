<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::table('tasks', function (Blueprint $table) {
   $table->string('app_name')->nullable()->after('source_file');
   $table->string('app_url')->nullable()->after('app_name');
   $table->string('app_package')->nullable()->after('app_url');
  });
 }
 public function down(): void {
  Schema::table('tasks', function (Blueprint $table) { $table->dropColumn(['app_name','app_url','app_package']); });
 }
};