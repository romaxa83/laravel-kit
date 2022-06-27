<?php

namespace Tests\Feature\Api\V1\Auth;

use App\Models\User\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Builder\User\UserBuilder;
use Tests\TestCase;
use Illuminate\Http\Response;
use Tests\Traits\ResponseStructure;

class LoginTest extends TestCase
{
    use DatabaseTransactions;
    use ResponseStructure;

    protected $userBuilder;

    public function setUp(): void
    {
        parent::setUp();

        $this->userBuilder = resolve(UserBuilder::class);
    }

    /** @test */
    public function success(): void
    {
        $password = 'password';

        /** @var $user User */
        $user = $this->userBuilder->setPassword($password)->create();

        $this->postJson(route('api.v1.login'), [
            'email' => $user->email->getValue(),
            'password' => $password
        ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure($this->structure())
        ;
    }

    /** @test */
    public function fail_wrong_password(): void
    {
        $password = 'password';

        /** @var $user User */
        $user = $this->userBuilder->setPassword($password)->create();

        $this->postJson(route('api.v1.login'), [
            'email' => $user->email->getValue(),
            'password' => 'wrong_password'
        ])
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson($this->structureErrorResponse(__('message.user_wrong_password')))
        ;
    }

    /** @test */
    public function fail_wrong_login(): void
    {
        $password = 'password';
        $email = 'test@test.com';

        /** @var $user User */
        $this->userBuilder->setEmail($email)->setPassword($password)->create();

        $this->postJson(route('api.v1.login'), [
            'email' => 'test_wrong@test.com',
            'password' => $password
        ])
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson($this->structureErrorResponse(__('message.user_wrong_login')))
        ;
    }
}

