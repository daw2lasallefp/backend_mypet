<?php

namespace App\Http\Controllers;


use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\Config;



use Exception;

class ClientsController extends Controller
{
    function __construct()
    {
        Config::set('jwt.user', Clients::class);
        Config::set('auth.providers', ['users' => [
            'driver' => 'eloquent',
            'model' => Clients::class,
        ]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $clients = Clients::all();
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
    public function show($id)
    {

        $clients = Clients::find($id);
           
        return response()->json($clients, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $clients = Clients::find($id);
        if ($clients === null) {
            return response()->json(['response_body' => 'El cliente no se encuentra en la base de datos'], 404);
        } else {
        

         $clients->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'phone' => $request->phone
        ]);

            $clients->save();
            return response()->json($clients, 200);
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $clients = Clients::find($id);
        $clients->delete();

        return response()->json($clients, 200);
    }


    public function clientsregister(Request $request)
    {


        //Validar datos
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email|unique:clients',
            'password' => 'required|string',
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

        $credential = $request->only('email', 'password');
        $clients = Clients::where('email', $request->email)->first();

        if ($clients->available === 0){
            return response()->json(['error' => 'Lo sentimos, este cliente ha sido dado de baja.'], 404);
        }

        try {
            if (!$token = JWTAuth::attempt($credential)) {
                return response()->json(['error' => 'incorrect_credentials'], 400);
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


    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Sesión cliente cerrada']);
    }
}
