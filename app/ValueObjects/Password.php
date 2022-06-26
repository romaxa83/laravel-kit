<?php

namespace App\ValueObjects;

use Illuminate\Support\Facades\Hash;

final class Password
{
    public const DEFAULT = 'password';

    private string $value;

    public function __construct(null|string $value)
    {
        $this->value = $value ?? self::DEFAULT;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function getHash(): string
    {
        return Hash::make($this->value);
    }
}
