<?php

namespace Database\Seeders;

use App\Common\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $entries = [
            [
                'code' => '0001',
                'name' => 'Riyadh Region',
            ],
            [
                'code' => '0002',
                'name' => 'Mecca Region',
            ],
            [
                'code' => '0003',
                'name' => 'Medina Region',
            ],
            [
                'code' => '0004',
                'name' => 'Al-Qassim Region',
            ],
            [
                'code' => '0005',
                'name' => 'Eastern Region',
            ],
            [
                'code' => '0006',
                'name' => '\'Asir Region',
            ],
            [
                'code' => '0007',
                'name' => 'Tabuk Region',
            ],
            [
                'code' => '0008',
                'name' => 'Ha\'il Region',
            ],
            [
                'code' => '0009',
                'name' => 'Northern Borders Region',
            ],
            [
                'code' => '0010',
                'name' => 'Jazan Region',
            ],
            [
                'code' => '0011',
                'name' => 'Najran Region',
            ],
            [
                'code' => '0012',
                'name' => 'Al-Bahah Region',
            ],
            [
                'code' => '0013',
                'name' => 'Al-Jawf Region'
            ]
        ];

        foreach ($entries as $entry) {
            Region::firstOrCreate([
                'name' => $entry['name']
            ], $entry);
        }
    }
}
