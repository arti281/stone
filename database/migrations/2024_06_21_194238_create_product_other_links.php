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
        Schema::create('product_other_links', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->string('amazon', 300)->nullable();
            $table->string('flipkart', 300)->nullable();
            $table->string('myntra', 300)->nullable();
            $table->string('ajio', 300)->nullable();
            $table->string('meesho', 300)->nullable();
            $table->boolean('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_other_links');
    }
};
