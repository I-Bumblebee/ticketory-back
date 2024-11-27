<?php

namespace App\Domains\Users\Jobs;

use App\Domains\Users\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class SendEmailVerificationNotificationJob
{
    use AsAction;

    public function asJob(User $user): void
    {
        $user->sendEmailVerificationNotification();
    }
}
