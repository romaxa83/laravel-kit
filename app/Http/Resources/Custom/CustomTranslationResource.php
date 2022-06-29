<?php

namespace App\Http\Resources\Custom;

use App\Repositories\Localization\LanguageRepository;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(type="object", title="Custom Translate Resource",
 *     @OA\Property(property="lang_1", type="object",
 *         @OA\Property(property="key_1", type="string", example="value_1",
 *             description="ключ - алиас перевода, значение - перевод для этой локали"
 *         ),
 *         @OA\Property(property="key_2", type="string", example="value_2",
 *             description="ключ - алиас перевода, значение - перевод для этой локали"
 *         ),
 *          @OA\Property(property="key_n", type="string", example="value_n",
 *             description="ключ - алиас перевода, значение - перевод для этой локали"
 *         ),
 *     ),
 *     @OA\Property(property="lang_2", type="object",
 *         @OA\Property(property="key_1", type="string", example="value_1",
 *             description="ключ - алиас перевода, значение - перевод для этой локали"
 *         ),
 *         @OA\Property(property="key_2", type="string", example="value_2",
 *             description="ключ - алиас перевода, значение - перевод для этой локали"
 *         ),
 *          @OA\Property(property="key_n", type="string", example="value_n",
 *             description="ключ - алиас перевода, значение - перевод для этой локали"
 *         ),
 *     ),
 * )
 */
class CustomTranslationResource
{
    private $list = [];

    public function fill(Collection $data)
    {
        $langs = app(LanguageRepository::class)->forSelect('name', 'slug');

        if($data->isNotEmpty()){
            foreach ($data as $item){
                if($langs->has($item->lang)){
                    $this->list[$item->lang][$item->key] = $item->text;
                }
            }
        }

        return $this->list;
    }
}
