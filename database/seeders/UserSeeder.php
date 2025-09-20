<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    private $names = [
        "Sơn Tùng M-TP",
        "Mỹ Tâm",
        "Đen Vâu",
        "Hà Anh Tuấn",
        "Min"
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $time = now()->subDays(rand(0, 365))->subMinutes(rand(0, 1440));
            DB::table('users')->insert([
                'name' => $this->names[$i],
                'created_at' => $time,
                'updated_at' => $time
            ]);
        }
        for ($i = 0; $i < 100; $i++) {
            $time = now()->subDays(rand(0, 365))->subMinutes(rand(0, 1440));
            DB::table('users')->insert([
                'name' => fake()->name(),
                'created_at' => $time,
                'updated_at' => $time
            ]);
        }
    }
}
