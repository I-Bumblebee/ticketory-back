<?php

namespace App\Domains\Users\Actions;

use App\Domains\Users\Models\User;
use App\Domains\Users\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class LoginUserAction
{
    use AsAction;

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string'],
        ];
    }

    public function jsonResponse(User $user): UserResource
    {
        return UserResource::make($user);
    }

    /**
     * @throws ValidationException
     */
    public function handle(ActionRequest $request): User
    {
        if (!Auth::attempt($request->validated())) {
            throw ValidationException::withMessages([
                'email' => 'Email or password invalid!',
                'password' => 'Email or password invalid!',
            ]);
        }

        return Auth::user();
    }
}
