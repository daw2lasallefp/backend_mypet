<?php

namespace App\Http\Controllers;

use App\Models\Vaccinations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class VaccinationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('page')) {
                $vaccination = Vaccinations::all()->paginate(5);
            } else {
                $vaccination = Vaccinations::all();
            }
        } catch (Exception $e) {
            return response()->json(['response_body' => $e->getMessage()], 500);
        }
        return response()->json($vaccination);
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
            'date' => 'required|date',
            'done' => 'required|boolean',
            'pet_id' => 'required|numeric',
            'vaccine_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()], 400);
        } elseif (Vaccinations::where(['date' => $request->date, 'pet_id' => $request->pet_id, 'vaccine_id' => $request->vaccine_id])->get()->isEmpty()) {
            try {
                return Vaccinations::create($request->all());
            } catch (Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['message' => 'Ya hay una vacunación programada en la fecha seleccionada para esa mascota y vacuna'], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vaccinations  $vaccinations
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByPet(Request $request, $pet_id)
    {
        if ($request->has('page')) {
            $vaccinations = Vaccinations::where('vaccinations.pet_id', $pet_id)
                ->join('vaccines AS vac', 'vaccinations.vaccine_id', '=', 'vac.id')
                ->paginate(5, [
                    'vaccinations.id AS id', 'vaccinations.date AS date', 'vaccinations.done AS done', 'vaccinations.pet_id AS pet_id',
                    'vaccinations.vaccine_id AS vaccine_id', 'vac.name AS vaccine_name'
                ]);
        } else {
            $vaccinations = DB::table('vaccinations AS v')
                ->join('vaccines AS vac', 'v.vaccine_id', '=', 'vac.id')
                ->where('v.pet_id', $pet_id)
                ->get([
                    'v.id AS id', 'v.date AS date', 'v.done AS done', 'v.pet_id AS pet_id',
                    'v.vaccine_id AS vaccine_id', 'vac.name AS vaccine_name'
                ]);
        }


        return Response()->json($vaccinations);
    }

    public function showById($id)
    {
        $vaccination = Vaccinations::where('id', $id)->get();
        if ($vaccination->isEmpty()) {
            return response()->json(['message' => 'No se ha encontrado ninguna vacunación con ese ID'], 404);
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
            return response()->json(['message' => 'No se ha encontrado ninguna vacunación con ese ID'], 404);
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
