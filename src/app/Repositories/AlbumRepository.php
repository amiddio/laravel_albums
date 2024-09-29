<?php

namespace App\Repositories;

use App\Models\Album;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AlbumRepository extends BaseRepository
{

    public function getAlbumsByArtistAndReleaseType($artistId, $releaseTypeId): Collection
    {
        $columns = ['id', 'title', 'year', 'duration'];

        return $this->instance()
            ->where('artist_id', $artistId)
            ->where('release_type_id', $releaseTypeId)
            ->orderBy('year')
            ->orderBy('id')
            ->get($columns);
    }

    public function getAlbum(int $id): ?Model
    {
        return $this->instance()
            ->with([
                'releaseType',
                'tracks' => function ($query) {
                    $query->orderBy('number');
                },
                'artist' => function ($query) {
                    $query->select(['id', 'name']);
                },
            ])
            ->where('id', $id)
            ->first();
    }

    protected function getModelClass(): string
    {
        return Album::class;
    }
}
