<?php

use App\Domains\Users\Actions\VerifyUserEmailAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/verify/{user}/{hash}', VerifyUserEmailAction::class)->middleware('signed:relative')->name('verification.verify');
