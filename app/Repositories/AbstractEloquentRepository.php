<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractEloquentRepository
{
    public function __construct()
    {}

    abstract protected function modelClass(): string;

    protected function query(): Builder
    {
        return resolve($this->modelClass())::query();
    }

    public function existBy($field, $value): bool
    {
        return $this->query()->where($field, $value)->exists();
    }

    public function getBy($field, $value)
    {
        return $this->query()->where($field, $value)->first();
    }
}

