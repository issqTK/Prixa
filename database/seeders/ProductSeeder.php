<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            /* Apple */
            [
                'name' => 'iPhone 14',
                'avatar' => 'iPhone 14.png',
                'category_id' => 1,
                'created_at' => NOW()
            ],
            [
                'name' => 'iPhone 14 Plus',
                'avatar' => 'iPhone 14 Plus.png',
                'category_id' => 1,
                'created_at' => NOW()
            ],
            [
                'name' => 'iPhone 14 Pro',
                'avatar' => 'iPhone 14 Pro.png',
                'category_id' => 1,
                'created_at' => NOW()
            ],
            [
                'name' => 'iPhone 13 Pro Max',
                'avatar' => 'iPhone 13 Pro Max.png',
                'category_id' => 1,
                'created_at' => NOW()
            ],
            [
                'name' => 'iPhone 13 Pro',
                'avatar' => 'iPhone 13 Pro.png',
                'category_id' => 1,
                'created_at' => NOW()
            ],
            [
                'name' => 'iPhone 13 mini',
                'avatar' => 'iPhone 13 mini.png',
                'category_id' => 1,
                'created_at' => NOW()
            ],
            [
                'name' => 'iPhone 13',
                'avatar' => 'iPhone 13.png',
                'category_id' => 1,
                'created_at' => NOW()
            ],
            /* Samsung */
            [
                'name' => 'Samsung Galaxy S23 Ultra',
                'avatar' => 'Samsung Galaxy S23 Ultra.png',
                'category_id' => 2,
                'created_at' => NOW()
            ],
            [
                'name' => 'Samsung Galaxy A54',
                'avatar' => 'Samsung Galaxy A54.png',
                'category_id' => 2,
                'created_at' => NOW()
            ],
            [
                'name' => 'Samsung Galaxy S23',
                'avatar' => 'Samsung Galaxy S23.png',
                'category_id' => 2,
                'created_at' => NOW()
            ],
            [
                'name' => 'Samsung Galaxy S23 Plus',
                'avatar' => 'Samsung Galaxy S23 Plus.png',
                'category_id' => 2,
                'created_at' => NOW()
            ],
            [
                'name' => 'Samsung Galaxy Z Fold 5',
                'avatar' => 'Samsung Galaxy Z Fold 5.png',
                'category_id' => 2,
                'created_at' => NOW()
            ],
            [
                'name' => 'Samsung Galaxy Z Flip 5',
                'avatar' => 'Samsung Galaxy Z Flip 5.png',
                'category_id' => 2,
                'created_at' => NOW()
            ],
        ]);
    }
}
