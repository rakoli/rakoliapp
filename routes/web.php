<?php

// This is general route for general purpose route registration

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AuthController;

Route::get('testing', [\App\Http\Controllers\TestController::class, 'testing']);

//BASIC ROUTES
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::post('/authenticate', [AuthController::class, 'loginattempty']); // This route is necessary because we want to create custom session keys


//REGISTRATION ROUTES
Route::get('registration/complete', [App\Http\Controllers\HomeController::class, 'registrationComplete'])->name('registration.complete');


//LANGUAGE SWITCHER
Route::post('/change-language', [LanguageController::class, 'changeLanguage']);


//USERTYPE SPECIFIC ROUTES
include('custom-admin.php');
include('custom-agent.php');
include('custom-vas.php');
