<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use App\Models\Specialities;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Config;

class SpecialitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $specialities = Specialities::all();
        } catch (Exception $e) {
            return response()->json(['response_body' => $e->getMessage()], 500);
        }
        return response()->json($specialities);
     
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
     * @param  \App\Models\Specialities  $specialities
     * @return \Illuminate\Http\Response
     */
    public function show(Specialities $specialities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Specialities  $specialities
     * @return \Illuminate\Http\Response
     */
    public function edit(Specialities $specialities)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specialities  $specialities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Specialities $specialities)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specialities  $specialities
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specialities $specialities)
    {
        //
    }
}
