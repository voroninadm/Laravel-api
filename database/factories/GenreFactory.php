<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Genre>
 */
class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genres = [
            'Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy',
            'Horror', 'Mystery', 'Romance', 'Sci-Fi', 'Thriller',
            'Documentary', 'Animation', 'Crime', 'Western', 'Musical'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($genres),
        ];
    }
}
