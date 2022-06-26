<?php

namespace App\Services\User;

use App\DTO\User\UserDto;
use App\Models\User\User;

class UserService
{
    public function create(UserDto $dto): User
    {
        $model = new User();
        $model->name = $dto->name;
        $model->email = $dto->email;
        $model->password = $dto->password->getHash();

        $model->save();

        return $model;
    }
}
