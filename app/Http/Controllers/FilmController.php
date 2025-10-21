<?php

namespace App\Http\Controllers;

use App\Enums\FilmStatus;
use App\Http\Requests\Film\AddFilmRequest;
use App\Http\Resources\FilmListResource;
use App\Http\Resources\FilmResource;
use App\Models\Film;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $films = Film::select(Film::FIELDS_LIST)
            ->filterByGenre($request->genre)
            ->filterByStatus($request->status, $request->user())
            ->ordered($request->order_by, $request->order_to)
            ->paginate(8);

        $films->getCollection()->transform(function ($film) {
            return new FilmListResource($film);
        });

        return $this->paginatedResponse($films);
    }

    public function show($id): Responsable
    {
        $film = Film::with('genres')->findOrFail($id);
        return $this->successResponse(new FilmResource($film));
    }

    public function store(AddFilmRequest $request)
    {
        Film::create([
            'imdb_id' => $request->input('imdb'),
            'status' => FilmStatus::Pending,
        ]);

        return $this->successResponse(null, 201);
    }

    public function update(Film $id)
    {
        return "update film";
    }

    public function similar()
    {
        return "similar films";
    }

}
