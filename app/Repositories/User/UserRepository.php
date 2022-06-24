<?php

namespace App\Repositories\User;

use App\Models\User\User;
use App\Repositories\AbstractEloquentRepository;

class UserRepository extends AbstractEloquentRepository
{
    protected function modelClass(): string
    {
        return User::class;
    }
}
