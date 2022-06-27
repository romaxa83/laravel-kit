<?php

namespace App\Repositories\Localization;

use App\Models\Localization\Language;
use App\Repositories\AbstractEloquentRepository;

class LanguageRepository extends AbstractEloquentRepository
{
    protected function modelClass(): string
    {
        return Language::class;
    }
}
