<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            DB::table('bills')->insert([
                'song_id' => $i + 1,
                'order_code' => fake()->numberBetween(9000, 9999),
                'price' => 10000,
                'status' => fake()->randomElement(['PAID', 'PENDING', 'PROCESSING', 'CANCELLED', 'SHIPPED']),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
