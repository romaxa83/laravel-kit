<?php

namespace Tests\Unit\DTO\Localization;

use App\DTO\Localization\LanguageDto;
use App\DTO\Localization\TranslationDto;
use Tests\TestCase;

class TranslationDtoTest extends TestCase
{
    /** @test */
    public function success(): void
    {
        $data = self::data();
        $dto = TranslationDto::byArgs($data);

        $this->assertEquals($dto->place, data_get($data, 'place'));
        $this->assertEquals($dto->key, data_get($data, 'key'));
        $this->assertEquals($dto->text, data_get($data, 'text'));
        $this->assertEquals($dto->lang, data_get($data, 'lang'));
        $this->assertEquals($dto->entity_type, data_get($data, 'entity_type'));
        $this->assertEquals($dto->entity_id, data_get($data, 'entity_id'));
        $this->assertEquals($dto->group, data_get($data, 'group'));
    }

    /** @test */
    public function only_required_field(): void
    {
        $data = self::data();
        unset(
            $data['key'],
            $data['entity_id'],
            $data['entity_type'],
            $data['group'],
        );
        $dto = TranslationDto::byArgs($data);

        $this->assertEquals($dto->place, data_get($data, 'place'));
        $this->assertEquals($dto->text, data_get($data, 'text'));
        $this->assertEquals($dto->lang, data_get($data, 'lang'));
        $this->assertNull($dto->key);
        $this->assertNull($dto->entity_type);
        $this->assertNull($dto->entity_id);
        $this->assertNull($dto->group);
    }

    public static function data(): array
    {
        return [
            'place' => 'some place',
            'key' => 'some key',
            'text' => 'some text',
            'lang' => 'some lang',
            'entity_type' => 'some entity type',
            'entity_id' => 'some entity id',
            'group' => 'some group',
        ];
    }
}



