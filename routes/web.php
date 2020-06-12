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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/video', 'Video\VideoController@show')->name('video.show');
});

Route::middleware('can:doctor')->group(function () {
    Route::get('/schedule', 'Schedule\ScheduleController@index')->name('schedule.index');
    Route::resource('/user', 'UserController');
});
