<?php

use App\Http\Controllers\Website\WebsiteAuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'website.',
    'middleware' => [
        'auth:api'
    ]
], function () {
    Route::post('change-password', [WebsiteAuthController::class, 'changePassword'])->name('change-password');
    Route::post('verify-email', [WebsiteAuthController::class, 'verifyEmail'])->name('verify-email');
    Route::post('signout', [WebsiteAuthController::class, 'signout'])->name('signout');
});

Route::group([
    'as' => 'website.',
], function () {
    Route::post('signup', [WebsiteAuthController::class, 'signup'])->name('signup');
    Route::post('signin', [WebsiteAuthController::class, 'signin'])->name('signin');
});