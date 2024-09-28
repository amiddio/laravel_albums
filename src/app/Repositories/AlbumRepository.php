<?php

namespace App\Repositories;

use App\Models\Album;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AlbumRepository extends BaseRepository
{

    /**
     * @param $artistId
     * @param $releaseTypeId
     * @return mixed
     */
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

    /**
     * @param int $id
     * @return Model
     */
    public function getAlbum(int $id): Model
    {
        return $this->instance()
            ->with(['releaseType', 'artist' => function ($query) {
                $query->select(['id', 'name']);
            }])
            ->where('id', $id)
            ->first();
    }

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return Album::class;
    }
}
