<?php

namespace Tests\Builder\User;

use App\Models\User\User;
use Illuminate\Support\Facades\Hash;

class UserBuilder
{
    private $data = [];

    public function setPassword($value): self
    {
        $this->data['password'] = Hash::make($value);
        return $this;
    }

    public function setName($value): self
    {
        $this->data['name'] = $value;
        return $this;
    }

    public function setEmail($value): self
    {
        $this->data['email'] = $value;
        return $this;
    }

    public function create()
    {
        $model = $this->save();

        $this->clear();

        return $model;
    }

    private function save()
    {
        return User::factory()->new($this->data)->create();
    }

    private function clear(): void
    {
        $this->data = [];
    }
}

