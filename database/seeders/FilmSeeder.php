<?php

namespace Database\Seeders;

use App\Enums\FilmStatus;
use App\Models\Comment;
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
            "run_time" => "119 min",
            "released" => "1 Jul 2005",
            "imdb_id" => "tt0347149",
            "status" => FilmStatus::Ready,
        ]);

        $film->genres()->attach([2, 3, 4]);
        $film->comments()->create(Comment::factory()->make()->toArray());

        $film = Film::create([
            "name" => "Castle in the Sky",
            "poster_image" => "https://m.media-amazon.com/images/M/MV5BZjcyMjg2MzktNjg4YS00MjQzLTg0YWQtMjUyZDk2Y2Y0YzZjXkEyXkFqcGc@._V1_SX300.jpg",
            "description" => "Pazu's life changes when he meets Sheeta, a girl whom pirates are chasing for her crystal amulet, which has the potential to locate Laputa, a legendary castle floating in the sky.",
            "director" => "Hayao Miyazaki",
            "starring" => ["Mayumi Tanaka, Keiko Yokozawa, Kotoe Hatsui"],
            "run_time" => "124 min",
            "released" => "12 Oct 1991",
            "imdb_id" => "tt0092067",
            "status" => FilmStatus::Ready,
        ]);

        $film->genres()->attach([2, 3, 4]);
        $film->comments()->create(Comment::factory()->make()->toArray());
    }
}
