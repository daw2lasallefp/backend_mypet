<?php

namespace App\Http\Controllers;

use App\Models\Clinics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;


class ClinicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if($request->has('page')){
                $clinics = Clinics::all()->paginate(5);
            }else{
                $clinics = Clinics::all(); 
            }
           
        } catch (Exception $e) {
            return response()->json(['response_body' => $e->getMessage()], 500);
        }
        return response()->json($clinics);
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
     * @param  \App\Models\Clinics  $clinics
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clinic = Clinics::where('id', $id)->get();
        if ($clinic->isEmpty()) {
            return response()->json(['message' => 'No se ha encontrado ninguna clínica con ese ID'], 404);
        } else {
            return response()->json($clinic);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clinics  $clinics
     * @return \Illuminate\Http\Response
     */
    public function edit(Clinics $clinics)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clinics  $clinics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $itemToUpdate = Clinics::findOrFail($id);
        } catch (Exception $e) {
            return response()->json(['message' => 'No se ha encontrado ninguna clínica con ese ID'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'city' => 'required',
            'address' => 'required',
            'phone' => 'required|alpha_num',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()], 400);
        } else {
            $itemToUpdate->name = $request->input('name');
            $itemToUpdate->city = $request->input('city');
            $itemToUpdate->address = $request->input('address');
            $itemToUpdate->phone = $request->input('phone');
            $itemToUpdate->email = $request->input('email');
        }

        try {
            $itemToUpdate->save();
            return response()->json(Clinics::find($id));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clinics  $clinics
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clinics $clinics)
    {
        //
    }
}
