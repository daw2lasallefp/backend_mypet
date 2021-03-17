<?php

namespace App\Http\Controllers;

use App\Models\Pets;
use Illuminate\Http\Request;

class PetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has(['client_id', 'available'])){

            return Pets::all()->where('client_id', $request->client_id)
            ->where('available',filter_var($request->available, FILTER_VALIDATE_BOOLEAN));

        } elseif ($request->has('client_id') && !$request->has('available')) {

            return Pets::all()->where('client_id', $request->client_id);

        }elseif (!$request->has('client_id') && $request->has('available')) {

            return Pets::all()->where('available', filter_var($request->available, FILTER_VALIDATE_BOOLEAN));

        }  else {
            return Pets::all();
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
        return Pets::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pets  $pets
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Pets::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pets  $pets
     * @return \Illuminate\Http\Response
     */
    public function edit(Pets $pets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pets  $pets
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pet = Pets::findOrFail($id);

        $pet->update($request->all);

        return $pet;
    }

    public function delete($id)
    {
        $pet = Pets::findOrFail($id);

        $pet->available = false;

        $pet->save();

        return $pet;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pets  $pets
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pets $pets)
    {
        //
    }
}
