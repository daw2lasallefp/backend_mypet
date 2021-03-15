<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ClinicsController;
use App\Http\Controllers\VaccinesController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();


});
//Clients
Route::post('/register', [ClientsController::class, 'register']);
Route::post('/login', [ClientsController::class, 'login']);

//Vaccines
Route::get('/vaccines', [VaccinesController::class, 'index']);
    Route::get('/vaccines/{id}', [VaccinesController::class, 'show']);
    Route::post('/vaccines', [VaccinesController::class, 'store']);
    Route::put('/vaccines/{id}', [VaccinesController::class, 'update']);

//Clinics
Route::get('/clinics', [ClinicsController::class, 'index']);
Route::get('/clinics/{id}', [ClinicsController::class, 'show']);
