<?php

namespace App\Repositories;

use App\Traits\ActiveTrait;
use App\Traits\PresenceTrait;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

abstract class AbstractEloquentRepository
{
    use PresenceTrait;

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

    public function getBy(
        $field,
        $value,
        bool $throwException = false,
        string $messageException = "",
    )
    {
        $q = $this->query()->where($field, $value)->first();

        if($throwException && $q == null){
            if(!$messageException && "" == $messageException){
                $messageException = "Model [{$this->modelClass()}] not found by [{$field} = {$value}]";
            }
            throw new \DomainException($messageException, Response::HTTP_NOT_FOUND);
        }

        return $q;
    }

    public function all(
        array $relations = [],
        array $filters = [],
        array $orders = [],
    ): Collection
    {
        $q = $this->query()
            ->with($relations)
        ;

        if($this->checkPresenceTrait($this->modelClass(), Filterable::class)){
            $q->filter($filters);
        }

        if(!empty($orders)){
            foreach ($orders as $field => $type) {
                $q->orderBy($field, $type);
            }
        }

        return $q->get();
    }

    public function forSelect(
        string $field,
        string $key,
    ): \Illuminate\Support\Collection
    {
        $q = $this->query();

        if($this->checkPresenceTrait($this->modelClass(), ActiveTrait::class)){
            $q->active();
        }

        return $q->toBase()->get()->pluck($field, $key);
    }
}

