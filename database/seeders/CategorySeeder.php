<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'iPhone', 
                'created_at' => NOW() 
            ],
            [
                'name' => 'Samsung', 
                'created_at' => NOW() 
            ],
            [
                'name' => 'Vivo', 
                'created_at' => NOW() 
            ],
            [
                'name' => 'Nokia', 
                'created_at' => NOW() 
            ],
            [
                'name' => 'Xiaomi', 
                'created_at' => NOW() 
            ],
            [
                'name' => 'Huawei', 
                'created_at' => NOW() 
            ],
            [
                'name' => 'OPPO', 
                'created_at' => NOW() 
            ]
        ]);
    }
}
