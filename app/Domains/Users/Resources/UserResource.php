<?php

namespace App\Domains\Users\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'is_admin' => $this->is_admin,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'full_name' => $this->full_name,
            'email' => $this->email,
        ];
    }
}
