<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestException;
use App\Http\Resources\FilmListResource;
use App\Models\Film;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function index()
    {
        $films = Auth::user()->likedFilms()
            ->orderBy('film_user.created_at', 'desc')
            ->paginate(8);

        $films->getCollection()->transform(function ($film) {
            return new FilmListResource($film);
        });

        return $this->paginatedResponse($films);
    }

    public function store(Film $film)
    {
        $user = Auth::user();

        if ($user->hasFilm($film)) {
            throw new RequestException("Фильм уже находится в избранном");
        }

        $user->likedFilms()->attach($film->id);

        return $this->successResponse([
            'message' => 'Фильм добавлен в избранное'
        ], 201);
    }

    public function destroy(Film $film)
    {
        $user = Auth::user();

        if (!$user->hasFilm($film)) {
            throw new RequestException("Переданный фильм не находится избранном");
        }

        $user->likedFilms()->detach($film->id);

        return $this->successResponse([
            'message' => 'Фильм удален из избранного'
        ], 201);
    }
}
