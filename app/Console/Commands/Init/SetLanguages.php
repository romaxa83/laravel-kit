<?php

namespace App\Console\Commands\Init;

use App\DTO\Localization\LanguageDto;
use App\Repositories\Localization\LanguageRepository;
use App\Services\Localization\LanguageService;
use Illuminate\Console\Command;

class SetLanguages extends Command
{
    protected $signature = 'app:set-langs';

    protected $description = 'Set languages for app';

    public function handle(
        LanguageRepository $repo,
        LanguageService $service,
    )
    {
        foreach ($this->data() as $item){
            $dto = LanguageDto::byArgs($item);

            if($repo->existBy('slug', $dto->slug)){
                $this->warn("lang [{$dto->name}] exist");
            } else {
                $service->create($dto);
                $this->info("lang [{$dto->name}] set");
            }
        }
    }

    private function data(): array
    {
        return [
            [
                'name' => 'English',
                'native' => 'English',
                'slug' => 'en',
                'locale' => 'en_EN',
                'default' => true,
                'active' => true,
            ],
            [
                'name' => 'Ukrainian',
                'native' => 'Український',
                'slug' => 'ua',
                'locale' => 'uk_UA',
                'default' => false,
                'active' => true,
            ],
            [
                'name' => 'Russian',
                'native' => 'Русский',
                'slug' => 'ru',
                'locale' => 'ru_RU',
                'default' => false,
                'active' => true,
            ],
            [
                'name' => 'Spanish',
                'native' => 'Español',
                'slug' => 'es',
                'locale' => 'es_ES',
                'default' => false,
                'active' => false,
            ],
            [
                'name' => 'Polish',
                'native' => 'Polski',
                'slug' => 'pl',
                'locale' => 'pl_PL',
                'default' => false,
                'active' => false,
            ],
        ];
    }
}
