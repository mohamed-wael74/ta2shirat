<?php

use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\EmploymentTypeController;
use App\Http\Controllers\Admin\PermissionGroupController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Admin\VisaTypeController;
use Illuminate\Support\Facades\Route;


//Auth Routes
Route::group([
    'as' => 'admin.',
    'prefix' => 'admin'
], function () {
    Route::post('signin', [AdminAuthController::class, 'signin'])->name('signin');
});

Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
    'middleware' => ['auth:api']
], function () {
    Route::apiResource('permission-groups', PermissionGroupController::class);
    Route::apiResource('countries', CountryController::class)->only(['index', 'show', 'update']);
    Route::apiResource('employment-types', EmploymentTypeController::class);
    Route::apiResource('users', UserController::class)->except(['destroy']);
    Route::apiResource('visa-types', VisaTypeController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('users.roles', UserRoleController::class)->only(['update', 'destroy']);
    Route::post('signout', [AdminAuthController::class, 'signout'])->name('signout');
});
