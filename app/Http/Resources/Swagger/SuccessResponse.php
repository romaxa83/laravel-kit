<?php

namespace App\Http\Resources\Swagger;

use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(type="object", title="Успешный ответ",
 *     @OA\Property(property="data", title="Data", example="[]",
 *         description="Возвращаемые данные, массив данных или может быть просто строка"),
 *     @OA\Property(property="success", title="Success", example=true,
 *         description="Возвращает true"),
 * )
 */
class SuccessResponse
{
}

