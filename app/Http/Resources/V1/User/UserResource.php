<?php

namespace App\Http\Resources\V1\User;

use App\Http\Resources\BaseResource;
use App\Models\User\User;

class UserResource extends BaseResource
{
    public function toArray($request): array
    {
        /** @var User $user */
        $user = $this;
//        $format =
//dd($user->email);
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email->getValue(),
            'created' => $user->created_at->format($this->dateFormat),
            'updated' => $user->updated_at->format($this->dateFormat)
        ];
    }
}

