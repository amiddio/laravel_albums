<?php

namespace App\Repositories;

use App\Models\ReleaseType;
use Illuminate\Database\Eloquent\Collection;

class ReleaseTypeRepository extends BaseRepository
{

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->instance()
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return ReleaseType::class;
    }
}
