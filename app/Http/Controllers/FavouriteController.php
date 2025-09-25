<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function index()
    {
        return  "favourites films";
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
