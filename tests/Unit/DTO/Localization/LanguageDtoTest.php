<?php

namespace Tests\Unit\DTO\Localization;

use App\DTO\Localization\LanguageDto;
use Tests\TestCase;

class LanguageDtoTest extends TestCase
{
    /** @test */
    public function success(): void
    {
        $data = self::data();
        $dto = LanguageDto::byArgs($data);

        $this->assertEquals($dto->name, data_get($data, 'name'));
        $this->assertEquals($dto->native, data_get($data, 'native'));
        $this->assertEquals($dto->slug, data_get($data, 'slug'));
        $this->assertEquals($dto->locale, data_get($data, 'locale'));
        $this->assertEquals($dto->default, data_get($data, 'default'));
        $this->assertEquals($dto->active, data_get($data, 'active'));
    }

    public static function data(): array
    {
        return [
            'name' => 'English',
            'native' => 'English',
            'slug' => 'en',
            'locale' => 'en_EN',
            'default' => true,
            'active' => true,
        ];
    }
}


