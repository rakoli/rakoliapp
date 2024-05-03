<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::any('dpo/callback', [App\Http\Controllers\PaymentProcessingController::class, 'dpoCallback'])->name('dpo.callback');
Route::any('pesapal/callback', [App\Http\Controllers\PaymentProcessingController::class, 'pesapalCallback'])->name('pesapal.callback');

Route::post('login', [App\Http\Controllers\Api\MobileAppController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [App\Http\Controllers\Api\MobileAppController::class, 'logout'])->name('logout');

});



