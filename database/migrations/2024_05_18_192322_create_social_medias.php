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
        Schema::create('social_medias', function (Blueprint $table) {
            $table->id();
            $table->string('instagram',255)->nullable();
            $table->string('facebook',255)->nullable();
            $table->string('youtube',255)->nullable();
            $table->boolean('status')->default(0);
        });

        // Insert default values into the social_medias table
        DB::table('social_medias')->insert([
            'instagram' => '@instagram',
            'facebook' => '@facebook',
            'youtube' => 'Youtube',
            'status' => true
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_medias');
    }
};
