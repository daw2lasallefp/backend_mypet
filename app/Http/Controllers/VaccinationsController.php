<?php

namespace App\Http\Controllers;

use App\Models\Vaccinations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class VaccinationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vaccination = Vaccinations::all();
        if ($vaccination->isEmpty()) {
            return response()->json(null,404);
        } else {
            return response()->json($vaccination);
        }
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
     * @param  \App\Models\Vaccinations  $vaccinations
     * @return \Illuminate\Http\Response
     */
    public function show($pet_id)
    {
        $vaccination = Vaccinations::where('pet_id', $pet_id)->get();
        if ($vaccination->isEmpty()) {
            return response()->json(null, 404);
        } else {
            return response()->json($vaccination);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vaccinations  $vaccinations
     * @return \Illuminate\Http\Response
     */
    public function edit(Vaccinations $vaccinations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vaccinations  $vaccinations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $update = Vaccinations::findOrFail($id);
        } catch (Exception $e) {
            return response()->json(['message' => 'No vaccination associated with that ID'], 404);
        }

        $validator = Validator::make($request->all(), [
            'done' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()], 400);
        } else {
            $update->done = $request->input('done');
        }

        try {
            $update->save();
            return response()->json(Vaccinations::find($id));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vaccinations  $vaccinations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vaccinations $vaccinations)
    {
        //
    }
}
