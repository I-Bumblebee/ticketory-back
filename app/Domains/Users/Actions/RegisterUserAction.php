<?php

namespace App\Domains\Users\Actions;

use App\Domains\Users\Jobs\SendEmailVerificationNotificationJob;
use App\Domains\Users\Models\User;
use App\Domains\Users\Resources\UserResource;
use Illuminate\Validation\Rules\Password;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class RegisterUserAction
{
    use AsAction;

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users,email'],
            'name' => ['required', 'string', 'max:32'],
            'lastname' => ['required', 'string', 'max:32'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->symbols()],
            'password_confirmation' => ['required'],
        ];
    }

    public function jsonResponse(User $user): UserResource
    {
        return UserResource::make($user);
    }

    public function handle(ActionRequest $request): User
    {
        $user = User::create($request->validated());
        SendEmailVerificationNotificationJob::dispatch($user);

        return $user;
    }
}
