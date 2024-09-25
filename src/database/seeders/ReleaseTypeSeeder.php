<?php

namespace Database\Seeders;

use App\Models\ReleaseType;
use Illuminate\Database\Seeder;

class ReleaseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            ['slug' => 'studio_albums', 'name' => 'Studio Albums'],
            ['slug' => 'compilations', 'name' => 'Compilations'],
            ['slug' => 'singles_and_eps', 'name' => 'Singles & EPs'],
            ['slug' => 'videos', 'name' => 'Videos'],
            ['slug' => 'others', 'name' => 'Others'],
        ];

        ReleaseType::truncate();

        foreach ($rows as $row) {
            ReleaseType::create($row);
        }
    }
}
