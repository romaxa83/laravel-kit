<?php

namespace App\DTO\Localization;

use App\Models\Localization\Translation;

class TranslationDtos
{
    private $dtos = [];

    private function __construct()
    {}

    public static function byRequestFromApp(array $data): self
    {
        $self = new self();

        foreach ($data as $key => $datum){
            foreach ($datum as $lang => $text){
                $self->dtos[] = TranslationDto::byArgs([
                    "place" => Translation::PLACE_APP,
                    "lang" => $lang,
                    "key" => $key,
                    "text" => $text,
                ]);
            }
        }

        return $self;
    }

    public function getDtos(): array
    {
        return $this->dtos;
    }
}



