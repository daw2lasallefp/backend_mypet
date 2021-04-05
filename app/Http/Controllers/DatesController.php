<?php

namespace App\Http\Controllers;

use App\Models\Dates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class DatesController extends Controller
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
                $dates = Dates::all()->paginate(5);
            }else{
                $dates = Dates::all(); 
            }
           
        } catch (Exception $e) {
            return response()->json(['response_body' => $e->getMessage()], 500);
        }
        return response()->json($dates);
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
        $validator = Validator::make($request->all(), [
            'date_time' => 'required|date',
            'pet_id' => 'required|numeric',
            'employee_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()], 400);
        } elseif (Dates::where(['date_time' => $request->date_time, 'pet_id' => $request->pet_id])->get()->isEmpty()) {
            try {
                return Dates::create($request->all());
            } catch (Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['message' => 'Ya hay una cita programada en la fecha seleccionada para esa mascota'], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dates  $dates
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $date = Dates::where('id', $id)->get();
        if ($date->isEmpty()) {
            return response()->json(['message' => 'No se ha encontrado ninguna cita con ese ID'], 404);
        } else {
            return response()->json($date);
        }
    }

    public function showByPetId($petId)
    {
        $date = Dates::where('pet_id', $petId)->get();
        if ($date->isEmpty()) {
            return response()->json(['message' => 'No se ha encontrado ninguna cita para esa mascota'], 404);
        } else {
            return response()->json($date);
        }
    }

    public function showByEmployeeId($employeeId)
    {
        $date = Dates::where('employee_id', $employeeId)->get();
        if ($date->isEmpty()) {
            return response()->json(['message' => 'El empleado seleccionado no tiene ninguna cita programada'], 404);
        } else {
            return response()->json($date);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dates  $dates
     * @return \Illuminate\Http\Response
     */
    public function edit(Dates $dates)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dates  $dates
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dates $dates)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dates  $dates
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $date = Dates::find($id);
        if ($date == null) {
            return response()->json(['message' => 'No se ha encontrado ninguna cita con ese ID'], 404);
        } else {
            $date->delete();
            return response()->json($date);
        }
    }
}
