<?php

namespace Tests;

use App\Models\User\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function loginAsUser(User $user, array $scope = ['*']): User
    {
        Sanctum::actingAs($user, $scope);

        return $user;
    }
}
