<?php

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\Email;
use Tests\TestCase;

class EmailTest extends TestCase
{
    /** @test */
    public function success(): void
    {
        $email = 'valid.email@example.com';
        $emailObj = new Email($email);

        $this->assertEquals($email, $emailObj);
    }

    /** @test */
    public function success_compare()
    {
        $email1 = new Email('valid.email@example.com');
        $email2 = new Email('valid.email@example.com');

        $this->assertTrue($email1->compare($email2));
    }

    /** @test */
    public function not_compare()
    {
        $email1 = new Email('valid.email1@example.com');
        $email2 = new Email('valid.email2@example.com');

        $this->assertFalse($email1->compare($email2));
    }

    /** @test */
    public function fail_not_valid_email()
    {
        $email = 'not.valid.email@example';

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(__('message.validation.not valid value', [
            'value' => $email,
            'field' => 'email'
        ]));

        $email = new Email('not.valid.email@example');
    }

    /** @test */
    public function fail_wrong_type_when_init()
    {
        $obj = new \stdClass();

        $this->expectException(\TypeError::class);
        $email = new Email($obj);
    }

    /** @test */
    public function fail_wrong_type_when_compare()
    {
        $email = new Email('valid.email1@example.com');
        $obj = new \stdClass();

        $this->expectException(\TypeError::class);

        $email->compare($obj);
    }
}


