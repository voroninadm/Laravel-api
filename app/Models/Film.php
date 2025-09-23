<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Film extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_ON_MODERATION = 'moderate';
    public const STATUS_READY = 'ready';


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


    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    protected $casts = [
        'starring' => 'array',
        'is_promo' => 'bool',
    ];
}
