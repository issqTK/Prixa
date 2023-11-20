<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Listing;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Listing::create([
            'avatar' => 'iPhone 14 Plus.png',
            'title' => 'Apple iPhone 14 Plus',
            'description_header' => 'Apple iPhone 14 Plus smartphone. Announced Sep 2022. Features 6.7″ display, Apple A15 Bionic chipset, 4323 mAh battery, 512 GB storage, 6 GB RAM, Ceramic Shield glass.',
            'description_footer' => 'HDR display<br>True Tone<br>Wide color (P3)<br>Haptic Touch<br>2,000,000:1 contrast ratio (typical)<br>800 nits max brightness (typical); 1200 nits peak brightness (HDR)<br>Fingerprint-resistant oleophobic coating<br>Support for display of multiple languages and characters simultaneously',
            'meta_title' => 'Apple iPhone 14 Plus',
            'meta_description' => 'Apple iPhone 14 Plus smartphone. Announced Sep 2022. Features 6.7″ display, Apple A15 Bionic chipset, 4323 mAh battery, 512 GB storage, 6 GB RAM, Ceramic Shield glass.',
            'slug' => 'apple-iphone-14-plus',
            'product_ids' => [2],
            'city_id' => 1 
        ]); 
        Listing::create([
            'avatar' => 'iPhone 13 Pro Max.png',
            'title' => 'Apple iPhone 13 Pro Max',
            'description_header' => 'Apple iPhone 13 Pro Max smartphone. Announced Sep 2021. Features 6.7″  display, Apple A15 Bionic chipset, 4352 mAh battery, 1024 GB storage, 6 GB RAM, Ceramic Shield glass.',
            'description_footer' => 'ProMotion technology with adaptive refresh rates up to 120Hz<br>HDR display<br>True Tone<br>Wide color (P3)<br>Haptic Touch<br>2,000,000:1 contrast ratio (typical)<br>1000 nits max brightness (typical); 1200 nits max brightness (HDR)<br>Fingerprint-resistant oleophobic coating<br>Support for display of multiple languages and characters simultaneously',
            'meta_title' => 'Apple iPhone 13 Pro Max',
            'meta_description' => 'Apple iPhone 13 Pro Max smartphone. Announced Sep 2021. Features 6.7″  display, Apple A15 Bionic chipset, 4352 mAh battery, 1024 GB storage, 6 GB RAM, Ceramic Shield glass.',
            'slug' => 'apple-iphone-14-pro-max',
            'product_ids' => [4,5],
            'city_id' => 2
        ]);
        Listing::create([
            'avatar' => 'Samsung Galaxy S23 Ultra.png',
            'title' => 'Samsung Galaxy S23 Ultra',
            'description_header' => 'Samsung Galaxy S23 Ultra Android smartphone. Announced Feb 2023. Features 6.8″  display, Snapdragon 8 Gen 2 chipset, 5000 mAh battery, 1024 GB storage, 12 GB RAM, Corning Gorilla Glass Victus 2.',
            'description_footer' => 'Released 2023, February 17<br>163.4 x 78.1 x 8.9 mm (6.43 x 3.07 x 0.35 in)<br>dust/water resistant (up to 1.5m for 30 min)<br>Armor aluminum frame with tougher drop and scratch resistance (advertised)<br><br>Fingerprint (under display, ultrasonic), accelerometer, gyro, proximity, compass, barometer<br>Samsung DeX, Samsung Wireless DeX (desktop experience support)<br>Ultra Wideband (UWB) support',
            'meta_title' => 'Samsung Galaxy S23 Ultra - Full phone specifications',
            'meta_description' => 'Samsung Galaxy S23 Ultra Android smartphone. Announced Feb 2023. Features 6.8″  display, Snapdragon 8 Gen 2 chipset, 5000 mAh battery, 1024 GB storage, 12 GB RAM, Corning Gorilla Glass Victus 2.',
            'slug' => 'samsung_galaxy_s23_ultra',
            'product_ids' => [8],
            'city_id' => 3
        ]);
          
    }
}
