<?php

namespace Database\Factories;

use App\Enums\FilmStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class FilmFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'status' => FilmStatus::Ready, // объект enum, не строка
            'description' => $this->faker->sentences(2, true),
            'director' => $this->faker->name(),
            'starring' => $this->faker->name() . ', ' . $this->faker->name() . ', ' . $this->faker->name(),
            'run_time' => random_int(60, 240) . "min",
            'released' => $this->faker->date(),
            'imdb_id' => 'tt00' . random_int(1, 9999),
        ];
    }

    public function pending(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => FilmStatus::Pending, // объект enum
            ];
        });
    }
}
