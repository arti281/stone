<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->integer('reference_id')->nullable();
            $table->string('reference_name',50)->nullable();
            $table->string('ip_address',50)->nullable();
            $table->string('country',50)->nullable();
            $table->string('countryCode',50)->nullable();
            $table->string('region',50)->nullable();
            $table->string('regionName',50)->nullable();
            $table->string('city',50)->nullable();
            $table->string('zip',50)->nullable();
            $table->string('lat',50)->nullable();
            $table->string('lon',50)->nullable();
            $table->string('timezone',50)->nullable();
            $table->string('isp',50)->nullable();
            $table->string('org',50)->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            //$table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
