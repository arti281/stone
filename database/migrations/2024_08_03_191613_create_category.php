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
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->string('slug');
            $table->integer('parent_id')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('description')->nullable();
            $table->string('meta_tag',255); 
            $table->integer('sort_order')->nullable();
            $table->integer('level')->nullable();
            $table->boolean('menu_top')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category');
    }
};
