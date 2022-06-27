<?php

namespace App\Http\Resources\V1\Localization;

use App\Http\Resources\BaseResource;
use App\Models\Localization\Language;

class LanguageResource extends BaseResource
{
    public function toArray($request): array
    {
        /** @var Language $model */
        $model = $this;

        return [
            'id' => $model->id,
            'name' => $model->name,
            'native' => $model->native,
            'slug' => $model->slug,
            'locale' => $model->locale,
            'default' => $model->default,
            'active' => $model->active,
        ];
    }
}

