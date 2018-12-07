<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\DetailsIntervention;
use App\Models\Interevention;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $datavehicule = DB::table('vehicles')
            ->join('costumers', 'costumers.id', '=', 'vehicles.costumer_id')
            ->select('costumers.*', 'vehicles.*')
            ->get();

        return $datavehicule ;

    }


    public function getV(Request $request)
    {
        $users = DB::table('vehicles')->paginate(5);

        return $users;

        // return DetailsIntervention::paginate();

    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        Vehicle::create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        if($vehicle = Vehicle::create($request->all()))
        {
            return response()->json($vehicle, 201);
        }else
            return response()->json(['data'=>'error in the insert'], 500);
    }


    public function show(Request $request)
    {
        $intervention = intval($request->input('id_intervention'));
        $costumer = Interevention::findOrFail($intervention)->id_costumer;


        $datavehicule = DB::table('vehicles')
            ->where('vehicles.costumer_id','=',$costumer)
            ->get();

        return response()->json($datavehicule, 201);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
//    {
//        $vehicle = Vehicle::findOrFail($id);
//
//        return view('vehicle.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $vehiculeUpdate = Vehicle::findOrFail($request->input('id'));
        if($vehicle = $vehiculeUpdate->update($request->all()))
        {
            return response()->json($vehicle, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     *
     */
    public function destroy($id)
    {
        if($vehicule = Vehicle::find($id))
        {
            $vehicule->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);

    }
}
