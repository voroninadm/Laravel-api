<?php

namespace App\Http\Controllers;

use App\Http\Resources\FilmResource;
use App\Models\Film;
use Illuminate\Contracts\Support\Responsable;

class FilmController extends Controller
{
    public function index(): Responsable
    {
        $films = Film::with('genres')->paginate(8);
        return $this->paginatedResponse($films);
    }

    public function show($id): Responsable
    {
        $film = Film::with('genres')->findOrFail($id);
        return $this->successResponse(new FilmResource($film));
    }

    public function store()
    {
        return "store new film";
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
