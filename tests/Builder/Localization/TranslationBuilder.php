<?php

namespace Tests\Builder\Localization;

use App\Models\Localization\Translation;

class TranslationBuilder
{
    private $data = [];

    public function setEntity($model): self
    {
        $temp = [
            'entity_type' => $model::class,
            'entity_id' => $model->id,
        ];
        $this->data = array_merge($this->data, $temp);
        return $this;
    }

    public function setData(array $value): self
    {
        $this->data = array_merge($this->data, $value);
        return $this;
    }

    public function create()
    {
        $model = $this->save();

        $this->clear();

        return $model;
    }

    private function save()
    {
        return Translation::factory()->create($this->data);
    }

    private function clear(): void
    {
        $this->data = [];
    }
}
