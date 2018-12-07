<?php

namespace App\Http\Controllers\TypesUtilisateur;

use App\Http\Controllers\Controller;
use App\Models\TypesUtilisateur;
use Illuminate\Http\Request;

class TypesUtilisateurController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return TypesUtilisateur::all();
    }

    public function indexService(Request $request){
        return TypesUtilisateur::all();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        TypesUtilisateur::create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($TypesUtilisateur = TypesUtilisateur::create($request->all()))
        {
            return response()->json($TypesUtilisateur, 201);
        }else
            return response()->json(['data'=>'error in the insert'], 500);

    }


    public function show(TypesUtilisateur $TypesUtilisateur)
    {

    }


    public function edit(TypesUtilisateur $TypesUtilisateur)
    {

    }


    public function update(Request $request)
    {

        $TypesUtilisateurUpdate = TypesUtilisateur::findOrFail($request->input('id'));
        if($TypesUtilisateur= $TypesUtilisateurUpdate->update($request->all()))
        {
            return response()->json($TypesUtilisateur, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);
    }


    public function destroy($idTypesUtilisateur)
    {
        if($TypesUtilisateur = TypesUtilisateur::find($idTypesUtilisateur))
        {
            $TypesUtilisateur->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }
}
