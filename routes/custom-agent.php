<?php

/// This is custom route only for agent routes. All agent routes will be registered in here

use App\Http\Controllers\Agent\Networks\AddNetworkController;
use App\Http\Controllers\Agent\Networks\DeleteNetworkController;
use App\Http\Controllers\Agent\Networks\NetworkController;
use App\Http\Controllers\Agent\Networks\ShowNetworkController;
use App\Http\Controllers\Agent\Networks\UpdateNetworkController;
use App\Http\Controllers\Agent\Shift\CloseShiftController;
use App\Http\Controllers\Agent\Shift\Loans\AddLoanController;
use App\Http\Controllers\Agent\Shift\Loans\LoanController;
use App\Http\Controllers\Agent\Shift\Loans\PayLoanController;
use App\Http\Controllers\Agent\Shift\Loans\ShowLoanController;
use App\Http\Controllers\Agent\Shift\OpenShiftController;
use App\Http\Controllers\Agent\Shift\ShowShiftController;
use App\Http\Controllers\Agent\Shift\ShowShiftLoanController;
use App\Http\Controllers\Agent\Shift\TillController;
use App\Http\Controllers\Agent\Shift\Transaction\AddExpenseTransactionController;
use App\Http\Controllers\Agent\Shift\Transaction\AddIncomeTransactionController;
use App\Http\Controllers\Agent\Shift\Transaction\AddTransactionController;
use App\Http\Controllers\Agent\Transaction\TransactionsController;
use Illuminate\Support\Facades\Route;

// All get methods will be loaded with this route
Route::middleware(['auth', 'should_complete_registration', 'onlyagent'])->group(function () {

    //Agency
    Route::group(['prefix' => 'agency', 'route' => 'agency.'], function () {

        Route::get('transactions', TransactionsController::class)->name('agency.transactions');


        // shift groups

        Route::prefix('shift')->group(function () {
            Route::get('/', [\App\Http\Controllers\Agent\Shift\AgencyController::class, 'shift'])->name('agency.shift');
            Route::get('/open', [OpenShiftController::class , 'index'])->name('agency.shift.open.index');
            Route::post('/open', [OpenShiftController::class , 'store'])->name('agency.shift.open.store');
            Route::get('/{shift}/close', [CloseShiftController::class, 'index'])->name('agency.shift.close');
            Route::post('/close/store', [CloseShiftController::class, 'store'])->name('agency.shift.close.store');
            Route::get('/{shift}/show', ShowShiftController::class)->name('agency.shift.show');
            Route::get('{shift}/tills', [TillController::class, 'index'])->name('agency.shift.till');
            Route::get('{shift}/loans', ShowShiftLoanController::class)->name('agency.shift.show.loans');
            Route::post('/{shift}/loans/store', AddLoanController::class)->name('agency.loans.store');
            Route::prefix('/{shift}/loans')->group(function () {
                Route::get('/{loan}/', ShowLoanController::class)->name('agency.loans.show');
                Route::post('/{loan}/', PayLoanController::class)->name('agency.loans.pay');
            });
            Route::prefix('transactions/{shift}')->group(function () {
                Route::post('add-transaction', AddTransactionController::class)->name('agency.transactions.add.transaction');
                Route::post('add-expense', AddExpenseTransactionController::class)->name('agency.transactions.add.expense');
                Route::post('add-income', AddIncomeTransactionController::class)->name('agency.transactions.add.income');
            });


        });



        Route::prefix('networks')->group(function () {
            Route::get('/', NetworkController::class)->name('agency.networks');
            Route::post('/', AddNetworkController::class)->name('agency.networks.store');
            Route::get('{network}/show', ShowNetworkController::class)->name('agency.networks.show');
            Route::patch('{network}/', UpdateNetworkController::class)->name('agency.networks.update');
            Route::delete('{network}/', DeleteNetworkController::class)->name('agency.networks.delete');

        });

        Route::prefix('tills')->group(function () {
            Route::get('/', [\App\Http\Controllers\Agent\Shift\AgencyController::class, 'tills'])->name('agency.tills');

        });

    });

    //EXCHANGE MODULE
    Route::name('exchange.')->prefix('exchange')->middleware('lastseen_update')->group(function () {

        Route::get('ads', [App\Http\Controllers\Agent\ExchangeController::class, 'ads'])->name('ads');
        Route::get('ads/view/{id}', [App\Http\Controllers\Agent\ExchangeController::class, 'adsView'])->name('ads.view');
        Route::post('ads/open/order', [App\Http\Controllers\Agent\ExchangeController::class, 'adsOpenOrder'])->name('ads.openorder');

        Route::get('transactions', [App\Http\Controllers\Agent\ExchangeController::class, 'transactions'])->name('transactions');
        Route::get('transactions/view/{id}', [App\Http\Controllers\Agent\ExchangeController::class, 'transactionsView'])->name('transactions.view');
        Route::get('transactions/receive/message', [App\Http\Controllers\Agent\ExchangeController::class, 'transactionsReceiveMessage'])->name('transactions.receive.message');
        Route::post('transactions/action', [App\Http\Controllers\Agent\ExchangeController::class, 'transactionsAction'])->name('transactions.action');
        Route::post('transactions/feedback/action', [App\Http\Controllers\Agent\ExchangeController::class, 'transactionsFeedbackAction'])->name('transactions.feedback.action');

        Route::get('posts', [App\Http\Controllers\Agent\ExchangeController::class, 'posts'])->name('posts');
        Route::get('posts/create', [App\Http\Controllers\Agent\ExchangeController::class, 'postsCreate'])->name('posts.create');
        Route::get('posts/edit/{id}', [App\Http\Controllers\Agent\ExchangeController::class, 'postsEdit'])->name('posts.edit');
        Route::get('posts/delete/{id}', [App\Http\Controllers\Agent\ExchangeController::class, 'postsDelete'])->name('posts.delete');
        Route::post('posts/create/submit', [App\Http\Controllers\Agent\ExchangeController::class, 'postsCreateSubmit'])->name('posts.create.submit');
        Route::post('posts/edit/submit', [App\Http\Controllers\Agent\ExchangeController::class, 'postsEditSubmit'])->name('posts.edit.submit');
        Route::get('posts/create/townlist', [App\Http\Controllers\Agent\ExchangeController::class, 'postsCreateTownlistAjax'])->name('post.townlistAjax');
        Route::get('posts/create/arealist', [App\Http\Controllers\Agent\ExchangeController::class, 'postsCreateArealistAjax'])->name('post.arealistAjax');

        Route::get('methods', [App\Http\Controllers\Agent\ExchangeController::class, 'methods'])->name('methods');
        Route::post('methods.add', [App\Http\Controllers\Agent\ExchangeController::class, 'methodsAdd'])->name('methods.add');
        Route::post('methods.edit', [App\Http\Controllers\Agent\ExchangeController::class, 'methodsEdit'])->name('methods.edit');
        Route::post('methods.delete', [App\Http\Controllers\Agent\ExchangeController::class, 'methodsDelete'])->name('methods.delete');

    });
    //END: EXCHANGE MODULE

});
