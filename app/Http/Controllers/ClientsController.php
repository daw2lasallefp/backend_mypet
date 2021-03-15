<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Clients;
use Illuminate\Http\Request;

class ClientsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        //Recoger datos usuario post
        $json = $request->input('json', null);

        //Decodificar json
        $params = json_decode($json); //objeto
        $params_array = json_decode($json, true); //array

        if (!empty($params) && !empty($params_array)) {
            //limpiar datos

            $params_array = array_map('trim', $params_array);

            //Validar datos
            $validate = Validator::make($params_array, [
                'name' => 'required|alpha',
                'surname' => 'required|alpha',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'phone' => 'required|numeric'
            ]);
  //Comprobar si el usuario existe, duplicado
            if ($validate->fails()) {
                //Validacion fallada
                $data = array(

                    'status' => 'error',
                    'code' => 404,
                    'message' => 'El cliente no se ha creado',
                    'errors' => $validate->errors()
                );
            } else {
                //Validacion ok

                //cifrar contraseña
                $pwd= password_hash($params->password, PASSWORD_BCRYPT, ['cost' => 4]);

              
                //Crear cliente
                $clients = new Clients();
                $clients->name= $params_array['name'];
                $clients->surname= $params_array['surname'];
                $clients->email= $params_array['email'];
                $clients->password= $pwd;
                $clients->phone= $params_array['phone'];


                var_dump($clients);die();
                //Mensaje error o no
                $data = array(

                    'status' => 'success',
                    'code' => 200,
                    'message' => 'El cliente  se ha creado  correctamente'

                );
            }
        } else {
            $data = array(

                'status' => 'error',
                'code' => 404,
                'message' => 'Datos  enviados no son correctos'

            );
        }
     return response()->json($data, $data['code']);
    }

    public function login(Request $request)
    {
        return "Acción de loggin de usuarios";
    }
}
