<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

abstract class BaseRepository
{
    private Model $model;

    abstract protected function getModelClass(): string;

    public function __construct()
    {
        $this->model = new ($this->getModelClass());
    }

    public function create(array $data): ?Model
    {
        try {
            return $this->instance()->create($data);
        } catch (QueryException  $exception) {
            Log::error($exception->getMessage());
        }
        return null;
    }

    protected function instance(): Model
    {
        return $this->model;
    }

    public function delete(Model $instance): bool
    {
        try {
            return $instance->delete();
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
        }

        return false;
    }

    public function update(Model $instance, array $data): ?Model
    {
        try {
            return tap($instance, function ($model) use ($data) {
                $model->fill($data);
                $model->save();
            });
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
        }
        return null;
    }

    public function find(int $id): ?Model
    {
        return $this->instance()->find($id);
    }
}
