<?php

namespace App\Http\Resources;

use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    protected string $dateFormat;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->dateFormat = config('api.format_date');
    }
}

