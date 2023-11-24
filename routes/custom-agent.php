<?php

/// This is custom route only for agent routes. All agent routes will be registered in here

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAgentDashboardController;

// All get methods will be loaded with this route
Route::middleware(['auth','should_complete_registration','onlyagent'])->group(function () {

    //AGENCY MODULE
    Route::name('agency.')->prefix('agency')->group(function () {

        Route::get('transactions', [App\Http\Controllers\Agent\AgencyController::class, 'transactions'])->name('transactions');
        Route::get('shift', [App\Http\Controllers\Agent\AgencyController::class, 'shift'])->name('shift');
        Route::get('tills', [App\Http\Controllers\Agent\AgencyController::class, 'tills'])->name('tills');
        Route::get('networks', [App\Http\Controllers\Agent\AgencyController::class, 'networks'])->name('networks');
        Route::get('loans', [App\Http\Controllers\Agent\AgencyController::class, 'loans'])->name('loans');
        Route::get('testing', [App\Http\Controllers\Agent\AgencyController::class, 'loans'])->name('tests');

    });
    //END: AGENCY MODULE

    //EXCHANGE MODULE
    Route::name('exchange.')->prefix('exchange')->group(function () {

        Route::get('ads', [App\Http\Controllers\Agent\ExchangeController::class, 'ads'])->name('ads');
        Route::get('ads/view/{id}', [App\Http\Controllers\Agent\ExchangeController::class, 'adsView'])->name('ads.view');
        Route::post('ads/open/order', [App\Http\Controllers\Agent\ExchangeController::class, 'adsOpenOrder'])->name('ads.openorder');
        Route::get('orders', [App\Http\Controllers\Agent\ExchangeController::class, 'orders'])->name('orders');
        Route::get('orders/view/{id}', [App\Http\Controllers\Agent\ExchangeController::class, 'ordersView'])->name('orders.view');
        Route::get('transactions', [App\Http\Controllers\Agent\ExchangeController::class, 'transactions'])->name('transactions');
        Route::get('posts', [App\Http\Controllers\Agent\ExchangeController::class, 'posts'])->name('posts');
        Route::get('security', [App\Http\Controllers\Agent\ExchangeController::class, 'security'])->name('security');

    });
    //END: EXCHANGE MODULE

});
