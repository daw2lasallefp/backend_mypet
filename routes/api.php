<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ClinicsController;
use App\Http\Controllers\VaccinesController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\PetsController;
use App\Http\Controllers\VaccinationsController;
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
//Employees
Route::post('registerEmployee', [EmployeesController::class, 'register']);
Route::post('loginEmployee', [EmployeesController::class, 'authenticate']);

Route::group(['middleware' => ['jwt.verify']], function() {

    Route::get('employee',[EmployeesController::class, 'getAuthenticatedUser']);
    Route::get('clients',[ClientsController::class, 'getAuthenticatedClients']);

});


Route::get('/employees', [EmployeesController::class, 'index']);
    Route::get('/employees/{id}', [EmployeesController::class, 'show']);
    Route::delete('/employees/{id}', [EmployeesController::class, 'delete']);
    Route::put('/employees/{id}', [EmployeesController::class, 'update']);


//Clients
Route::post('registerClients', [ClientsController::class, 'clientsregister']);
Route::post('loginClients', [ClientsController::class, 'authenticate']);

Route::group(['middleware' => ['jwt.verify']], function() {

    Route::get('userClients',[ClientsController::class, 'getAuthenticatedUser']);

});

Route::post('logoutClients', [ClientsController::class, 'logout']);
Route::get('/clientsList', [ClientsController::class, 'index']);
    Route::get('/clients/{id}', [ClientsController::class, 'show']);
    Route::put('/clients/update/{id}', [ClientsController::class, 'update']);
    Route::delete('/clients/delete/{id}', [ClientsController::class, 'destroy']);


//Vaccines
Route::get('/vaccines', [VaccinesController::class, 'index']);
Route::get('/vaccines/{id}', [VaccinesController::class, 'show']);
Route::post('/vaccines', [VaccinesController::class, 'store']);
Route::put('/vaccines/{id}', [VaccinesController::class, 'update']);

//Clinics
Route::get('/clinics', [ClinicsController::class, 'index']);
Route::get('/clinics/{id}', [ClinicsController::class, 'show']);
Route::put('/clinics/{id}', [ClinicsController::class, 'update']);

//Pets
Route::get('/pets', [PetsController::class, 'index']);
Route::get('/pets/{id}', [PetsController::class, 'show']);
Route::post('/pets', [PetsController::class, 'store']);
Route::put('/pets/{id}', [PetsController::class, 'update']);
Route::delete('/pets/{id}', [PetsController::class, 'delete']);

//Vaccinations
Route::get('/vaccinations', [VaccinationsController::class, 'index']);
Route::get('/vaccinations/{pet_id}', [VaccinationsController::class, 'show']);
Route::put('/vaccinations/{vaccination_id}', [VaccinationsController::class, 'update']);




