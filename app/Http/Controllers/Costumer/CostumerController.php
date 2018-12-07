<?php

namespace App\Http\Controllers\costumer ;

use App\Http\Controllers\Controller;
use App\Models\Costumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CostumerController extends Controller
{


    public function index(Request $request)
    {

        $datacustomer = DB::table('costumers')
            ->join('types_customers', 'types_customers.id', '=', 'costumers.type_id')
//            ->join('interevention', 'interevention.id', '=', 'costumers.id')
            ->select('costumers.*','types_customers.types')
            ->get();


        return $datacustomer;

    }



    public function create(Request $request)
    {

        Costumer::create();
    }


    public function store(Request $request)
    {
        if($costumer = Costumer::create($request->all()))
        {
            return response()->json($costumer, 201);
        }else
            return response()->json(['data'=>'error in the insert'], 500);

    }


    public function update(Request $request)
    {
        $costumerUpdate = Costumer::findOrFail($request->input('id'));
        if($costumer = $costumerUpdate->update($request->all()))
        {
            return response()->json($costumer, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);
    }


    public function destroy($idCostumer)
    {
        Log::info($idCostumer);
        if ($costumer= Costumer::findOrFail($idCostumer)) {
            $costumer->delete();
            return response()->json(null, 202);
        } else
            return response()->json(['data' => 'error in the delete'], 500);


    }
}
