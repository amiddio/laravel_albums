<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'artistId' => $this->whenNotNull($this->artist_id),
            'releaseTypeId' => $this->whenNotNull($this->release_type_id),
            'title' => $this->title,
            'year' => $this->year,
            'duration' => $this->duration,
            'label' => $this->whenNotNull($this->label),
            'genres' => $this->whenNotNull($this->genres),
            'created' => $this->when(
                !$request->routeIs('albums.index'),
                Carbon::parse($this->created_at)->format('Y-m-d H:i:s')
            ),
            'updated' => $this->when(
                !$request->routeIs('albums.index'),
                Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
            ),
            'releaseType' => ReleaseTypeResource::make($this->whenLoaded('releaseType')),
            'artist' => ArtistResource::make($this->whenLoaded('artist')),
            'tracks' => TrackResource::collection($this->whenLoaded('tracks')),
        ];
    }
}
