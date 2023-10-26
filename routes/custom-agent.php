<?php

/// This is custom route only for agent routes. All agecnt routes will be registered in here

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAgentDashboardController;

// All get methods will be loaded with this route
Route::middleware(['auth','onlyagent'])->group(function () {
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard'], function () {

        Route::get('/', function () {
            return view('dashboard/home');
        });
        Route::get('/agent/{pagename}', [CustomAgentDashboardController::class, 'loadDynamicView'])->where('pagename', '.*');
    });
});
