<?php

namespace Database\Factories;

use App\Models\VaccinationCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VaccinationCenter>
 */
class VaccinationCenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'location' => $this->faker->city,
            'daily_capacity' => $this->faker->numberBetween(100, 200),
            'active' => true,
        ];
    }
}
