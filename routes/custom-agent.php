<?php

/// This is custom route only for agent routes. All agent routes will be registered in here

use Illuminate\Support\Facades\Route;

// All get methods will be loaded with this route
Route::middleware(['auth', 'should_complete_registration', 'onlyagent'])->group(function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('agent.dashboard'); //For Middleware testing and having a special user type dashboard route

    //AGENCY MODULE
    Route::name('agency.')->prefix('agency')->group(function () {

        Route::get('transactions', [App\Http\Controllers\Agent\AgencyController::class, 'transactions'])->name('transactions');
        Route::get('shift', [App\Http\Controllers\Agent\AgencyController::class, 'shift'])->name('shift');
        Route::get('tills', [App\Http\Controllers\Agent\AgencyController::class, 'tills'])->name('tills');
        Route::get('networks', [App\Http\Controllers\Agent\AgencyController::class, 'networks'])->name('networks');
        Route::get('loans', [App\Http\Controllers\Agent\AgencyController::class, 'loans'])->name('loans');
        Route::get('testing', [App\Http\Controllers\Agent\AgencyController::class, 'loans'])->name('tests');

    });
    //END: AGENCY MODULE

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

    //Task
    Route::get('tasks/{type?}',[App\Http\Controllers\Agent\TasksController::class, 'index'])->name('agent.tasks');
    Route::get('task/view/{id}',[App\Http\Controllers\Agent\TasksController::class, 'show'])->name('agent.task.show');
    Route::post('task/apply',[App\Http\Controllers\Agent\TasksController::class, 'apply'])->name('agent.task.apply');

    //Contracts
    Route::resource('contracts',App\Http\Controllers\Agent\ContractsController::class);
    Route::get('contracts/receive/message', [App\Http\Controllers\Agent\ContractsController::class, 'contractsReceiveMessage'])->name('contracts.receive.message');

    //Contract Submission
    Route::resource('contracts.submissions',App\Http\Controllers\Agent\ContractSubmissionsController::class);
    Route::post('contracts/{contract}/submissions/upload',[App\Http\Controllers\Agent\ContractSubmissionsController::class, 'fileUpload'])->name('contracts.submissions.upload');

  //BUSINESS MANAGEMENT MODULE
    Route::name('business.')->prefix('business')->middleware('lastseen_update')->group(function () {
        Route::get('role', [App\Http\Controllers\Agent\BusinessController::class, 'roles'])->name('role');
        Route::post('roles/add', [App\Http\Controllers\Agent\BusinessController::class, 'rolesAdd'])->name('roles.add');
        Route::post('roles/edit', [App\Http\Controllers\Agent\BusinessController::class, 'rolesEdit'])->name('roles.edit');
        Route::post('roles/delete', [App\Http\Controllers\Agent\BusinessController::class, 'rolesDelete'])->name('roles.delete');

        Route::get('finance', [App\Http\Controllers\Agent\PaymentController::class, 'finance'])->name('finance');
        Route::post('finance/withdrawmethod/update', [App\Http\Controllers\Agent\PaymentController::class, 'withdrawmethodUpdate'])->name('finance.withdrawmethod.update');
        Route::post('finance/withdraw', [App\Http\Controllers\Agent\PaymentController::class, 'financeWithdraw'])->name('finance.withdraw');
        Route::post('finance/check_method', [App\Http\Controllers\Agent\PaymentController::class, 'checkMethod'])->name('finance.check_method');

        Route::get('profile/update', [App\Http\Controllers\Agent\BusinessController::class, 'profileCreate'])->name('profile.update');
        Route::post('profile/update', [App\Http\Controllers\Agent\BusinessController::class, 'profileUpdate'])->name('profile.update.submit');

        Route::get('subscription', [App\Http\Controllers\Agent\SubscriptionController::class, 'subscription'])->name('subscription');
        Route::get('subscription_buy', [App\Http\Controllers\Agent\SubscriptionController::class, 'subscriptionBuy'])->name('subscription.buy');


        Route::get('branches', [App\Http\Controllers\Agent\BusinessController::class, 'branches'])->name('branches');
        Route::get('branches/create', [App\Http\Controllers\Agent\BusinessController::class, 'branchesCreate'])->name('branches.create');
        Route::get('branches/edit/{id}', [App\Http\Controllers\Agent\BusinessController::class, 'branchesEdit'])->name('branches.edit');
        Route::get('branches/delete/{id}', [App\Http\Controllers\Agent\BusinessController::class, 'branchesDelete'])->name('branches.delete');
        Route::post('branches/create/submit', [App\Http\Controllers\Agent\BusinessController::class, 'branchesCreateSubmit'])->name('branches.create.submit');
        Route::post('branches/edit/submit', [App\Http\Controllers\Agent\BusinessController::class, 'branchesEditSubmit'])->name('branches.edit.submit');
        Route::get('branches/create/townlist', [App\Http\Controllers\Agent\BusinessController::class, 'branchesCreateTownlistAjax'])->name('branches.townlistAjax');
        Route::get('branches/create/arealist', [App\Http\Controllers\Agent\BusinessController::class, 'branchesCreateArealistAjax'])->name('branches.arealistAjax');



        Route::get('users', [App\Http\Controllers\Agent\BusinessController::class, 'users'])->name('users');
        Route::get('users/create', [App\Http\Controllers\Agent\BusinessController::class, 'usersCreate'])->name('users.create');
        Route::post('users/create/submit', [App\Http\Controllers\Agent\BusinessController::class, 'usersCreateSubmit'])->name('users.create.submit');
        Route::get('users/edit/{id}', [App\Http\Controllers\Agent\BusinessController::class, 'usersEdit'])->name('users.edit');
        Route::post('users/edit/submit', [App\Http\Controllers\Agent\BusinessController::class, 'usersEditSubmit'])->name('users.edit.submit');
        Route::get('users/delete/{id}', [App\Http\Controllers\Agent\BusinessController::class, 'usersDelete'])->name('users.delete');

        Route::get('referrals',[App\Http\Controllers\Agent\BusinessController::class,'referrals'])->name('referrals');
        Route::post('referrals.referr', [App\Http\Controllers\Agent\BusinessController::class, 'referr'])->name('referrals.referr');
    });
    //END: BUSINESS MANAGEMENT MODULE
});
