<?php

namespace App\Repositories\Common;

use App\Models\Common\Hash;
use App\Repositories\AbstractEloquentRepository;

class HashRepository extends AbstractEloquentRepository
{
    protected function modelClass(): string
    {
        return Hash::class;
    }

    public function getDataHorHashing(string $key)
    {
        dd($ket);
    }
}
