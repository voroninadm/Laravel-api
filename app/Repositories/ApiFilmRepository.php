<?php

namespace App\Repositories;

use App\Contracts\FilmRepositoryInterface;
use App\Models\Film;
use Illuminate\Support\Facades\Http;

class ApiFilmRepository implements FilmRepositoryInterface
{

    public function getFilm(string $imdbId)
    {

        $response = Http::get(config('services.omdbapi.url'), [
            'apikey' => config('services.omdbapi.key'),
            'i' => $imdbId,
        ]);

        if ($response->failed()) {
            throw new \Exception('Ошибка запроса к OmdbApi');
        }

        $data = $response->json();

        $film = Film::firstOrNew (['imdb_id' => $imdbId]);

        $film->fill([
            'name' => $data['Title'],
            'description' => $data['Plot'],
            'director' => $data['Director'],
            'starring' => $data['Actors'],
            'run_time' => $data['Runtime'],
            'released' => $data['Released'],
        ]);

        $links = [
            'poster_image' => $data['Poster'],
        ];

        $genres = explode(', ', $data['Genre']);

        return [
            'film' => $film,
            'genres' => $genres,
            'links' => $links,
        ];
    }
}
