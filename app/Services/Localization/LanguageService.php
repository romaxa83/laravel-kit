<?php

namespace App\Services\Localization;

use App\DTO\Localization\LanguageDto;
use App\Models\Localization\Language;

class LanguageService
{
    public function create(LanguageDto $dto): Language
    {
        $model = new Language();
        $model->name = $dto->name;
        $model->native = $dto->native;
        $model->slug = $dto->slug;
        $model->locale = $dto->locale;
        $model->default = $dto->default;
        $model->active = $dto->active;

        $model->save();

        return $model;
    }
}
