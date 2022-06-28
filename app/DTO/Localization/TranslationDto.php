<?php

namespace App\DTO\Localization;

class TranslationDto
{
    public $place;
    public $key;
    public $text;
    public $lang;
    public $entity_type;
    public $entity_id;
    public $group;

    private function __construct()
    {}

    public static function byArgs(array $args): self
    {
        $self = new self();

        $self->place = $args['place'];
        $self->key = $args['key'] ?? null;
        $self->text = $args['text'];
        $self->lang = $args['lang'];
        $self->entity_id = $args['entity_id'] ?? null;
        $self->entity_type = $args['entity_type'] ?? null;
        $self->group = $args['group'] ?? null;

        return $self;
    }
}

