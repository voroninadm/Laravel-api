<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'show']);


Route::post('/register', [UserController::class, 'register']);
