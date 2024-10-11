<?php

namespace Database\Seeders;

use App\Models\VaccinationCenter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class VaccineCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VaccinationCenter::insert([
            ['name' => 'Bangladesh Kuwait Moitree Hospital', 'location' => 'Dhaka', 'daily_capacity' => 100],
            ['name' => 'Railway Hospital', 'location' => 'Dhaka', 'daily_capacity' => 150],
            ['name' => 'Mohanagar General Hospital', 'location' => 'Dhaka', 'daily_capacity' => 120],
            ['name' => 'Mirpur Lalkuthi Hospital', 'location' => 'Dhaka', 'daily_capacity' => 150],
            ['name' => 'Kurmitola General Hospital', 'location' => 'Dhaka', 'daily_capacity' => 140],
            ['name' => 'Shohidsamsuddinahmed Hospital', 'location' => 'Sylhet', 'daily_capacity' => 130],
            ['name' => 'Sonkramokbyadhi Hospital', 'location' => 'Sylhet', 'daily_capacity' => 110],
            ['name' => 'AdhunikSadar Hospital', 'location' => 'Rangpur', 'daily_capacity' => 120],
            ['name' => 'Sadar Hospital', 'location' => 'Jhenaidah', 'daily_capacity' => 100],
        ]);

        // Clear the cache after seeding to ensure fresh data is loaded
        Cache::forget('active_vaccine_centers');
    }
}
