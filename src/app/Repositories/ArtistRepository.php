<?php

namespace App\Repositories;

use App\Models\Artist;

class ArtistRepository extends BaseRepository
{

    const PER_PAGE = 5;

    public function paginate($perPage = self::PER_PAGE)
    {
        $columns = ['id', 'name'];

        return $this->instance()
            ->orderBy('name')
            ->paginate($perPage, $columns);
    }

    protected function getModelClass(): string
    {
        return Artist::class;
    }
}
