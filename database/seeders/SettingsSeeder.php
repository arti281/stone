<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
        [
            'code' => 'ecommerce',
            'key' => 'ecommerce_other_url_status',
            'value' => 0
        ],
        [
            'code' => 'site',
            'key' => 'site_logo',
            'value' => 'logo.png'
        ]
    ]);
    }
}
