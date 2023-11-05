<?php

/// This is custom route only for agent routes. All agent routes will be registered in here

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAgentDashboardController;

// All get methods will be loaded with this route
Route::middleware(['auth','onlyagent'])->group(function () {

    //Agency
    Route::group(['prefix' => 'agency', 'route' => 'agency.'], function () {
        Route::get('transactions', [App\Http\Controllers\TestController::class, 'testing'])->name('agency.transactions');

    });

    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard'], function () {

        Route::get('/agent/{pagename}', [CustomAgentDashboardController::class, 'loadDynamicView'])->where('pagename', '.*');
    });
});
