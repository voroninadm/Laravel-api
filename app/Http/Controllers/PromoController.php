<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function show()
    {
        return "show promo film";
    }

    public function store(Request $request)
    {
        Film::promo()->latest('updated_at')->first();
    }
}
