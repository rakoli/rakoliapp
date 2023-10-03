<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

// Default routes
Auth::routes();


Route::get('/', function () {
    return view('auth.login');
});

// This route is used for language
Route::post('/change-language', [LanguageController::class, 'changeLanguage']);

// This route is necessary because we want to create custom session keys
Route::post('/authenticate', [AuthController::class, 'loginattempty']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// All get methods will be loaded with this route
Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard'], function () {

        Route::get('/', function () {
            return view('admin/home');
        });

        Route::get('/admin/{pagename}', [DashboardController::class, 'loadDynamicView'])->where('pagename', '.*');
    });
});
