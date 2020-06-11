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

Route::get('/video', 'Video\VideoController@show')->name('video.show');

Route::middleware('can:admin')->group(function () {
    Route::get('/schedule', 'Schedule\ScheduleController@index')->name('schedule.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
