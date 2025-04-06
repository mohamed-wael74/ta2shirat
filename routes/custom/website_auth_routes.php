<?php

use App\Http\Controllers\Website\WebsiteAuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'website.',
    'middleware' => [
        'auth:api'
    ]
], function () {
    Route::post('change-password', [WebsiteAuthController::class, 'changePassword']);
    Route::post('verify-email', [WebsiteAuthController::class, 'verifyEmail']);
    Route::post('signout', [WebsiteAuthController::class, 'signout']);
});

Route::post('signup', [WebsiteAuthController::class, 'signup']);
Route::post('signin', [WebsiteAuthController::class, 'signin']);