<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert default values into the admins table
        DB::table('admins')->insert([
            'username' => 'admin',
            'password' => '$2y$10$Q6fxG6K5Lr1QTxMzJOucC.dm7Ma1nrS2NRdIOm6JdJpaOGpPQ/R1S',
            'firstname' => 'admin',
            'lastname' => 'admin',
            'email' => 'admin@gmail.com',
            'image' => NULL,
            'ip' => NULL,
            'status' => 1,
            'admin_group_id' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
