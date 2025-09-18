<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Auth and User routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/user', [UserController::class, 'show']);
    Route::patch('/user', [UserController::class, 'update']);
});

