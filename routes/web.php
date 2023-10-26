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
Route::get('register/vas', [App\Http\Controllers\Auth\RegisterAgentController::class, 'showRegistrationForm'])->name('register.vas');
Route::post('register/vas/submit', [App\Http\Controllers\Auth\RegisterAgentController::class, 'register'])->name('register.vas.submit');
Route::get('registration/agent', [App\Http\Controllers\HomeController::class, 'registrationAgent'])->name('registration.agent');
Route::get('registration/vas', [App\Http\Controllers\HomeController::class, 'registrationVas'])->name('registration.vas');


//LANGUAGE SWITCHER
Route::post('/change-language', [LanguageController::class, 'changeLanguage']);


//USERTYPE SPECIFIC ROUTES
include('custom-admin.php');
include('custom-agent.php');
include('custom-vas.php');
