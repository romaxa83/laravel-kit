<?php

namespace Tests\Unit\Models\Common;

use App\Models\Common\Hash;
use Tests\TestCase;

class HashTest extends TestCase
{
    /** @test */
    public function success_get_hash_as_array(): void
    {
        $data = [
            'key_1' => 'value_1',
            'key_2' => 'value_2',
            'key_3' => 'value_3',
        ];

        $hash = md5(json_encode($data));

        $this->assertEquals($hash, Hash::generate($data));
    }

    /** @test */
    public function success_get_hash_as_string(): void
    {
        $data = 'some_string';

        $hash = md5($data);

        $this->assertEquals($hash, Hash::generate($data));
    }

    /** @test */
    public function success_get_hash_as_int(): void
    {
        $data = 214423423;

        $hash = md5($data);

        $this->assertEquals($hash, Hash::generate($data));
    }
}


