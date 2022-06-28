<?php

namespace Tests\Unit\DTO\Localization;

use App\DTO\Localization\TranslationDto;
use App\DTO\Localization\TranslationDtos;
use App\Models\Localization\Translation;
use Tests\TestCase;

class TranslationDtosTest extends TestCase
{
    /** @test */
    public function success(): void
    {
        $data = [
            "button" => [
                "en" => "button en"
            ]
        ];
        $dto = TranslationDtos::byRequestFromApp($data);

        $this->assertCount(1, $dto->getDtos());
        $this->assertTrue($dto->getDtos()[0] instanceof TranslationDto);
        $this->assertEquals($dto->getDtos()[0]->place, Translation::PLACE_APP);
        $this->assertEquals($dto->getDtos()[0]->lang, "en");
        $this->assertEquals($dto->getDtos()[0]->key, "button");
        $this->assertEquals($dto->getDtos()[0]->text, $data["button"]["en"]);
        $this->assertNull($dto->getDtos()[0]->entity_type);
        $this->assertNull($dto->getDtos()[0]->entity_id);
        $this->assertNull($dto->getDtos()[0]->group);
    }

    /** @test */
    public function success_few_row(): void
    {
        $data = self::data();
        $dto = TranslationDtos::byRequestFromApp($data);

        $this->assertCount(4, $dto->getDtos());
        foreach ($dto->getDtos() as $dto){
            $this->assertTrue($dto instanceof TranslationDto);
            $this->assertEquals($dto->text, $data[$dto->key][$dto->lang]);
        }
    }

    /** @test */
    public function success_empty(): void
    {
        $dto = TranslationDtos::byRequestFromApp([]);

        $this->assertEmpty($dto->getDtos());
    }

    public static function data(): array
    {
        return [
            "button" => [
                "en" => "button en",
                "ua" => "button ua"
            ],
            "text" => [
                "en" => "text en",
                "ua" => "text ua"
            ]
        ];
    }
}
