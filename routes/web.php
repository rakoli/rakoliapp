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
Route::get('profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile')->middleware(['should_complete_registration']);
Route::post('profile/submit', [App\Http\Controllers\HomeController::class, 'profileSubmit'])->name('profile.submit')->middleware(['should_complete_registration']);
Route::get('changepassword', [App\Http\Controllers\HomeController::class, 'changepassword'])->name('changepassword');
Route::post('changepassword/submit', [App\Http\Controllers\HomeController::class, 'changepasswordSubmit'])->name('changepassword.submit');
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

//REGISTRATION ROUTES
Route::get('registration/agent', [App\Http\Controllers\RegistrationStepController::class, 'registrationAgent'])->name('registration.agent');
Route::get('registration/step/confirmation', [App\Http\Controllers\RegistrationStepController::class, 'registrationStepConfirmation'])->name('registration.step.confirmation');
Route::get('request/email/code', [App\Http\Controllers\RegistrationStepController::class, 'requestEmailCodeAjax'])->name('request.email.code');
Route::get('request/phone/code', [App\Http\Controllers\RegistrationStepController::class, 'requestPhoneCodeAjax'])->name('request.phone.code');
Route::get('verify/email/code', [App\Http\Controllers\RegistrationStepController::class, 'verifyEmailCodeAjax'])->name('verify.email.code');
Route::get('verify/phone/code', [App\Http\Controllers\RegistrationStepController::class, 'verifyPhoneCodeAjax'])->name('verify.phone.code');
Route::post('edit/contact/information', [App\Http\Controllers\RegistrationStepController::class, 'editContactInformation'])->name('edit.contact.information');
Route::get('update/business/details', [App\Http\Controllers\RegistrationStepController::class, 'updateBusinessDetails'])->name('update.business.details');
Route::post('pay/subscription', [App\Http\Controllers\RegistrationStepController::class, 'paySubscription'])->name('pay.subscription');
Route::get('pay/test/{reference}', [App\Http\Controllers\PaymentProcessingController::class, 'completePendingTestPayment'])->name('pay.test');

Route::get('register/vas', [App\Http\Controllers\Auth\RegisterVasController::class, 'showRegistrationForm'])->name('register.vas');
Route::post('register/vas/submit', [App\Http\Controllers\Auth\RegisterVasController::class, 'register'])->name('register.vas.submit');
Route::get('registration/vas', [App\Http\Controllers\RegistrationStepController::class, 'registrationVas'])->name('registration.vas');

Route::get('r/{businessCode}', [App\Http\Controllers\Auth\RegisterController::class, 'referral'])->name('referral.link');

//LANGUAGE SWITCHER
Route::get('lang/switch', [LanguageController::class, 'languageSwitch'])->name('languageSwitch');

//Town and Area List
Route::get('towns', [App\Http\Controllers\Controller::class, 'getTown'])->name('get.towns');
Route::get('areas', [App\Http\Controllers\Controller::class, 'getArea'])->name('get.areas');

//USERTYPE SPECIFIC ROUTES
include('custom-admin.php');
include('custom-agent.php');
include('custom-vas.php');
