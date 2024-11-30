<?php

namespace App\Domains\Users\Actions;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class LogoutUserAction
{
    use AsAction;

    public function handle(): void
    {
        Auth::guard('web')->logout();
    }
}
