<?php

namespace App\Domains\Users\Actions;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Lorisleiva\Actions\Concerns\AsAction;

use function sha1;

class CustomizeEmailVerificationNotificationAction
{
    use AsAction;

    public function handle(): void
    {
        VerifyEmail::createUrlUsing(function ($notifiable) {
            $frontendUrl = config('app.frontend_url');
            $hash = sha1($notifiable->getEmailForVerification());

            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(config('auth.verification.expire', 60)),
                [
                    'user' => $notifiable->getKey(),
                    'hash' => $hash,
                ],
                false,
            );

            $urlParts = parse_url($verificationUrl);
            parse_str($urlParts['query'], $queryParams);

            return "$frontendUrl/verify-email?".http_build_query([
                'user' => $notifiable->getKey(),
                'hash' => $hash,
                'expires' => $queryParams['expires'],
                'signature' => $queryParams['signature'],
            ]);
        });
    }
}
