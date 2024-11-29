<?php

namespace App\Domains\Users\Actions;

use App\Domains\Users\Resources\UserResource;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAuthenticatedUserAction
{
    use AsAction;

    public function handle(ActionRequest $request): UserResource
    {
        return UserResource::make($request->user());
    }
}
