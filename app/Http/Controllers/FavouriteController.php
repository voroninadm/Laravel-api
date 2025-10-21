<?php

namespace App\Http\Controllers;

use App\Http\Resources\FilmListResource;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        return "store to favourites";
    }

    public function destroy(Request $request)
    {
        return "destroy from favourites";
    }
}
