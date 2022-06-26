<?php

namespace Tests\Feature\Api\V1\Auth;

use App\Models\User\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\DatabaseTransactions;;
use Tests\Builder\User\UserBuilder;
use Tests\TestCase;
use Illuminate\Http\Response;
use Tests\Traits\ResponseStructure;

class SignUpTest extends TestCase
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
        $data = static::data();

        $date = CarbonImmutable::now();
        $this->travelTo($date);

        $this->postJson(route('api.v1.sign-up'), $data)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson($this->structureSuccessResponse([
                'name' => data_get($data, 'name'),
                'email' => data_get($data, 'email'),
                'created' => $date->format(config('api.format_date')),
                'updated' => $date->format(config('api.format_date')),
            ]))
        ;

        /** @var $model User */
        $model = User::query()->where('email', data_get($data, 'email'))->first();

        $this->assertTrue(password_verify(data_get($data, 'password'), $model->password));
        $this->assertNull($model->remember_token);
        $this->assertNull($model->email_verified_at);
    }

    /** @test */
    public function validation_unique_email(): void
    {
        $data = static::data();

        $this->userBuilder->setEmail(data_get($data, 'email'))->create();

        $this->postJson(route('api.v1.sign-up'), $data)
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson($this->structureErrorResponse('The email has already been taken.'))
        ;
    }

    /**
     * @test
     * @dataProvider validate_data
     */
    public function validation($data, $msg): void
    {
        $this->postJson(route('api.v1.sign-up'), $data)
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson($this->structureErrorResponse($msg))
        ;
    }

    public function validate_data(): array
    {
        return [
            [
                [
                    "email" => 'test@test.com',
                    "password" => 'password',
                ],
                'The name field is required.'
            ],
            [
                [
                    "name" => 1111,
                    "email" => 'test@test.com',
                    "password" => 'password',
                ],
                'The name must be a string.'
            ],
            [
                [
                    "name" => 'some name',
                    "password" => 'password',
                ],
                'The email field is required.'
            ],
            [
                [
                    "name" => 'some name',
                    "email" => 'test',
                    "password" => 'password',
                ],
                'The email must be a valid email address.'
            ],
            [
                [
                    "name" => 'some name',
                    "email" => 'test@test.com',
                ],
                'The password field is required.'
            ],
            [
                [
                    "name" => 'some name',
                    "email" => 'test@test.com',
                    "password" => 11111,
                ],
                'The password must be a string.'
            ],
        ];
    }

    public static function data()
    {
        return [
            'name' => 'test',
            'email' => 'user@gmail.com',
            'password' => 'password',
        ];
    }
}


