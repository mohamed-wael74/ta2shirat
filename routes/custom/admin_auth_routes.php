<?php

use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'admin.',
    'prefix' => 'admin-panel',
    'middleware' => [
        'auth:api'
    ]
], function () {
    Route::post('signout', [AdminAuthController::class, 'signout'])->name('signout');
});

Route::group([
    'as' => 'admin.',
    'prefix' => 'admin-panel',
], function () {
    Route::post('signin', [AdminAuthController::class, 'signin'])->name('signin');
});

