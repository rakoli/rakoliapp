<?php

/// This is custom route only for agent routes. All agent routes will be registered in here

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAgentDashboardController;

// All get methods will be loaded with this route
Route::middleware(['auth','should_complete_registration','onlyagent'])->group(function () {

    //Agency
    Route::group(['prefix' => 'agency', 'route' => 'agency.'], function () {

        Route::get('transactions', [App\Http\Controllers\Agent\AgencyController::class, 'transactions'])->name('agency.transactions');
        Route::get('shift', [App\Http\Controllers\Agent\AgencyController::class, 'shift'])->name('agency.shift');
        Route::get('tills', [App\Http\Controllers\Agent\AgencyController::class, 'tills'])->name('agency.tills');
        Route::get('networks', [App\Http\Controllers\Agent\AgencyController::class, 'networks'])->name('agency.networks');
        Route::get('loans', [App\Http\Controllers\Agent\AgencyController::class, 'loans'])->name('agency.loans');

    });


});
