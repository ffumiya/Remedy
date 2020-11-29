<?php

use App\Logging\DefaultLogger;
use App\Services\SurveyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

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
    // Route::post('/events/sendSurvey/{event_id}', function ($event_id) {
    //     DefaultLogger::before(__METHOD__);
    //     $result = SurveyService::sendSurvey($event_id);
    //     DefaultLogger::after();
    //     return $result;
    // });
    Route::post('/events/sendSurvey/{event_id}', 'SurveyController@sendSurvey')->name('sendSurvey');
});
