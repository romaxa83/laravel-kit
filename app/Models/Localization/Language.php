<?php

namespace App\Models\Localization;

use App\ModelFilters\Localization\LanguageFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $native
 * @property string $slug
 * @property string $locale
 * @property boolean $default
 * @property boolean $active
 */

class Language extends Model
{
    use HasFactory;
    use Filterable;

    public $timestamps = false;

    const TABLE = 'languages';
    protected $table = self::TABLE;

    protected $casts = [
        'active' => 'boolean',
        'default' => 'boolean',
    ];

    public function modelFilter()
    {
        return $this->provideFilter(LanguageFilter::class);
    }
}

