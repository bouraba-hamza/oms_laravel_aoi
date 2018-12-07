<?php

namespace App\Http\Controllers\utilisateur;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Services\UtilisateurService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UtilisateurController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datautilisateur = DB::table('utilisateurs')
            ->join('types_utilisateurs', 'types_utilisateurs.id', '=', 'utilisateurs.fonction')
            ->select('utilisateurs.*',DB::raw(' utilisateurs.id as num '),'types_utilisateurs.*')
            ->get();

        return $datautilisateur;
    }

    public function indexService(Request $request){
         return Utilisateur::all();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Utilisateur::create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        log::info($request);

        if($utilisateur = Utilisateur::create($request->all()))
        {
            return response()->json($utilisateur, 201);
        }else
            return response()->json(['data'=>'error in the insert'], 500);

    }


    public function show(Utilisateur $utilisateur)
    {

    }




    public function update(Request $request)
    {
               log::info($request);
        $utilisateurUpdate = Utilisateur::findOrFail($request->input('id'));
        if($utilisateur = $utilisateurUpdate->update($request->all()))
        {
            return response()->json($utilisateur, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);
    }


    public function destroy($idUtilisateur)
    {
        if($utilisateur = Utilisateur::find($idUtilisateur))
        {

            Log::info($utilisateur);
            $utilisateur->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }
}
