<?php

/// This is custom route only for admin routes. All admin routes will be registered in here

use Illuminate\Support\Facades\Route;

// All get methods will be loaded with this route
Route::name('admin.')->prefix('admin')->middleware(['auth', 'onlyadmin'])->group(function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard'); //For Middleware testing and having a special user type dashboard route

    //BUSINESS MODDULE
    Route::group(['prefix' => 'business', 'route' => 'business.'], function () {

        Route::get('listbusiness', [App\Http\Controllers\Admin\BusinessController::class, 'listbusiness'])->name('business.listbusiness');
        Route::get('listusers', [App\Http\Controllers\Admin\BusinessController::class, 'listusers'])->name('business.listusers');

    });
    //END: EXCHANGE MODULE

    //EXCHANGE MODULE
    Route::name('exchange.')->prefix('exchange')->group(function () {

        Route::get('ads', [App\Http\Controllers\Admin\AdminExchangeController::class, 'ads'])->name('ads');
        Route::get('posts/edit/{id}', [App\Http\Controllers\Admin\AdminExchangeController::class, 'postsEdit'])->name('posts.edit');
        Route::post('posts/edit/submit', [App\Http\Controllers\Admin\AdminExchangeController::class, 'postsEditSubmit'])->name('posts.edit.submit');
        Route::get('posts/create/townlist', [App\Http\Controllers\Agent\ExchangeController::class, 'postsCreateTownlistAjax'])->name('post.townlistAjax');
        Route::get('posts/create/arealist', [App\Http\Controllers\Agent\ExchangeController::class, 'postsCreateArealistAjax'])->name('post.arealistAjax');

        Route::get('transactions', [App\Http\Controllers\Admin\AdminExchangeController::class, 'transactions'])->name('transactions');
        Route::get('transactions/view/{id}', [App\Http\Controllers\Admin\AdminExchangeController::class, 'transactionsView'])->name('transactions.view');
        Route::get('transactions/receive/message', [App\Http\Controllers\Admin\AdminExchangeController::class, 'transactionsReceiveMessage'])->name('transactions.receive.message');
        Route::post('transactions/action', [App\Http\Controllers\Admin\AdminExchangeController::class, 'transactionsAction'])->name('transactions.action');
    });
    //END: EXCHANGE MODULE

});
