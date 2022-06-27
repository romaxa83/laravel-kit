<?php

namespace App\DTO\User;

use App\ValueObjects\Email;
use App\ValueObjects\Password;

class UserDto
{
    public $name;
    public Email $email;
    public Password $password;

    private function __construct()
    {}

    public static function byArgs(array $args): self
    {
        $self = new self();

        $self->name = $args['name'];
        $self->email = new Email($args['email']);
        $self->password = new Password($args['password'] ?? null);

        return $self;
    }
}

