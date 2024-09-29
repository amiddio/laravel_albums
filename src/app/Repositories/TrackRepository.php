<?php

namespace App\Repositories;

use App\Models\Track;

class TrackRepository extends BaseRepository
{
    
    protected function getModelClass(): string
    {
        return Track::class;
    }
}
