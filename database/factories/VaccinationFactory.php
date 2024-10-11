<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vaccination;
use App\Models\VaccinationCenter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vaccination>
 */
class VaccinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'scheduled_date' => Carbon::parse('next monday')->format('Y-m-d'),
        ];
    }
}
