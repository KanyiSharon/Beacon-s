<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-appointments', [FetchAppointments::class, 'getAppointments']);
Route::post('/api/reschedule', [RescheduleController::class, 'reschedule']);
Route::get('/calendar-content', function () {
    return view('calendar');
})->name('calendar.content');


