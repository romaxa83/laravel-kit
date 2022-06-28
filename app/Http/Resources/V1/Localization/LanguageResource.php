<?php

namespace App\Http\Resources\V1\Localization;

use App\Http\Resources\BaseResource;
use App\Models\Localization\Language;

/**
 * @OA\Schema(type="object", title="Language Resource",
 *     @OA\Property(property="id", type="string", description="ID", example=6),
 *     @OA\Property(property="name", type="string", example="English",
 *         description="Название языка на английском"
 *     ),
 *     @OA\Property(property="native", type="string", example="English",
 *         description="Название языка на даном языке"
 *     ),
 *     @OA\Property(property="slug", type="string", example="en",
 *         description="Слаг языка, локаль ISO 639"
 *     ),
 *     @OA\Property(property="locale", type="string", example="en_EN",
 *         description="Локаль языка"
 *     ),
 *     @OA\Property(property="default", type="boolean", description="Являеться ли язык дефолтным для преложения", example=true),
 *     @OA\Property(property="active", type="boolean", description="Активировано/деактивировано", example=true),
 * )
 */

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

