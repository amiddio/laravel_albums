<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->lexify(),
            'year' => $this->faker->year(),
            'duration' => '44:25',
            'label' => $this->faker->word(),
            'genres' => $this->faker->words(3, true),
        ];
    }
}
