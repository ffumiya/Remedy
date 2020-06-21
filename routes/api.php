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

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/role/{id}', function (Request $request) {
        // return $request->user()->role;
        return 10;
    });
    Route::resource('/patient', 'API\PatientController')->only(['show']);
    Route::resource('/events', 'API\EventsController')->only(['store', 'show', 'update', 'destroy']);
    Route::resource('/reservation', 'API\ReservationController')->only(['show']);
});
