<?php

/// This is custom route only for agent routes. All agent routes will be registered in here

use App\Http\Controllers\Agent\Shift\TillController;
use App\Http\Controllers\Agent\Shift\TransactionsController;
use Illuminate\Support\Facades\Route;

// All get methods will be loaded with this route
Route::middleware(['auth','should_complete_registration','onlyagent'])->group(function () {

    //Agency
    Route::group(['prefix' => 'agency', 'route' => 'agency.'], function () {

        Route::get('transactions', TransactionsController::class)->name('agency.transactions');


        // shift groups

        Route::prefix('shift')->group(function () {
            Route::get('/', [App\Http\Controllers\Agent\AgencyController::class, 'shift'])->name('agency.shift');
            Route::get('{shift}/tills', [TillController::class, 'index'])->name('agency.shift.till');

        });
        Route::get('tills', [App\Http\Controllers\Agent\AgencyController::class, 'tills'])->name('agency.tills');
        Route::get('networks', [App\Http\Controllers\Agent\AgencyController::class, 'networks'])->name('agency.networks');
        Route::get('loans', [App\Http\Controllers\Agent\AgencyController::class, 'loans'])->name('agency.loans');

    });


});
