<?php

namespace App\Http\Controllers;

use App\Models\Clinics;
use Illuminate\Http\Request;
use Exception;


class ClinicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Clinics::all());
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
        return response()->json(Clinics::find($id));
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
        try{
            $itemToUpdate = Clinics::findOrFail($id);
            $itemToUpdate->name = $request->input('name');
            $itemToUpdate->city = $request->input('city');
            $itemToUpdate->address = $request->input('address');
            $itemToUpdate->phone = $request->input('phone');
            $itemToUpdate->email = $request->input('email');
        } catch (Exception $e) {
            return response()->json(['message'=>'There is no such clinic'],404);
        }

        try {
            $itemToUpdate->save();
            return response()->json(Clinics::find($id));
        } catch (Exception $e) {
            return response()->json(['message'=>$e->getMessage()],500);
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
