<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Track>
 */
class TrackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'disc' => 1,
            'title' => fake()->lexify(),
            'duration' => fake()->time('i:s'),
            'composers' => fake()->lexify(),
            'performers' => fake()->lexify(),
        ];
    }
}
