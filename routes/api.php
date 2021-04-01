<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ClinicsController;
use App\Http\Controllers\VaccinesController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\PetsController;
use App\Http\Controllers\SpecialitiesController;
use App\Http\Controllers\VaccinationsController;
use App\Http\Controllers\ConsultationsController;
use App\Http\Controllers\DatesController;
use App\Models\Specialities;
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
    Route::get('employees', [EmployeesController::class, 'index']);
    Route::get('userClients',[ClientsController::class, 'getAuthenticatedUser']);
    

});



    Route::get('/employees/{id}', [EmployeesController::class, 'show']);
    Route::delete('/employees/{id}', [EmployeesController::class, 'delete']);
    Route::put('/employees/{id}', [EmployeesController::class, 'update']);

//specialitiesRoute
Route::get('specialities', [SpecialitiesController::class, 'index']);

//Clients
Route::post('registerClients', [ClientsController::class, 'clientsregister']);
Route::post('loginClients', [ClientsController::class, 'authenticate']);
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
Route::get('/vaccinations/pet/{pet_id}', [VaccinationsController::class, 'showByPet']);
Route::get('/vaccinations/{id}', [VaccinationsController::class, 'showById']);
Route::post('/vaccinations', [VaccinationsController::class, 'store']);
Route::put('/vaccinations/{vaccination_id}', [VaccinationsController::class, 'update']);

//Consultation
Route::get('/pets/{petId}/consultations', [ConsultationsController::class, 'index']);
Route::post('/pets/{petId}/consultations', [ConsultationsController::class, 'store']);

//Dates
Route::get('/dates', [DatesController::class, 'index']);
Route::get('/dates/{id}', [DatesController::class, 'show']);
Route::get('/dates/pets/{petId}', [DatesController::class, 'showByPetId']);
Route::get('/dates/employees/{employeeId}', [DatesController::class, 'showByEmployeeId']);
Route::post('/dates', [DatesController::class, 'store']);
Route::delete('/dates/{id}', [DatesController::class, 'destroy']);