<?php

namespace App\Http\Requests\Film;

use App\Enums\FilmStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFilmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'poster_image' => 'nullable|string|max:255',
            'preview_image' => 'nullable|string|max:255',
            'background_image' => 'nullable|string|max:255',
            'background_color' => ['nullable', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'video_link' => 'nullable|string|max:255',
            'preview_video_link' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'director' => 'nullable|string|max:255',
            'starring' => 'nullable|array',
            'run_time' => 'nullable|string|max:50',
            'released' => 'nullable|string|date',
            'imdb_id' => ['required', 'regex:/^tt\d+$/', Rule::unique('films', 'imdb_id')->ignoreModel($this->film)],
            'status' => [Rule::in([FilmStatus::Pending, FilmStatus::OnModeration, FilmStatus::Ready])],
        ];
    }

    public function messages()
    {
        return [
            'background_color.regex' => 'Цвет должен быть задан в формате #ffffff',
            'imdb_id.regex' => 'imdb id должен быть передан в формате tt0123456789',
            'imdb_id.unique' => 'Такой фильм уже есть в базе'
        ];
    }
}

