<?php

namespace App\Http\Controllers;

use App\Models\Consultations;
use App\Models\Pets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($petId)
    {
        $consultations = DB::table('consultations AS c')
            ->join('employees AS e', 'c.employee_id', '=', 'e.id')
            ->join('specialities AS s', 'e.speciality_id', '=', 's.id')
            ->where('c.pet_id', $petId)
            ->get(['s.name AS speciality', 'e.name AS employee_name', 'e.surname AS employee_surname',
                'c.comments AS comments', 'c.date_time AS date_time']);

            return Response()->json($consultations);
        //return Consultations::all()->where('pet_id', $petId);
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
    public function store(Request $request, $petId)
    {
        return Consultations::create(array_merge($request->all(), ['pet_id' => $petId]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consultations  $consultations
     * @return \Illuminate\Http\Response
     */
    public function show(Consultations $consultations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consultations  $consultations
     * @return \Illuminate\Http\Response
     */
    public function edit(Consultations $consultations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultations  $consultations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consultations $consultations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consultations  $consultations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consultations $consultations)
    {
        //
    }
}
