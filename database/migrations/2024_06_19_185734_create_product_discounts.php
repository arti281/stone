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
        Schema::create('product_discounts', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->integer('customer_group_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('priority')->nullable();
            $table->decimal('price', 15,4)->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('close_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_discounts');
    }
};
