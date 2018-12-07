<?php

namespace App\Http\Controllers\TypesCustomer;

use App\Http\Controllers\Controller;
use App\Models\TypesCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;

class TypesCustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return TypesCustomer::all();
    }

    public function find($label_type)
    {
        $results = DB::select('select * from types_customers where types = "'.$label_type.'"');
       Log::info($results);
       return $results;
    }

    public function indexService(Request $request){
        return TypesCustomer::all();
    }

    public function create(Request $request)
    {
        TypesCustomer::create();
    }


    public function store(Request $request)
    {
        if($TypesCustomer = TypesCustomer::create($request->all()))
        {
            Log::info($TypesCustomer);
            return response()->json($TypesCustomer, 201);
        }else
            return response()->json(['data'=>'error in the insert'], 500);

    }


    public function show(TypesCustomer $TypesCustomer)
    {

    }


    public function edit(TypesCustomer $TypesCustomer)
    {

    }


    public function update(Request $request)
    {

        $TypesCustomerUpdate = TypesCustomer::findOrFail($request->input('id'));
        if($TypesCustomer = $TypesCustomerUpdate->update($request->all()))
        {
            return response()->json($TypesCustomer, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);
    }


    public function destroy($idTypesCustomer)
    {
        if($TypesCustomer = TypesCustomer::find($idTypesCustomer))
        {
            $TypesCustomer->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }
}
