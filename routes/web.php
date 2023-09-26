<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/sign-up', function () {
    return view('signup');
});
Route::get('/password-reset', function () {
    return view('passwordreset');
});


Route::post('/change-language', [LanguageController::class, 'changeLanguage']);

Route::post('/auth-action', [AuthController::class, 'login']);

Route::get('/auth', [LanguageController::class, 'page']);

Route::get('/logout', [AuthController::class, 'logout']);

Route::group(['prefix'=>'dashboard','as'=>'dashboard.'], function(){

     

    Route::get('/', function () {
        return view('pages/home');
    });
    Route::get('connect', ['as' => 'connect', 'uses' => 'AccountController@connect']);


});