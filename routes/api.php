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
Route::any('selcom/callback', [App\Http\Controllers\PaymentProcessingController::class, 'selcomCallback'])->name('selcom.callback');

// Referrer API Routes
Route::post('referrals/login', [\App\Http\Controllers\Api\ReferrerAPIController::class, 'singleSignOn']);
Route::middleware('auth:sanctum')->group(function () {
Route::get('referrals', [\App\Http\Controllers\Api\ReferrerAPIController::class, 'getReferrals']);
Route::get('referrals/shift', [\App\Http\Controllers\Api\ReferrerAPIController::class, 'referredBusinessShiftActivities']);
Route::get('referrals/businesses', [\App\Http\Controllers\Api\ReferrerAPIController::class, 'getReferredBusinesses']);
Route::get('referrals/payments', [\App\Http\Controllers\Api\ReferrerAPIController::class, 'referrerPayments']);
Route::get('referrals/payment-history', [\App\Http\Controllers\Api\ReferrerAPIController::class, 'getPaymentHistory']);
Route::post('referrals/mark-paid', [\App\Http\Controllers\Api\ReferrerAPIController::class, 'markPaymentsAsPaid']);
Route::post('referrals/create-payment', [\App\Http\Controllers\Api\ReferrerAPIController::class, 'createReferrerPayment']);
Route::get('referrals/all-payments', [\App\Http\Controllers\Api\ReferrerAPIController::class, 'getAllReferrerPayments']);
});
Route::post('login', [App\Http\Controllers\Api\MobileAppController::class, 'login']);
Route::post('register', [App\Http\Controllers\Api\MobileAppController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [App\Http\Controllers\Api\MobileAppController::class, 'logout']);

    Route::get('request/email/code', [App\Http\Controllers\RegistrationStepController::class, 'requestEmailCodeAjax']);
    Route::get('verify/email/code', [App\Http\Controllers\RegistrationStepController::class, 'verifyEmailCodeAjax']);
    Route::get('request/phone/code', [App\Http\Controllers\RegistrationStepController::class, 'requestPhoneCodeAjax']);
    Route::get('verify/phone/code', [App\Http\Controllers\RegistrationStepController::class, 'verifyPhoneCodeAjax']);
    Route::post('edit/contact/information', [App\Http\Controllers\RegistrationStepController::class, 'editContactInformation']);
    Route::get('update/business/details', [App\Http\Controllers\RegistrationStepController::class, 'updateBusinessDetails']);
    Route::get('registration/step/confirmation', [App\Http\Controllers\RegistrationStepController::class, 'registrationStepConfirmation']);
    Route::get('registration/step/status', [App\Http\Controllers\Api\MobileAppController::class, 'registrationStepStatus']);
    Route::get('subscription/details', [App\Http\Controllers\Api\MobileAppController::class, 'subscriptionDetails']);
    Route::post('subscription/pay', [App\Http\Controllers\RegistrationStepController::class, 'paySubscription']);

    Route::get('dashboard/data', [App\Http\Controllers\HomeController::class, 'index']);
    Route::post('changepassword/submit', [App\Http\Controllers\HomeController::class, 'changepasswordSubmit']);
    Route::post('profile/submit', [App\Http\Controllers\HomeController::class, 'profileSubmit']);

    //AGENCY MODULE
    Route::get('agency/transactions', App\Http\Controllers\Agent\Transaction\TransactionsController::class);
    Route::get('agency/shifts', [\App\Http\Controllers\Agent\Shift\AgencyController::class, 'shift']);
    Route::get('agency/networks', App\Http\Controllers\Agent\Networks\NetworkController::class);
    Route::get('agency/loans', [\App\Http\Controllers\Agent\Shift\Loans\LoanController::class, 'index']);


});



