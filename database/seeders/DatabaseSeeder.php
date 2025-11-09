<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Insert 3 room categories
        DB::table('room_categories')->insert([
            [
                'name' => 'Premium Deluxe',
                'base_price' => 12000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Super Deluxe',
                'base_price' => 10000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Standard Deluxe',
                'base_price' => 8000.00,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}