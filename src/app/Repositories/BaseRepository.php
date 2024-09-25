<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    private Model $model;

    public function __construct()
    {
        $this->model = new ($this->getModelClass());
    }

    /**
     * @return string
     */
    abstract protected function getModelClass(): string;

    /**
     * @return Model
     */
    protected function instance(): Model
    {
        return $this->model;
    }
}
