<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::create([
            "name" => "Pending",
        ]);
        OrderStatus::create([
            "name" => "Processing",
        ]);
        OrderStatus::create([
            "name" => "Shipped",
        ]);
        OrderStatus::create([
            "name" => "On the way",
        ]);
        OrderStatus::create([
            "name" => "Delivered",
        ]);
        OrderStatus::create([
            "name" => "Completed",
        ]);
        OrderStatus::create([
            "name" => "Canceled",
        ]);
        OrderStatus::create([
            "name" => "Refunded",
        ]);
        OrderStatus::create([
            "name" => "Order Booked",
        ]);
    }
}
