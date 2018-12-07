<?php

namespace App\Http\Controllers\Product;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\InventoryPersonal;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */


    public function indexBoitier(Request $request)
    {

//        $data = product::select('*')->join('movements', 'movements.id', '=', 'products.movement_id')->join('providers', 'providers.id', '=', 'movements.provider')
//            ->where('movements.category_id', '=', 1) ->get();
        $data=   DB::table('providers')
            ->join('movements', 'providers.id', '=', 'movements.provider')
            ->join('products', 'movements.id', '=', 'products.movement_id')

            ->select('*')->where('movements.category_id', '=', 1)
//            ->orderBy('products.created_at' )
            ->get();

        return response()->json($data, 200);
    }



    public function indexSim(Request $request)
    {

        $data= DB::table('providers')
            ->join('movements', 'providers.id', '=', 'movements.provider')
            ->join('products',function ($join) {
                $join->on('movements.id', '=', 'products.movement_id');
            })
            ->select('*')->where('movements.category_id', '=', 2)
            ->get();

         log::info($data);


        return response()->json($data, 200);
    }

    public function productInstallSim($id){

        log::info($id);

        $data=   DB::table('interevention')
            ->join('details_intervention','interevention.id','=','details_intervention.id_intervention')
            ->join('vehicles','details_intervention.id_vehicule','=','vehicles.id')
            ->join('personals','interevention.id_instalateur','=','personals.id')
            ->join('inventory_personals','personals.id','=','inventory_personals.personal_id')
            ->join('products','inventory_personals.product_id','=','products.id')
            ->select('*')
            -> where('details_intervention.imei_carte', '=', $id)
            -> where('inventory_personals.product_id', '=', $id)
            ->get();


        return response()->json($data, 200);
    }

    public function productInstallBoitier($id){

        $data=   DB::table('interevention')
            ->join('details_intervention','interevention.id','=','details_intervention.id_intervention')
            ->join('vehicles','details_intervention.id_vehicule','=','vehicles.id')
            ->join('personals','interevention.id_instalateur','=','personals.id')
            ->join('inventory_personals','personals.id','=','inventory_personals.personal_id')
            ->join('products','inventory_personals.product_id','=','products.id')
            ->select('*')
            -> where('details_intervention.imei_boitier', '=', $id)
            -> where('inventory_personals.product_id', '=', $id)
            ->get();
        return response()->json($data, 200);
    }
    public function ProductStockSim($id){

        log::info('ididid');
        log::info($id);

        $data=   DB::table('personals')
//            ->join('details_intervention','vehicles.id','=','details_intervention.id_vehicule')
            ->join('inventory_personals','personals.id','=','inventory_personals.personal_id')


            ->join('products','inventory_personals.product_id','=','products.id')


            ->select('*')

            -> where('inventory_personals.product_id', '=', $id)
            -> where('inventory_personals.status', '=', '1')

            ->get();
        return response()->json($data, 200);
    }
    public function ProductStockBoitier($id){


        $data=   DB::table('personals')
            ->join('inventory_personals','personals.id','=','inventory_personals.personal_id')
            ->join('products','inventory_personals.product_id','=','products.id')
            ->select('*')
            -> where('inventory_personals.product_id', '=', $id)
            -> where('inventory_personals.status', '=', '1')
            ->get();
        return response()->json($data, 200);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
//        return view('product.products.create');
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
        Log::info($request);

        $all=  $request->all();
        Log::info($all[count($all)-1]);
        $i = 0;
        foreach ($all as $item) {
            if($i <= count($all)-3){
                if($item['0']!='SSID' or $item['1']!='ligne' or  $item['2']!='PLAN'){
                    $movement= Product::create(['imei_product' => $item['0'],'label' => $item['1'],'model' => $item['2'],'status' => '1', 'state'=>'disabled',
                        'enabled_date'=>$all[count($all)-2],'movement_id'=>$all[count($all)-1]]);

                }
            }
            $i++;
        }

        if($movement)
        {
            return response()->json($movement, 201);
        }
        else
            return response()->json(['data'=>'error in the insert'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     *
     */

    public function active(Request $request){Log::info('-------------');
        log::info( $request);
        $productpush = intVal(($request->input('NbrActiv')));
        log::info( $productpush);


        $data=DB::table('movements')
            ->join('products','movements.id','=','products.movement_id')
            ->where('products.status','=','1')
            ->where('movements.category_id','=',2)
            ->orderBy('products.imei_product')
            ->select('products.id as productId','movements.*','products.*')
            ->limit($productpush)
            ->get();
        log::info( $data);

        foreach ($data as $tab){
            DB::table('products')
                ->where('products.id','=',$tab->productId)
                ->update([
                    'state'=>'enabled',
                    'updated_at'=>$tab->updated_at
                ]);
        }


        return response()->json([], 201);

//         return response()->json($productUpdate, 201);


    }

    public function  affect(Request $request){
        log::info( $request);

        $productpush = ($request->input('productpush'));

        $push= explode(",",$productpush);

        foreach ($push as $tab){
            $tab_number = intval($tab);

            DB::table('products')
                ->where('id',$tab_number)
                ->update([
                    'status' => '2',
                    'observtion'=>$request->input('observation')
                ]);

            DB::table('inventory_personals')
                ->insert([
                    'personal_id' => $request->input('personal_id'),
                    'product_id' => $tab_number,
                    'user_id'=>2,
                    'status'=>'1'
                ]);

        }
        return response()->json([], 201);

    }

    public function transfert(Request $request){
        log::info($request);

        $productpush = ($request->input('productpush'));

        $push= explode(",",$productpush);

        foreach ($push as $tab){
            $tab_number = intval($tab);

//         DB::table('products')
//             ->where('id',$tab_number)
//             ->update([
//                 'status' => '2',
//                 'observtion'=>$request->input('observation')
//             ]);

            DB::table('inventory_personals')
                ->where('product_id',$tab_number)
                ->update([
                    'personal_id' => $request->input('personal_id'),
                    'user_id'=>2,
                    'status'=>'1'
                ]);

        }
        return response()->json([], 201);


    }

    public function deblocage(Request $request){

        $productpush = ($request->input('productpush'));

        $push= explode(",",$productpush);

        foreach ($push as $tab){
            $tab_number = intval($tab);
            DB::table('products')
                ->where('id',$tab_number)
                ->update([
                    'status' => '1'
                ]);
        }
        return response()->json([], 201);
    }

    public function blocage(Request $request){

        log::info( $request);

        $productpush = ($request->input('productpush'));

        $push= explode(",",$productpush);

        foreach ($push as $tab){
            $tab_number = intval($tab);
            DB::table('products')
                ->where('id',$tab_number)
                ->update([
                    'status' => '3'
                ]);
        }
        return response()->json([], 201);
    }

    public function liberation(Request $request){

        $productpush = ($request->input('productpush'));

        $push= explode(",",$productpush);

        foreach ($push as $tab){
            $tab_number = intval($tab);
            DB::table('products')
                ->where('id',$tab_number)
                ->update([
                    'status' => '1'
                ]);
            DB::table('inventory_personals')
                ->where('product_id',$tab_number)
                ->update([

                    'user_id'=>2,
                    'status'=>'0'
                ]);
        }
        return response()->json([], 201);

    }

    public function retour (Request $request){

        $productpush = ($request->input('productpush'));

        $push= explode(",",$productpush);

        foreach ($push as $tab){
            $tab_number = intval($tab);
            DB::table('products')
                ->where('id',$tab_number)
                ->update([
                    'status'=>'4'
                ]);

            DB::table('inventory_personals')
                ->where('product_id',$tab_number)
                ->delete();
        }
        return response()->json([], 201);

    }




    public function storeSimBoitier(Request $request ){

        if($product = Product::create($request->all()))
        {

            return response()->json($product, 201);
        }
        else
            return response()->json(['data'=>'error in the insert'], 500);

    }



    public function show($id)
    {
//        $product = Product::findOrFail($id);
//
//        return view('product.products.show', compact('product'));
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
//        $product = Product::findOrFail($id);
//
//        return view('product.products.edit', compact('product'));
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
        log::info($request);
        $productUpdate = Product::findOrFail($request->input('id'));

        log::info($productUpdate);

        if($product = $productUpdate->update($request->all()))
        {
            return response()->json($product, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($idProduct)
    {
        if($product = Product::find($idProduct))
        {
            $product->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }
}
