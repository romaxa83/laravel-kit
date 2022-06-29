<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string key
 * @property string hash
 */
class Hash extends Model
{
    public $timestamps = false;

    const TABLE = 'hashes';
    protected $table = self::TABLE;

    const KEY_APP_TRANSLATION = 'translation.app';

    protected $fillable = [
        'key',
        'hash',
    ];

    public static function generate(array|string $data): string
    {
        if(is_string($data) || is_numeric($data)){
            return md5($data);
        }

        return md5(json_encode($data));
    }
}

