<?php

use App\Http\Controllers\Website\CountryController;
use App\Http\Controllers\Website\EmploymentTypeController;
use App\Http\Controllers\Website\WebsiteAuthController;
use App\Http\Controllers\Website\UserProfileController;
use App\Http\Controllers\Website\VisaTypeController;
use Illuminate\Support\Facades\Route;


Route::group([
    'as' => 'website.',
    'middleware' => [
        'auth:api'
    ]
], function () {
    Route::get('profile', [UserProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [UserProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group([
    'as' => 'website.'
], function () {
    Route::apiResource('countries', CountryController::class)->only(['index', 'show']);
    Route::apiResource('employment-types', EmploymentTypeController::class)->only(['index', 'show']);
    Route::apiResource('visa-types', VisaTypeController::class)->only(['index', 'show']);
});
