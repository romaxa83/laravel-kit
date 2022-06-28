<?php

namespace App\Http\Resources\V1\User;

use App\Http\Resources\BaseResource;
use App\Models\User\User;

class UserResource extends BaseResource
{
    public function toArray($request): array
    {
        /** @var User $model */
        $model = $this;

        return [
            'id' => $model->id,
            'name' => $model->name,
            'email' => $model->email->getValue(),
            'created' => $model->created_at->format($this->dateFormat),
            'updated' => $model->updated_at->format($this->dateFormat)
        ];
    }
}

