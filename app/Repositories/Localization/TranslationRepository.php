<?php

namespace App\Repositories\Localization;

use App\DTO\Localization\TranslationDto;
use App\Models\Localization\Translation;
use App\Repositories\AbstractEloquentRepository;

class TranslationRepository extends AbstractEloquentRepository
{
    protected function modelClass(): string
    {
        return Translation::class;
    }

    public function getByKeyAndLangAndPlace(TranslationDto $dto)
    {
        return $this->query()
            ->where([
                ['place', $dto->place],
                ['lang', $dto->lang],
                ['key', $dto->key]
            ])
            ->first();
    }

}
