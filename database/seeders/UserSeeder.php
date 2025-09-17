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
            DB::table('users')->insert([
                'name' => $this->names[$i],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
