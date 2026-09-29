<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::table('campaigns',function(Blueprint $table){$table->string('payment_status',30)->default('unpaid')->index();$table->string('payment_method',30)->default('bkash');$table->string('transaction_id')->nullable()->unique();$table->timestamp('paid_at')->nullable();}); }
 public function down(): void { Schema::table('campaigns',function(Blueprint $table){$table->dropColumn(['payment_status','payment_method','transaction_id','paid_at']);}); }
};