<?php

namespace App\Services\Common;

use App\Models\Common\Hash;
use App\Models\Localization\Translation;
use App\Repositories\Localization\TranslationRepository;

class HashService
{
    public function hashing(string $key): string
    {
        if($key == Hash::KEY_APP_TRANSLATION){
            return Hash::generate(
                resolve(TranslationRepository::class)->getForHash([Translation::PLACE_APP])
            );
        }
    }

    public function setHash(string $key): string
    {
        $hash = $this->hashing($key);

        Hash::updateOrCreate(
            ["key" => $key],
            ["hash" => $hash],
        );

        return $hash;
    }
}

