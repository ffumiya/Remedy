<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->namespace('API')->group(function () {
    Route::resource('user', 'UserController')->only(['store']);
    Route::get('/role/{id}', function (Request $request) {
        return $request->user()->role;
    });
    Route::resource('/patient', 'PatientController')->only(['show', 'index']);
    Route::resource('/events', 'EventsController')->only(['index', 'store', 'show', 'update', 'destroy']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('/events/sendSurvey/{event_id}', 'SurveyController@sendSurvey')->name('sendSurvey');
});
