<?php

namespace App\Services\Localization;

use App\DTO\Localization\TranslationDto;
use App\DTO\Localization\TranslationDtos;
use App\Models\Localization\Translation;
use App\Repositories\Localization\TranslationRepository;

class TranslationService
{
    public function __construct(protected TranslationRepository $repo)
    {}

    public function create(TranslationDto $dto): Translation
    {
        $model = new Translation();
        $model->place = $dto->place;
        $model->key = $dto->key;
        $model->text = $dto->text;
        $model->lang = $dto->lang;
        $model->entity_type = $dto->entity_type;
        $model->entity_id = $dto->entity_id;
        $model->group = $dto->group;

        $model->save();

        return $model;
    }

    public function update(Translation $model, TranslationDto $dto): Translation
    {
        $model->text = $dto->text;

        $model->save();

        return $model;
    }

    public function saveOrUpdate(TranslationDtos $dtos)
    {
        foreach ($dtos->getDtos() as $dto){
            /** @var $model Translation */
            /** @var $dto TranslationDto */
            if($model = $this->repo->getByKeyAndLangAndPlace($dto)) {
                $this->update($model, $dto);
            } else {
                $this->create($dto);
            }
        }
    }
}
