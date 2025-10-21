<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'posterImage' => $this->poster_image,
            'previewImage' => $this->preview_image,
            'backgroundImage' => $this->background_image,
            'backgroundColor' => $this->background_color,
            'videoLink' => $this->video_link,
            'previewVideoLink' => $this->preview_video_link,
            'description' => $this->description,
            'director' => $this->director,
            'starring' => $this->starring,
            'runTime' => $this->run_time,
            'released' => $this->released,
            'imdbId' => $this->imdb_id,
            'rating' => $this->rating,
            'isFavorite' => $this->when(Auth::check(), $this->is_favorite),
        ];
    }
}
