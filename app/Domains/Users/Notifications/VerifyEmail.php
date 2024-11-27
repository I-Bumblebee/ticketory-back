<?php

namespace App\Domains\Users\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends BaseVerifyEmail
{
    protected function verificationUrl($notifiable): string
    {
        $baseUrl = config('app.frontend_url');
        $userId = $notifiable->getKey();
        $hash = sha1($notifiable->getEmailForVerification());

        $temporarySignedUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'user' => $userId,
                'hash' => $hash,
            ],
            false
        );

        $urlComponents = parse_url($temporarySignedUrl);
        parse_str($urlComponents['query'], $params);

        return $baseUrl."/verify-email?user=$userId&hash=$hash&expires={$params['expires']}&signature={$params['signature']}";
    }
}
