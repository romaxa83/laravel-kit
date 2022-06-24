<?php

namespace App\Http\Resources\V1\User;

use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var User $user */
        $user = $this;

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created' => $user->created_at,
            'updated' => $user->updated_at
        ];
    }
}

