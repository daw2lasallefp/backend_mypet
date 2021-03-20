<?php

namespace App\Http\Controllers;


use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class ClientsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $clients =Clients::all();
        } catch (Exception $e) {
            return response()->json(['response_body' => $e->getMessage()], 500);
        }
        return response()->json($clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function show(Clients $clients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function edit(Clients $clients)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clients $clients)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clients $clients)
    {
        //
    }


    public function clientsregister(Request $request)
    {


            //Validar datos
            $validate = Validator::make($request->all(), [
                'name' => 'required|alpha',
                'surname' => 'required|alpha',
                'email' => 'required|email|unique:clients',
                'password' => 'required',
                'phone' => 'required|numeric'
            ]);
            //Comprobar si el usuario existe, duplicado
            if ($validate->fails()) {
                return response()->json($validate->errors()->toJson(), 400);
            } 
               

              
                //Crear cliente
                $clients = Clients::create([
                    'name' => $request->get('name'),
                    'surname' => $request->get('surname'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password')),
                    'phone' => $request->get('phone')
                 ]);

        $token = JWTAuth::fromUser($clients);

        return response()->json(compact('clients', 'token'), 201);
    }


    public function authenticate(Request $request)
    {
          //credenciales a comparar
          $credentials = $request->only('email', 'password');
          try {
  
              if (!$token = JWTAuth::attempt($credentials)) {
                  return response()->json(['error' => 'invalid_credentials'], 400);
              }
          } catch (JWTException $e) {
              return response()->json(['error' => 'could_not_create_token'], 500);
          }
          return response()->json(compact('token'));
    }


  
    public function getAuthenticatedClients()
    {
        try {
            if (!$clients = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('clients'));
    }


}
