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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_master_id')->constrained('order_masters')->onDelete('cascade');
            $table->string('payment_method', 50)->default('cod'); // 'cod', 'upi', etc.
            $table->string('status', 50)->default('pending');     // 'pending', 'paid'
            $table->timestamp('paid_at')->nullable();             // Time payment was completed
            $table->double('amount', 15, 2);  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
