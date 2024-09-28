<?php

namespace App\Repositories;

use App\Models\Track;

class TrackRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return Track::class;
    }
}
