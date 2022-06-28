<?php

namespace App\Http\Resources\Swagger;

use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(type="object", title="Отрицательный ответ",
 *     @OA\Property(property="data", title="Data", example="somethinng wrong",
 *         description="Возвращает текст ошибки"),
 *     @OA\Property(property="success", title="Success", example=false,
 *         description="Возвращает false"),
 * )
 */
class ErrorResponse
{
}
