<?php

/// This is custom route only for admin routes. All admin routes will be registered in here

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAdminDashboardController;

Route::any('datatable/recentincome', [App\Http\Controllers\Admin\GeneralAdminController::class, 'recentIncomeDatatable'])->name('datatable.recentincome');

// All get methods will be loaded with this route
Route::middleware(['auth','onlyadmin'])->group(function () {

//    Route::any('datatable/recentincome', [App\Http\Controllers\Admin\GeneralAdminController::class, 'recentIncomeDatatable'])->name('datatable.recentincome');

    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard'], function () {
        Route::get('/admin/{pagename}', [CustomAdminDashboardController::class, 'loadDynamicView'])->where('pagename', '.*');
    });
});
