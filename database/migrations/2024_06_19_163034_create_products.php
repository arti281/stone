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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name', 255);
            $table->text('product_description')->nullable();
            $table->text('tag')->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keyword', 255)->nullable();
            $table->string('model', 255)->nullable();
            $table->integer('quantity');
            $table->integer('minimum')->nullable();
            $table->integer('subtract')->nullable();
            $table->integer('stock_status_id')->nullable();
            $table->timestamp('date_available')->nullable();
            $table->boolean('shipping')->default(0)->nullable();
            $table->decimal('length', 15, 4)->nullable();
            $table->decimal('width', 15, 4)->nullable();
            $table->decimal('height', 15, 4)->nullable();
            $table->integer('length_class_id')->nullable();
            $table->decimal('weight', 15, 4)->nullable();
            $table->integer('weight_class_id')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('slug',255)->nullable();
            $table->boolean('status')->default(0);
            $table->integer('sort_order')->nullable();
            $table->timestamps();
        });    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
