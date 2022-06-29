<?php

namespace Database\Factories\Localization;

use App\Models\Localization\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationFactory extends Factory
{
    protected $model = Translation::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->word(15),
            'text' => $this->faker->sentence,
            'lang' => 'en',
            'place' => Translation::PLACE_APP,
        ];
    }
}
