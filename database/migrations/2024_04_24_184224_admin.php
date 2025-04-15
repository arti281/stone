<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username',50);
            $table->string('password',255);
            $table->string('firstname',50);
            $table->string('lastname',50);
            $table->string('email',50);
            $table->string('image',255)->nullable();
            $table->string('ip',50)->nullable();
            $table->boolean('status')->default(0);
            $table->integer('admin_group_id')->length(11)->default(0);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
