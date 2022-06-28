<?php

namespace App\DTO\Localization;

class LanguageDto
{
    public string $name;
    public string $native;
    public string $slug;
    public string $locale;
    public bool $default;
    public bool $active;

    private function __construct()
    {}

    public static function byArgs(array $args): self
    {
        $self = new self();

        $self->name = $args['name'];
        $self->native = $args['native'];
        $self->slug = $args['slug'];
        $self->locale = $args['locale'];
        $self->default = $args['default'];
        $self->active = $args['active'];

        return $self;
    }
}
