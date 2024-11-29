<?php

use App\Domains\Users\Actions\GetAuthenticatedUserAction;
use App\Domains\Users\Actions\LoginUserAction;
use App\Domains\Users\Actions\RegisterUserAction;
use App\Domains\Users\Actions\VerifyUserEmailAction;
use Illuminate\Support\Facades\Route;

Route::get('/verify/{user}/{hash}', VerifyUserEmailAction::class)->middleware('signed:relative')->name('verification.verify');
Route::post('/register', RegisterUserAction::class);
Route::post('/login', LoginUserAction::class);
Route::get('/user', GetAuthenticatedUserAction::class)->middleware('auth:sanctum');
