<?php

namespace App\Http\Requests;

use App\Models\Artist;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArtistRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique(Artist::class, 'name')->where(function ($query) {
                    return $query->where('name', $this->name)->where('decades', request()->get('decades'));
                })->ignore($this->route('artist')),
            ],
            'genres' => ['nullable', 'string'],
            'decades' => ['nullable', 'string'],
        ];
    }
}
