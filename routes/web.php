<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\DiagnosisController;

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

Route::post(
    '/example',
    [ExampleController::class,
    'store']
)->name('example.store');
Route::get(
    '/example',
    [ExampleController::class, 
    'fetch']
    )->name('example.fetch');
Route::get('/doctor', function () {
    return view('doctor');
});
Route::get('/create',  [DiagnosisController::class,
'create']
);
