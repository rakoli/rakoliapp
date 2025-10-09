<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShiftAPIController;

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
Route::post('verify-otp', [App\Http\Controllers\Api\MobileAppController::class, 'verifyOtp']);
Route::post('resend-otp', [App\Http\Controllers\Api\MobileAppController::class, 'resendOtp']);

// PIN Reset routes (public - no auth required)
Route::post('pin-reset/request', [App\Http\Controllers\Api\MobileAppController::class, 'requestPinReset']);
Route::post('pin-reset/verify-otp', [App\Http\Controllers\Api\MobileAppController::class, 'verifyPinResetOtp']);
Route::post('pin-reset/reset', [App\Http\Controllers\Api\MobileAppController::class, 'resetPin']);

// Form submission routes
Route::post('form', [App\Http\Controllers\Api\FormAPIController::class, 'store']);
Route::get('form', [App\Http\Controllers\Api\FormAPIController::class, 'index']);
Route::get('form/{id}', [App\Http\Controllers\Api\FormAPIController::class, 'show']);
Route::get('form/gps/coordinates', [App\Http\Controllers\Api\FormAPIController::class, 'getGpsCoordinates']);

Route::middleware(['auth:sanctum'])->group(function () {

    // Mock Transaction API Routes (authentication required)
    Route::get('mock/transactions', [\App\Http\Controllers\Api\MockTransactionAPIController::class, 'index']);
    Route::get('mock/transactions/recent', [\App\Http\Controllers\Api\MockTransactionAPIController::class, 'recent']);
    Route::get('shifts/{shiftId}/transactions', [\App\Http\Controllers\Api\MockTransactionAPIController::class, 'shiftTransactions']);

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

    //NETWORK MODULE
    Route::prefix('networks')->group(function () {
        // Core network operations
        Route::get('/', [\App\Http\Controllers\Api\NetworkAPIController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\NetworkAPIController::class, 'store']);
        Route::get('/{code}', [\App\Http\Controllers\Api\NetworkAPIController::class, 'show']);
        Route::put('/{code}', [\App\Http\Controllers\Api\NetworkAPIController::class, 'update']);
        Route::delete('/{code}', [\App\Http\Controllers\Api\NetworkAPIController::class, 'destroy']);

        // Helper endpoints for network creation
        Route::get('/data/locations', [\App\Http\Controllers\Api\NetworkAPIController::class, 'locations']);
        Route::get('/data/fsps', [\App\Http\Controllers\Api\NetworkAPIController::class, 'financialServiceProviders']);
        Route::get('/data/cryptos', [\App\Http\Controllers\Api\NetworkAPIController::class, 'cryptos']);
        Route::get('/data/types', [\App\Http\Controllers\Api\NetworkAPIController::class, 'types']);
    });

    //SHIFT MODULE
    Route::prefix('shifts')->group(function () {
        // Core shift operations
        Route::get('/', [ShiftAPIController::class, 'index']);
        Route::post('/', [ShiftAPIController::class, 'store']);
        Route::get('/current', [ShiftAPIController::class, 'current']);
        Route::get('/locations', [ShiftAPIController::class, 'locations']);
        Route::get('/{id}', [ShiftAPIController::class, 'show']);
        Route::put('/{id}', [ShiftAPIController::class, 'update']);
        Route::delete('/{id}', [ShiftAPIController::class, 'destroy']);

        // Transaction operations
        Route::post('/{id}/income', [ShiftAPIController::class, 'addIncome']);
        Route::post('/{id}/expense', [ShiftAPIController::class, 'addExpense']);
        Route::post('/{id}/transaction', [ShiftAPIController::class, 'addTransaction']);
        Route::post('/{id}/transfer', [ShiftAPIController::class, 'transferBalance']);
        Route::get('/{id}/transactions', [ShiftAPIController::class, 'transactions']);

        // Loan operations
        Route::post('/{id}/loans', [ShiftAPIController::class, 'addLoan']);
        Route::get('/{id}/loans', [ShiftAPIController::class, 'loans']);
        Route::post('/{shiftId}/loans/{loanId}/pay', [ShiftAPIController::class, 'payLoan']);

        // Other shift data
        Route::get('/{id}/tills', [ShiftAPIController::class, 'tills']);
    });

    //BRANCH MODULE
    Route::prefix('branches')->group(function () {
        // Core branch operations
        Route::get('/', [\App\Http\Controllers\Api\BranchAPIController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\BranchAPIController::class, 'store']);
        Route::get('/{id}', [\App\Http\Controllers\Api\BranchAPIController::class, 'show']);
        Route::put('/{id}', [\App\Http\Controllers\Api\BranchAPIController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\Api\BranchAPIController::class, 'destroy']);

        // Helper endpoints for branch creation
        Route::get('/data/regions', [\App\Http\Controllers\Api\BranchAPIController::class, 'regions']);
        Route::get('/data/towns', [\App\Http\Controllers\Api\BranchAPIController::class, 'towns']);
        Route::get('/data/areas', [\App\Http\Controllers\Api\BranchAPIController::class, 'areas']);
    });

    //USERS MODULE
    Route::prefix('users')->group(function () {
        // Core user operations
        Route::get('/', [\App\Http\Controllers\Api\UsersAPIController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\UsersAPIController::class, 'store']);
        Route::get('/{id}', [\App\Http\Controllers\Api\UsersAPIController::class, 'show']);
        Route::put('/{id}', [\App\Http\Controllers\Api\UsersAPIController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\Api\UsersAPIController::class, 'destroy']);

        // Helper endpoints for user creation
        Route::get('/data/form', [\App\Http\Controllers\Api\UsersAPIController::class, 'getFormData']);
    });

    //BUSINESS PROFILE MODULE
    Route::prefix('business/profile')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\BusinessPofileAPI::class, 'show']);
        Route::put('/', [\App\Http\Controllers\Api\BusinessPofileAPI::class, 'update']);
        Route::post('/update', [\App\Http\Controllers\Api\BusinessPofileAPI::class, 'update']);
    });


});



