<?php

namespace App\Providers;

use App\Domains\Users\Actions\CustomizeEmailVerificationNotificationAction;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        CustomizeEmailVerificationNotificationAction::run();
    }
}
