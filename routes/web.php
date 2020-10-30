<?php

use Illuminate\Support\Facades\Auth;
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

const INDEX = 'index';
const CREATE = 'create';
const STORE = 'store';
const SHOW = 'show';
const UPDATE = 'update';
const DESTROY = 'destroy';

// 公開ページ
Route::get('/', function () {
    return view('welcome');
});
Route::resource('survey', 'SurveyController')->only([CREATE, STORE]);
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    // 一般ユーザー
    Route::resource('home', 'HomeController')->only(INDEX);

    // 医師ユーザー
    Route::middleware('can:doctor')->group(function () {
        Route::resource('survey', 'SurveyController')->only([INDEX, SHOW, UPDATE,]);
    });
});
