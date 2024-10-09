<?php

namespace Database\Seeders;

use App\Models\VaccineCenter;
use Illuminate\Database\Seeder;

class VaccineCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VaccineCenter::create([
            ['name' => 'Center 1', 'daily_capacity' => 100],
            ['name' => 'Center 2', 'daily_capacity' => 150],
        ]);
    }
}
