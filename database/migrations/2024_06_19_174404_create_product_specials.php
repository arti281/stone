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
        Schema::create('product_specials', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->integer('customer_group_id')->nullable();
            $table->integer('priority')->nullable();
            $table->decimal('price', 15,4)->nullable(0.0000);
            $table->date('start_date')->nullable();
            $table->date('close_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_specials');
    }
};
