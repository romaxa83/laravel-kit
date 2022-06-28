<?php

namespace App\ModelFilters\Localization;

use EloquentFilter\ModelFilter;

class LanguageFilter extends ModelFilter
{
    public function id($value): self
    {
        if(is_array($value)){
            return $this->whereIn('id', $value);
        }

        return $this->where('id', $value);
    }

    public function name($value): self
    {
        return $this->where('name', 'like', $value . '%');
    }

    public function slug($value): self
    {
        if(is_array($value)){
            return $this->whereIn('slug', $value);
        }
        return $this->where('slug', $value);
    }

    public function locale($value): self
    {
        if(is_array($value)){
            return $this->whereIn('locale', $value);
        }
        return $this->where('locale', $value);
    }

    public function active($value): self
    {
        return $this->where('active', $value);
    }

    public function default($value): self
    {
        return $this->where('default', $value);
    }
}
