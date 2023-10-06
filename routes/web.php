<?php

// This is general route for general purpose route registration

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

include('custom-admin.php');
include('custom-agent.php');
include('custom-vas.php');
