<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmListResource extends JsonResource
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
            'previewVideoLink' => $this->preview_video_link,
            'released' => $this->released
        ];
    }
}
