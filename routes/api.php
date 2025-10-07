<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
});

Route::controller(UserController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'show'])->name('user.index');
    Route::patch('/user', [UserController::class, 'update'])->name('user.update');
});

Route::controller(FilmController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/films', 'index')->name('films.index');
    Route::get('/films/{id}', 'show')->name('films.show');
    Route::post('/films/', 'store')->middleware('can:moderator')->name('films.store');
    Route::patch('/films/{id}', 'update')->middleware('can:moderator')->name('films.update');
    Route::get('/films/{id}/similar', 'similar')->name('films.similar');
});

Route::controller(GenreController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/genres', 'index')->name('genres.index');
    Route::patch('/genres/{genre}', 'update')->middleware('can:moderator')->name('genres.update');
});

Route::controller(FavouriteController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/favourite', 'index')->name('favourite.index');
    Route::post('/films/{id}/favourite', 'store')->name('favourite.store');
    Route::delete('/films/films/{id}/favourite', 'destroy')->name('favourite.destroy');
});

Route::controller(CommentController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/films/{id}/comments', 'index')->name('comments.index');
    Route::post('/films/{id}/comments', 'store')->name('comments.store');
    Route::patch('/comments/{comment}', 'update')->name('comments.update');
    Route::delete('/comments/{comment}', 'destroy')->name('comments.destroy');
});

Route::controller(PromoController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/promo', 'show')->name('promo.index');
    Route::post('/promo/{id}', 'store')->middleware('can:moderator')->name('promo.store');
});
