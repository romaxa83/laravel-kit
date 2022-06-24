<?php

namespace Tests\Unit\DTO\User;

use App\DTO\User\UserDto;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\TestCase;

class UserDtoTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function success(): void
    {
        $data = self::data();
        $dto = UserDto::byArgs($data);

        $this->assertEquals($dto->name, data_get($data, 'name'));
        $this->assertEquals($dto->email, data_get($data, 'email'));
        $this->assertEquals($dto->password, data_get($data, 'password'));
    }

//    /** @test */
//    public function success_empty(): void
//    {
//        $data = self::data();
//        $dto = UserDto::byArgs([]);
//
//        dd($dto);
//
//        $this->assertEquals($dto->name, data_get($data, 'name'));
//        $this->assertEquals($dto->email, data_get($data, 'email'));
//        $this->assertEquals($dto->password, data_get($data, 'password'));
//    }

    public static function data(): array
    {
        return [
            'name' => 'test',
            'email' => 'user@gmail.com',
            'password' => 'password',
        ];
    }
}

