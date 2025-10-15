<?php

namespace App\Providers;

use App\Contracts\FilmRepositoryInterface;
use App\Models\Comment;
use App\Models\User;
use App\Repositories\ApiFilmRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FilmRepositoryInterface::class, ApiFilmRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(20)->by($request->user()?->id ?: $request->ip());
        });

        Gate::define('comment.update', function (User $user, Comment $comment) {
            return $comment->author->is($user) || $user->isModerator();
        });

        Gate::define('comment.delete', function (User $user, Comment $comment) {
            return $comment->author->is($user) || $user->isModerator();
        });
    }
}
