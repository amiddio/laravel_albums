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
            ['name' => 'Studio Albums'],
            ['name' => 'Compilations'],
            ['name' => 'Singles & EPs'],
            ['name' => 'Videos'],
            ['name' => 'Others'],
        ];

        ReleaseType::truncate();

        foreach ($rows as $row) {
            ReleaseType::create($row);
        }
    }
}
