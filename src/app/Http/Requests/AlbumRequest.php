<?php

namespace App\Http\Requests;

use App\Models\Artist;
use App\Models\ReleaseType;
use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
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
            'artist_id' => ['nullable', 'integer', 'exists:'.Artist::class.',id'],
            'release_type_id' => ['nullable', 'integer', 'exists:'.ReleaseType::class.',id'],
            'title' => ['required', 'string'],
            'year' => ['required', 'integer', 'digits:4'],
            'duration' => ['required', 'string', 'min:5', 'max:10'],
            'label' => ['nullable', 'string', 'max:50'],
            'genres' => ['nullable', 'string', 'max:100'],
        ];
    }
}
