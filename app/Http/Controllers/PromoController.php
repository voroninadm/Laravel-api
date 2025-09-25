<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function show()
    {
        return "show promo film";
    }

    public function store(Request $request)
    {
        return "store promo film";
    }
}
