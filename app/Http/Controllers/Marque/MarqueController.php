<?php

namespace App\Http\Controllers\Marque;

use App\Http\Controllers\Controller;
use App\Http\Requests\Marque\StoreRequest;
use App\Models\Marque;
use App\Services\MarqueService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MarqueController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Marque::all();
    }

    public function indexService(Request $request){
        //  return Marque::all();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Marque::create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($marque = Marque::create($request->all()))
        {
            return response()->json($marque, 201);
        }else
            return response()->json(['data'=>'error in the insert'], 500);

    }


    public function show(Marque $marque)
    {

    }


    public function edit(Marque $marque)
    {

    }


    public function update(Request $request)
    {

        $MarqueUpdate = Marque::findOrFail($request->input('id'));
        if($marque = $MarqueUpdate->update($request->all()))
        {
            return response()->json($marque, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);
    }


    public function destroy($idMarque)
    {
        if($marque = Marque::find($idMarque))
        {

            Log::info($marque);
            $marque->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }
}
