<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $film = Film::create([
            "name" => "Howl's Moving Castle",
            "poster_image" => "https://m.media-amazon.com/images/M/MV5BMTY1OTg0MjE3MV5BMl5BanBnXkFtZTcwNTUxMTkyMQ@@._V1_SX300.jpg",
            "description" => "When an unconfident young woman is cursed with an old body by a spiteful witch, her only chance of breaking the spell lies with a self-indulgent yet insecure young wizard and his companions in his legged, walking castle.",
            "director" => "Hayao Miyazaki",
            "starring" => ["Chieko Baishô, Takuya Kimura, Tatsuya Gashûin"],
            "run_time" => 119,
            "released" => "2005",
            "imdb_id" => "tt0347149",
            "status" => Film::STATUS_READY,
        ]);

        $film->genres()->attach([2, 3, 4]);
    }
}
