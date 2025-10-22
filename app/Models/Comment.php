<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'rating',
        'user_id',
        'film_id',
    ];

    protected $visible = [
        'id',
        'text',
        'rating',
        'created_at',
        'author',
    ];

    // виртуальное поле для имени автора коммента
    protected $appends = [
        'author_name',
    ];

    public function getAuthorNameAttribute()
    {
        return $this->author->name;
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class);
    }
}
