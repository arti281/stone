<?php

namespace Database\Seeders;

use App\Models\StockStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StockStatus::create([
            "name" => "Out Of Stock"  
        ]);
        StockStatus::create([
            "name" => "2-3 Days"  
        ]);
        StockStatus::create([
            "name" => "In Stock"  
        ]);
        StockStatus::create([
            "name" => "Pre-Order"  
        ]);
    }
}
