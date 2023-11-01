<?php

/// This is custom route only for vas routes. All vas routes will be registered in here

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomVasDashboardController;

// All get methods will be loaded with this route
Route::middleware(['auth','onlyvas'])->group(function () {
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard'], function () {

        Route::get('/vas/{pagename}', [CustomVasDashboardController::class, 'loadDynamicView'])->where('pagename', '.*');
    });
});
