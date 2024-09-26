<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtistResource extends JsonResource
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
            'genres' => $this->when(!$request->routeIs('artists.index'), $this->genres),
            'decades' => $this->when(!$request->routeIs('artists.index'), $this->decades),
            'created' => $this->when(!$request->routeIs('artists.index'), Carbon::parse($this->created_at)->format('Y-m-d H:i:s')),
            'updated' => $this->when(!$request->routeIs('artists.index'), Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')),
        ];
    }
}
