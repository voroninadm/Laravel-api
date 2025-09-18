<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(auth()->id())
            ],
            'password' => [
                'nullable',
                'min:8',
                'confirmed',
            ],
            'name' => 'nullable|string|max:255',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ];
    }
}
