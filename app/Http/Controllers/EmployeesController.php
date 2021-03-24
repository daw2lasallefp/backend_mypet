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


use Exception;

class EmployeesController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
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
        return response()->json(compact('user'));
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
            'specialities' => 'required|string',
        ]);
        $validatorsErrors = array();

        $validatorsErrors = array_merge($validatorFields->errors()->all(), $validatorEmail->errors()->all());
        if ($validatorFields->fails()) {
            return response()->json(["message" => $validatorsErrors], 400);
        }

        $employee = Employees::create([
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'admin' => $request->get('admin'),
            'work_shift' => $request->get('workShifts'),
            'speciality_id' => $request->get('specialities'),
        ]);

        $token = JWTAuth::fromUser($employee);

        return response()->json(compact('employee', 'token'), 201);
    }


    public function index(Request $request)
    {
        try {
            $employees = Employees::all()->where('available', true);
        } catch (Exception $e) {
            return response()->json(['response_body' => $e->getMessage()], 500);
        }
        return response()->json($employees);
    }


    public function update(Request $request, $id)
    {
        $employee = Employees::find($id);
        if ($employee === null) {
            return response()->json(['response_body' => 'El empleado no se encuentra en la base de datos'], 404);
        } else {
            $employee->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'work_shift' => $request->workShifts,
                'admin' => $request->admin,
                'speciality_id' => $request->specialities,
            ]);

            return response()->json(['response_body' => $employee], 200);
        }
    }


    public function delete($id)
    {
        $employee = Employees::find($id);
        if ($employee === null) {
            return response()->json(['response_body' => 'El empleado no se encuentra en la base de datos'], 404);
        } else {
            $employee->available = false;
            return response()->json(['response_body' => $employee], 200);
        }
    }

}
