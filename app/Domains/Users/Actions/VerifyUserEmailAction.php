<?php

namespace App\Domains\Users\Actions;

use App\Domains\Users\Models\User;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

class VerifyUserEmailAction
{
    use AsAction;

    public function handle(User $user, string $hash): JsonResponse
    {
        if (!hash_equals($hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification url.'], 400);
        }

        $user->markEmailAsVerified();

        return response()->json(['message' => 'Email verified.']);
    }
}
