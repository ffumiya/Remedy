<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 公開ページ
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    // 一般ユーザー
    Route::get('home', 'HomeController@index')->name('home.index');
    Route::resource('payment', 'PaymentController')->only(["show", "update"]);
    Route::post('payment', 'PaymentController@charge')->name('payment.charge');
    Route::resource('video', 'VideoController')->only(['show']);

    // 医師ユーザー
    Route::middleware('can:doctor')->group(function () {
        Route::resource('/user', 'UserController');
    });
});
