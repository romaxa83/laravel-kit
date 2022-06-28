<?php

namespace App\Repositories\Localization;

use App\Models\Localization\Translation;
use App\Repositories\AbstractEloquentRepository;

class TranslationRepository extends AbstractEloquentRepository
{
    protected function modelClass(): string
    {
        return Translation::class;
    }
}
