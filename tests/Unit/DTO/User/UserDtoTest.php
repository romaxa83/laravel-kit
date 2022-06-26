<?php

namespace Tests\Unit\DTO\User;

use App\DTO\User\UserDto;
use App\ValueObjects\Email;
use App\ValueObjects\Password;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserDtoTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function success(): void
    {
        $data = self::data();
        $dto = UserDto::byArgs($data);

        $this->assertEquals($dto->name, data_get($data, 'name'));

        $this->assertTrue($dto->email instanceof Email);
        $this->assertEquals($dto->email, data_get($data, 'email'));

        $this->assertTrue($dto->password instanceof Password);
        $this->assertEquals($dto->password, data_get($data, 'password'));
        $this->assertNotEquals($dto->password->getHash(), data_get($data, 'password'));
        $this->assertTrue(password_verify(data_get($data, 'password'), $dto->password->getHash()));
        $this->assertFalse(password_verify(data_get($data, 'password'), $dto->password));
    }

    /** @test */
    public function success_only_required_field(): void
    {
        $data = self::data();
        unset($data['password']);

        $dto = UserDto::byArgs($data);

        $this->assertEquals($dto->name, data_get($data, 'name'));
        $this->assertEquals($dto->email, data_get($data, 'email'));

        $this->assertNotNull($dto->password);
        $this->assertEquals($dto->password, Password::DEFAULT);
    }

    public static function data(): array
    {
        return [
            'name' => 'test',
            'email' => 'user@gmail.com',
            'password' => 'password',
        ];
    }
}

