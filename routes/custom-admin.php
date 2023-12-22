<?php

/// This is custom route only for admin routes. All admin routes will be registered in here

use Illuminate\Support\Facades\Route;

// All get methods will be loaded with this route
Route::name('admin.')->prefix('admin')->middleware(['auth','onlyadmin'])->group(function () {

    //BUSINESS MODDULE
    Route::group(['prefix' => 'business', 'route' => 'business.'], function () {

        Route::get('listbusiness', [App\Http\Controllers\Admin\BusinessController::class, 'listbusiness'])->name('business.listbusiness');
        Route::get('listusers', [App\Http\Controllers\Admin\BusinessController::class, 'listusers'])->name('business.listusers');

    });
    //END: EXCHANGE MODULE

    //EXCHANGE MODULE
    Route::name('exchange.')->prefix('exchange')->group(function () {

        Route::get('ads', [App\Http\Controllers\Admin\ExchangeController::class, 'ads'])->name('ads');
        Route::get('transactions', [App\Http\Controllers\Admin\ExchangeController::class, 'transactions'])->name('transactions');
        Route::get('transactions/view/{id}', [App\Http\Controllers\Admin\ExchangeController::class, 'transactionsView'])->name('transactions.view');
        Route::get('transactions/receive/message', [App\Http\Controllers\Admin\ExchangeController::class, 'transactionsReceiveMessage'])->name('transactions.receive.message');
        Route::post('transactions/action', [App\Http\Controllers\Admin\ExchangeController::class, 'transactionsAction'])->name('transactions.action');


    });
    //END: EXCHANGE MODULE

});
