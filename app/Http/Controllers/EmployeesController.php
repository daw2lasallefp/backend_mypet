<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\Config;

use Exception;

class EmployeesController extends Controller
{
    function __construct()
    {
        Config::set('jwt.user', Employees::class);
        Config::set('auth.providers', ['users' => [
            'driver' => 'eloquent',
            'model' => Employees::class,
        ]]);
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $employee = Employees::where('email', $request->email)->first();

        if ($employee === null) {
            return response()->json(['error' => 'El empleado no se encuentra en la base de datos.'], 404);
        }
        if ($employee->available === 0) {
            return response()->json(['error' => 'Lo siento, este empleado ha sido dado de baja.'], 404);
        }

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Email y/o contraseña incorrectos'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json($user);
    }


    public function register(Request $request)
    {
        $validatorEmail = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:employees',
        ]);

        $validatorFields = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'password' => 'required|string',
            'admin' => 'required|bool',
            'workShifts' => 'required|string|max:255',
            'specialities' => 'required|numeric',
        ]);

        if ($validatorEmail->fails()) {
            return response()->json(["message" => $validatorEmail], 409);
        }

        if ($validatorFields->fails()) {
            return response()->json(["message" => $validatorFields], 400);
        }
        try{
                $employee = Employees::create([
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'admin' => $request->get('admin'),
            'work_shift' => $request->get('workShifts'),
            'speciality_id' => $request->get('specialities'),
        ]);
        }catch(Exception $e){
            return response()->json(["message" => 'Error interno'], 404);
        }
    

        $token = JWTAuth::fromUser($employee);

        return response()->json($employee, 201);
    }


    public function index(Request $request)
    {
        try {
            if ($request->has('page')) {
                $employees = Employees::where('available', true)->paginate(5);
            } else {
                $employees = Employees::all()->where('available', true);
            }
        } catch (Exception $e) {
            return response()->json(['response_body' => $e->getMessage()], 500);
        }
        return response()->json($employees);
    }

    public function show($id)
    {
        $employee = Employees::find($id);
        if ($employee == null) {
            return response()->json(null, 404);
        } else {
            return response()->json(['response_body' => $employee]);
        }
    }

    public function update(Request $request, $id)
    {
        $employee = Employees::find($id);
 
        if ($employee === null) {
            return response()->json(['response_body' => 'El empleado no se encuentra en la base de datos'], 404);
        } else if ($employee->email !== $request->email) {
            $find =  Employees::where('email', $request->email)->first();
            if ($find) {
                return response()->json(['error' => 'El email introducido ya se encuentra en la base de datos.'], 409);
            }
        } else {
            try {
                $employee->update([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'email' => $request->email,
                    'work_shift' => $request->workShifts,
                    'admin' => $request->admin,
                    'speciality_id' => $request->specialities,
                ]);
            } catch (Exception $e) {
                return response()->json(['error' => 'Error interno.'], 404);
            }

            return response()->json($employee, 200);
        }
    }


    public function delete($id)
    {
        $employee = Employees::find($id);
        if ($employee === null) {
            return response()->json(['response_body' => 'El empleado no se encuentra en la base de datos'], 404);
        } else {
            $employee->available = false;
            $employee->save();
            return response()->json($employee, 200);
        }
    }

}
