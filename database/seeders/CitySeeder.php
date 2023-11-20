<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            ['name' => 'El Jadida', 'created_at' => NOW()],
            ['name' => 'Casablanca', 'created_at' => NOW()],
            ['name' => 'Rabat', 'created_at' => NOW()],
            ['name' => 'Marrakech', 'created_at' => NOW()],
            ['name' => 'Fes', 'created_at' => NOW()],
            ['name' => 'Meknes', 'created_at' => NOW()],
            ['name' => 'Tanger', 'created_at' => NOW()],

        ]);
    }
}
