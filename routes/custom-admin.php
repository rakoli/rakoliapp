<?php

/// This is custom route only for admin routes. All admin routes will be registered in here

use Illuminate\Support\Facades\Route;

// All get methods will be loaded with this route
Route::name('admin.')->prefix('admin')->middleware(['auth', 'onlyadmin'])->group(function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard'); //For Middleware testing and having a special user type dashboard route

    //BUSINESS MODDULE
    Route::name('business.')->prefix('business')->group(function () {

        Route::get('listbusiness', [App\Http\Controllers\Admin\BusinessController::class, 'listbusiness'])->name('listbusiness');
        Route::get('resetbusiness/{code}', [App\Http\Controllers\Admin\BusinessController::class, 'resetbusiness'])->name('resetbusiness');

        Route::get('listusers', [App\Http\Controllers\Admin\BusinessController::class, 'listusers'])->name('listusers');
        Route::get('registeringuser', [App\Http\Controllers\Admin\BusinessController::class, 'registeringuser'])->name('registeringuser');

        Route::name('users.')->prefix('users')->group(function () {
            Route::get('sales', [App\Http\Controllers\Admin\BusinessController::class, 'salesUsers'])->name('sales');
            Route::get('create', [App\Http\Controllers\Admin\BusinessController::class, 'CreateUser'])->name('create');
            Route::post('store', [App\Http\Controllers\Admin\BusinessController::class, 'storeUser'])->name('store');
        });

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

    Route::any('system/send-message',[App\Http\Controllers\Admin\SystemController::class, 'SendMessage'])->name('system.send-message');

});
