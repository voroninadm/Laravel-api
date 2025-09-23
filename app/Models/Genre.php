<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    protected $table = 'genres';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];


    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class);
    }
}
