<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            ['name' => "Action"],
            ['name' => "Fantasy"],
            ['name' => "Family"],
            ['name' => "Animation"],
            ['name' => "Adventure"],
            ['name' => "Comedy"],
            ['name' => "Horror"],
            ['name' => "Crime"],
            ['name' => "Drama"],
            ['name' => "Mystery"],
        ];

        Genre::upsert($genres, ['name']);
    }
}
