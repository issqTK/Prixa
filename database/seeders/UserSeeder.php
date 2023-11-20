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
                'name' => 'Taki Issam',
                'phone' => '0612223682',
                'email' => 'eltakiissam@gmail.com',
                'password' => Hash::make('hhirf@1991'),
            ]
        ]);
    }
}
