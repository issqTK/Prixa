<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Logo;

class LogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Logo::create([
            'frontLogo' => 'logo.png',
            'backLogo' => 'logo2.png',
            'faviconLogo' => 'logo.png',
        ]);
    }
}
