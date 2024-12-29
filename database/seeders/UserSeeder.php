<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Prixa Admin',
                'phone' => '0612223682',
                'email' => 'prixa@admin.com',
                'admin' => 1,
                'password' => Hash::make('prixa@admin.com'),
            ],
            [
                'name' => 'Taki Isaq',
                'phone' => '0693331812',
                'email' => 'takiisaq@gmail.com',
                'admin' => 0,
                'password' => Hash::make('hhirf@1991'),
            ]
        ]);
    }
}
