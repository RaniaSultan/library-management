<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(3),
            'author_id' => Author::factory(),
            'published_at' => $this->faker->dateTimeBetween('-50 years', 'now')->format('Y-m-d'),
            'available_copies' => $this->faker->numberBetween(1, 10),
        ];
    }
}
