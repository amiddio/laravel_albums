<?php

namespace App\Repositories;

use App\Models\ReleaseType;
use Illuminate\Database\Eloquent\Collection;

class ReleaseTypeRepository extends BaseRepository
{

    public function getAll(): Collection
    {
        return $this->instance()
            ->orderBy('id', 'asc')
            ->get();
    }

    protected function getModelClass(): string
    {
        return ReleaseType::class;
    }
}
