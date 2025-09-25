<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();

        return response()->json([
            'genres' =>$genres,
        ], 200);
    }

    public function update (Request $request, $id)
    {
        return "update";
    }
}
