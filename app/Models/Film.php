<?php

namespace App\Models;

use App\Enums\FilmStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Film extends Model
{
    use HasFactory;

    /**
     * Список необходимых колонок для фильтруемого списка фильмов
     */
    public const FIELDS_LIST = ['id', 'name', 'poster_image', 'preview_image', 'preview_video_link', 'released'];
    public const CACHE_PROMO_KEY = 'promo_film';

    protected $table = 'films';
    protected $fillable = [
        "name",
        "poster_image",
        "preview_image",
        "background_image",
        "background_color",
        "video_link",
        "preview_video_link",
        "description",
        "director",
        "starring",
        "run_time",
        "released",
        "is_promo",
        "status",
        "imdb_id",
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'starring' => 'array',
        'is_promo' => 'bool',
        'released' => 'date'
    ];

    protected $appends = [
        'rating',
        'is_favorite',
    ];

    public function getReleasedAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }


    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNotNull('rating');
    }

    public function getRatingAttribute()
    {
        return round($this->scores()->avg('rating'), 1);
    }

    public function getIsFavoriteAttribute()
    {
        return Auth::check() && Auth::user()->hasFilm($this);
    }

    /**
     * Скоуп для сортировки
     */
    public function scopeOrdered($query, ?string $orderBy = null, ?string $orderTo = null)
    {
        return $query->when($orderBy === 'rating', function ($q) {
            $q->withAvg('scores as rating', 'rating');
        })->orderBy($orderBy ?? 'released', $orderTo ?? 'desc');
    }

    public function scopeFilterByGenre($query, ?string $genre)
    {
        return $genre ? $query->whereRelation('genres', 'name', $genre) : $query;
    }

    public function scopeFilterByStatus($query, ?string $status, ?User $user)
    {
        if ($status && $user?->isModerator()) {
            return $query->whereStatus($status);
        }

        return $query->whereStatus(FilmStatus::Ready);
    }

    public function scopePromo($query)
    {
        $query->where('promo', true);
    }

}
