<?php

namespace App\Repositories\Localization;

use App\DTO\Localization\TranslationDto;
use App\Models\Localization\Translation;
use App\Repositories\AbstractEloquentRepository;
use Illuminate\Support\Collection;

class TranslationRepository extends AbstractEloquentRepository
{
    protected function modelClass(): string
    {
        return Translation::class;
    }

    public function getForHash(array $place): Collection
    {
        return $this->query()
            ->select(['text', 'lang'])
            ->whereIn('place', $place)
            ->toBase()
            ->get();
    }

    public function getForApp(array|string $lang = null, array|string $key = null): Collection
    {
        $q = $this->query()
            ->select(['text', 'key', 'lang'])
            ->where('place', Translation::PLACE_APP);

        if($lang){
            if(is_array($lang)){
                $q->whereIn('lang', $lang);
            } else {
                $q->where('lang', $lang);
            }
        }
        if($key){
            if(is_array($key)){
                $q->whereIn('key', $key);
            } else {
                $q->where('key', $key);
            }
        }

        return $q->toBase()->get();
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
