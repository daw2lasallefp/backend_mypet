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


    public function register(Request $request){

        //Recoger datos usuario post
        $json=$request->input('json', null);
       
        //Decodificar json
        $params = json_decode($json);//objeto
        $params_array = json_decode($json, true);//array
        
        //Validar datos
        $validate = Validator::make($params_array, [
            'name' =>'required|alpha',
            'surname' =>'required|alpha',
            'email' =>'required|email',
            'password' =>'required',
            'phone' =>'required|numeric'
        ]);

        if($validate->fails()){
            $data = array(

                'status' => 'error',
                'code' => 404,
                'message' => 'El cliente no se ha creado',
                'errors' => $validate->errors()
               );
        }else{
            $data = array(

                'status' => 'success',
                'code' => 200,
                'message' => 'El cliente  se ha creado  correctamente'
                
               );
        }


        //cifrar contraseña
        //Comprobar si el usuario existe, duplicado
        //Crear cliente
        //Mensaje error o no
        





       


       return response()->json($data, $data['code']);

    }

    public function login(Request $request){
        return "Acción de loggin de usuarios";
    }
}
