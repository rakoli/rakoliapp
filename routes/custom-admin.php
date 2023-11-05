<?php

/// This is custom route only for admin routes. All admin routes will be registered in here

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAdminDashboardController;

// All get methods will be loaded with this route
Route::middleware(['auth','onlyadmin'])->group(function () {

    //Business
    Route::group(['prefix' => 'business', 'route' => 'business.'], function () {

        Route::get('listbusiness', [App\Http\Controllers\Admin\BusinessController::class, 'listbusiness'])->name('business.listbusiness');
        Route::get('listusers', [App\Http\Controllers\Admin\BusinessController::class, 'listusers'])->name('business.listusers');

    });

});
