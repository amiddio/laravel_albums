<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'albumId' => $this->album_id,
            'disc' => $this->disc,
            'number' => $this->number,
            'title' => $this->title,
            'duration' => $this->duration,
            'composers' => $this->whenNotNull($this->composers),
            'performers' => $this->whenNotNull($this->performers),
        ];
    }
}
