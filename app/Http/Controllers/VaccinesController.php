<?php

namespace App\Http\Controllers;

use App\Models\Vaccines;
use Illuminate\Http\Request;

class VaccinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('available')) {
            return Vaccines::all()->where('available', filter_var($request->available, FILTER_VALIDATE_BOOLEAN));
        } else {
            return Vaccines::all();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)

    {
        $vaccine = Vaccines::all()->where('name', $request->name);
        if ($vaccine->isEmpty()) {
            return Vaccines::create($request->all());
        }else{
            return response()->json(null, 409);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vaccines  $vaccines
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vaccine = Vaccines::find($id);
        if ($vaccine == null) {
            return response()->json(null, 404);
        } else {
            return response()->json($vaccine);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vaccines  $vaccines
     * @return \Illuminate\Http\Response
     */
    public function edit(Vaccines $vaccines)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vaccines  $vaccines
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $vaccine = Vaccines::find($id);

        if ($vaccine == null) {
            return response()->json(null, 404);
        } else {
            $vaccine->update(['available' => filter_var($request->available, FILTER_VALIDATE_BOOLEAN)]);
            return response()->json($vaccine);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vaccines  $vaccines
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vaccines $vaccines)
    {
        //
    }
}
