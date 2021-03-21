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
        // $validatorsErrors[] = $validatorFields->errors()->all();
        // $validatorErrors[] = $validatorEmail->errors()->all();
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

   

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        try {
            $employees = Employees::all();
        } catch (Exception $e) {
            return response()->json(['response_body' => $e->getMessage()], 500);
        }
        return response()->json($employees);
    }


    //     /**
    //      * Show the form for creating a new resource.
    //      *
    //      * @return \Illuminate\Http\Response
    //      */
    //     public function create()
    //     {

    //     }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */
    //     public function store(Request $request)
    //     {
    //         return Employees::create($request->all());
    //     }

    //     /**
    //      * Display the specified resource.
    //      *
    //      * @return \Illuminate\Http\Response
    //      */
    //     public function show($id)
    //     {
    //         return Employees::find($id);
    //     }

    //     /**
    //      * Show the form for editing the specified resource.
    //      *
    //      * @return \Illuminate\Http\Response
    //      */
    //     public function edit(Employees $employee)
    //     {
    //         //
    //     }

    //     /**
    //      * Update the specified resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */
    //     public function update(Request $request, $id)
    //     {

    //     }

    //     /**
    //      * Remove the specified resource from storage.
    //      *
    //      * @return \Illuminate\Http\Response
    //      */
    //     public function destroy(Employees $employee)
    //     {
    //         //
    //     }


}
