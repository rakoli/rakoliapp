<?php

/// This is custom route only for vas routes. All vas routes will be registered in here

use Illuminate\Support\Facades\Route;

// All get methods will be loaded with this route
Route::name('vas.')->prefix('vas')->middleware(['auth','should_complete_registration','onlyvas'])->group(function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard'); //For Middleware testing and having a special user type dashboard route

    //Services
    Route::group(['prefix' => 'services', 'route' => 'services.'], function () {

        Route::get('advertisement', [App\Http\Controllers\Vas\ServiceController::class, 'advertisement'])->name('services.advertisement');
        Route::get('data', [App\Http\Controllers\Vas\ServiceController::class, 'data'])->name('services.data');
        Route::get('sales', [App\Http\Controllers\Vas\ServiceController::class, 'sales'])->name('services.sales');
        Route::get('verification', [App\Http\Controllers\Vas\ServiceController::class, 'verification'])->name('services.verification');
        Route::get('manage', [App\Http\Controllers\Vas\ServiceController::class, 'manage'])->name('services.manage');

    });

    //Tasks
    Route::resource('tasks',App\Http\Controllers\Vas\TasksController::class);

});
