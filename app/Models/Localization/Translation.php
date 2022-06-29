<?php

namespace App\Models\Localization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $place
 * @property string|null $key
 * @property string $text
 * @property string $lang
 * @property string|null $entity_type
 * @property int|null $entity_id
 * @property string|null $group
 */

class Translation extends Model
{
    use HasFactory;

    public $timestamps = false;

    const TABLE = 'translations';
    protected $table = self::TABLE;

    const PLACE_APP = 'app';
    const PLACE_SYS = 'sys';

//    public static function getLanguage(): array
//    {
//        return app(LanguageRepository::class)->getForSelect();
//    }
//
//    public static function defaultLang(): ?string
//    {
//        return app(LanguageRepository::class)->getDefault()->slug ?? null;
//    }
//
//    public static function checkLanguage($lang): bool
//    {
//        return array_key_exists($lang, self::getLanguage());
//    }
//
//    public static function assetLanguage($lang): void
//    {
//        if(!self::checkLanguage($lang)){
//            throw new \Exception(__('message.language_not_exists',['lang' => $lang]));
//        }
//    }

    public function entity()
    {
        return $this->morphTo();
    }
}
