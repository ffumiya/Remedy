<?php

use App\Models\Event;
use Carbon\Carbon;
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
        // return config('role.patient.value');
    });
    Route::resource('/patient', 'PatientController')->only(['show', 'index']);
    Route::resource('/events', 'EventsController')->only(['index', 'store', 'show', 'update', 'destroy']);
});
