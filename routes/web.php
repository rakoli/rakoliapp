<?php

// This is general route for general purpose route registration

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LanguageController;

Route::get('testing', [\App\Http\Controllers\TestController::class, 'testing']);

//BASIC ROUTES
Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard')->middleware(['should_complete_registration']);
Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['should_complete_registration']);
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

//REGISTRATION ROUTES
Route::get('register/vas', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register.vas');
Route::post('register/vas/submit', [App\Http\Controllers\Auth\RegisterVasController::class, 'register'])->name('register.vas.submit');
Route::get('registration/agent', [App\Http\Controllers\RegistrationStepController::class, 'registrationAgent'])->name('registration.agent');
Route::get('registration/vas', [App\Http\Controllers\RegistrationStepController::class, 'registrationVas'])->name('registration.vas');

//LANGUAGE SWITCHER
Route::get('lang/switch', [LanguageController::class, 'languageSwitch'])->name('languageSwitch');

//USERTYPE SPECIFIC ROUTES
include('custom-admin.php');
include('custom-agent.php');
include('custom-vas.php');
