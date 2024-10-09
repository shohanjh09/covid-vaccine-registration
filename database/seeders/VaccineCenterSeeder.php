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
        // Use insert() for multiple records
        VaccineCenter::insert([
            ['name' => 'Bangladesh Kuwait Moitree Hospital', 'location' => 'Dhaka', 'daily_capacity' => 100],
            ['name' => 'Railway Hospital', 'location' => 'Dhaka', 'daily_capacity' => 150],
            ['name' => 'Mohanagar General Hospital', 'location' => 'Dhaka', 'daily_capacity' => 120],
            ['name' => 'Mirpur Lalkuthi Hospital', 'location' => 'Dhaka', 'daily_capacity' => 150],
            ['name' => 'Kurmitola General Hospital', 'location' => 'Dhaka', 'daily_capacity' => 140],
            ['name' => 'shohidsamsuddinahmed Hospital', 'location' => 'Sylhet', 'daily_capacity' => 130],
            ['name' => 'sonkramokbyadhi Hospital', 'location' => 'Sylhet', 'daily_capacity' => 110],
            ['name' => 'AdhunikSadar Hospital', 'location' => 'Rangpur', 'daily_capacity' => 120],
            ['name' => 'Sadar Hospital', 'location' => 'Jhenaidah', 'daily_capacity' => 100],
        ]);
    }
}
