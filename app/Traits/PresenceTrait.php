<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

// проверяет наличие трейта в классе
trait PresenceTrait
{
    protected function checkPresenceTrait(string $modelClass, string $trait): bool
    {
        return in_array(
            $trait,
            array_keys((new \ReflectionClass($modelClass))->getTraits())
        );
    }
}
