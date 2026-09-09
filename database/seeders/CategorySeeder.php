<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['code' => 'COMPUTER', 'name' => 'Desktop Computer'],
            ['code' => 'LAPTOP', 'name' => 'Laptop'],
            ['code' => 'SERVER', 'name' => 'Server'],
            ['code' => 'NETWORK', 'name' => 'Network Equipment'],
            ['code' => 'PRINTER', 'name' => 'Printer'],
            ['code' => 'SCANNER', 'name' => 'Scanner'],
            ['code' => 'MONITOR', 'name' => 'Monitor'],
            ['code' => 'UPS', 'name' => 'UPS / Uninterruptible Power Supply'],
            ['code' => 'PROJECTOR', 'name' => 'Projector'],
            ['code' => 'CCTV', 'name' => 'CCTV Equipment'],
            ['code' => 'TELECOM', 'name' => 'Telecommunication Equipment'],
            ['code' => 'STORAGE', 'name' => 'Storage Device'],
            ['code' => 'PERIPHERAL', 'name' => 'Computer Peripheral'],
            ['code' => 'SOFTWARE', 'name' => 'Software / License'],
            ['code' => 'MOBILE', 'name' => 'Mobile Device'],
            ['code' => 'AUDIO', 'name' => 'Audio / Visual Equipment'],
            ['code' => 'POWER', 'name' => 'Power Equipment'],
            ['code' => 'OTHER', 'name' => 'Other ICT Equipment'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['code' => $category['code']],
                [
                    'name' => $category['name'],
                    'is_active' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}