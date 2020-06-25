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
    Route::resource('payment', 'PaymentController')->only(["show", "update"]);
    Route::get('/home/{any?}', function () {
        return view('home');
    })->where('any', '.+');

    // 医師ユーザー
    Route::middleware('can:doctor')->group(function () {
        Route::get('/schedule', 'Schedule\ScheduleController@index')->name('schedule.index');
        Route::resource('/user', 'UserController');
    });
});
