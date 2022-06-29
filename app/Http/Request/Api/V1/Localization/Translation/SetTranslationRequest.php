<?php

namespace App\Http\Request\Api\V1\Localization\Translation;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(type="object", title="Set Translation Request",
 *     example={
 *          "message::no_access" : {
 *              "en": "access denied",
 *              "ru": "доступ откланен",
 *          },
 *          "button" : {
 *              "en": "button",
 *              "ru": "кнопка",
 *          }
 *      }
 * )
 */

class SetTranslationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}
