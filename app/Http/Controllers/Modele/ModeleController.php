<?php

namespace App\Http\Controllers\Modele;

use App\Http\Controllers\Controller;
use App\Http\Requests\Modele\StoreRequest;
use App\Models\Modele;
use App\Services\ModeleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ModeleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Modele::all();
    }

    public function indexService(Request $request){
        //  return Modele::all();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Modele::create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($modele = Modele::create($request->all()))
        {
            return response()->json($modele, 201);
        }else
            return response()->json(['data'=>'error in the insert'], 500);

    }


    public function show(Modele $modele)
    {

    }


    public function edit(Modele $modele)
    {

    }


    public function update(Request $request)
    {

        $ModeleUpdate = Modele::findOrFail($request->input('id'));
        if($modele = $ModeleUpdate->update($request->all()))
        {
            return response()->json($modele, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);
    }


    public function destroy($idModele)
    {
        if($modele = Modele::find($idModele))
        {

            Log::info($modele);
            $modele->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }
}
