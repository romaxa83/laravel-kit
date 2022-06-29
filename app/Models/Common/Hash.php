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

    const TABLE = 'languages';
    protected $table = self::TABLE;

    const KEY_APP_TRANSLATION = 'translation.app';

    protected $fillable = [
        'key',
        'hash',
    ];
}

