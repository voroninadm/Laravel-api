<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\JsonResponse;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::with('genres')->paginate(8);

        return response()->json([
            'films' =>$films,
        ], 200);
    }

    public function show($id): JsonResponse
    {
        $film = Film::with('genres')->findOrFail($id);
        return response()->json([
            'film' =>$film,
        ],200);
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
