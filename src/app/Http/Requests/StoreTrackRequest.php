<?php

namespace App\Http\Requests;

use App\Models\Album;
use Illuminate\Foundation\Http\FormRequest;

class StoreTrackRequest extends FormRequest
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
            'album_id' => ['required', 'integer', 'exists:'.Album::class.',id'],
            'disc' => ['required', 'integer', 'min:1'],
            'number' => ['required', 'integer', 'min:1'],
            'title' => ['required', 'string'],
            'duration' => ['required', 'string', 'min:5', 'max:10'],
            'composers' => ['nullable', 'string'],
            'performers' => ['nullable', 'string'],
        ];
    }
}
