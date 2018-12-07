<?php

namespace App\Http\Controllers\TypesProvider;

use App\Http\Controllers\Controller;
use App\Models\TypesProvider;
use Illuminate\Http\Request;

class TypesProviderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return TypesProvider::all();
    }

    public function indexService(Request $request){
        return TypesProvider::all();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        TypesProvider::create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($TypesProvider = TypesProvider::create($request->all()))
        {
            return response()->json($TypesProvider, 201);
        }else
            return response()->json(['data'=>'error in the insert'], 500);

    }


    public function show(TypesProvider $TypesProvider)
    {

    }


    public function edit(TypesProvider $TypesProvider)
    {

    }


    public function update(Request $request)
    {

        $TypesProviderUpdate = TypesProvider::findOrFail($request->input('id'));
        if($TypesProvider= $TypesProviderUpdate->update($request->all()))
        {
            return response()->json($TypesProvider, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);
    }


    public function destroy($idTypesProvider)
    {
        if($TypesProvider = TypesProvider::find($idTypesProvider))
        {
            $TypesProvider->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }
}
