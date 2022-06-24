<?php

namespace App\DTO\User;

class UserDto
{
    public $name;
    public $email;
    public $password;

    private function __construct()
    {}

    public static function byArgs(array $args): self
    {
        $self = new self();

        $self->name = $args['name'];
        $self->email = $args['email'];
        $self->password = $args['password'];

        return $self;
    }
}

