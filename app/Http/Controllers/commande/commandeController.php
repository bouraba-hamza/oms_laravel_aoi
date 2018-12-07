<?php

namespace App\Http\Controllers\commande;
use App\Http\Controllers\Controller;


use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class commandeController extends Controller
{
    public function index()
    {


//      $data = Movement::select('*')->join('providers', 'providers.id', '=', 'movements.provider')->get();
        $data=DB::table('providers')
            ->join('movements', 'providers.name', '=', 'movements.provider')

            ->select('*')
            ->get();

        return response()->json($data, 200);


    }

    public function  commandesDisticnt( $IdCategorie){
        log::info($IdCategorie);
        $data= Movement:: select(DB::raw('DISTINCT order_ref'))-> where( 'category_id','=' ,$IdCategorie) ->get();
        return response()->json($data, 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data= $request->all();
        movement::create($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        log::info($request );
        if($movement = Movement::create($request->all()))
        {
            //  DB::table('products')->insert(array('category_id'=>3));

            return response()->json($movement, 201);
        }
        else
            return response()->json(['data'=>'error in the insert'], 500);



    }



    /**
     * Display the specified resource.
     *
     * @param  \App\movement  $movement
     * @return \Illuminate\Http\Response
     */
    public function show(movement $movement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\movement  $movement
     * @return \Illuminate\Http\Response
     */
    public function edit(movement $movement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\movement  $movement
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        log::info($request);
        $commandeUpdate = Movement::findOrFail($request->input('id'));

//        log::info($commandeUpdate);

        if($commmande = $commandeUpdate->update($request->all()))
        {
            return response()->json($commandeUpdate, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\movement  $movement
     * @return \Illuminate\Http\Response
     */
    public function destroy($idCommande)
    {
        if($commande = Movement::find($idCommande))
        {
            $commande->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }
}
