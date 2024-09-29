<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrackRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'disc' => ['required', 'integer', 'min:1'],
            'number' => ['required', 'integer', 'min:1'],
            'title' => ['required', 'string'],
            'duration' => ['required', 'string', 'min:5', 'max:10'],
            'composers' => ['nullable', 'string'],
            'performers' => ['nullable', 'string'],
        ];
    }
}
