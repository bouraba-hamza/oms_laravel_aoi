<?php

namespace App\Http\Controllers\Agenda;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Calendarpermission;
use App\Models\Costumer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Calendar::all();


    }


    /* Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {

        Log::info('------------------- AGENDA ADD --- backend : function store');
        Log::info($request->all());

        if($calendar = Calendar::create($request->all()))
        {
            return response()->json($calendar, 201);
        }else
            return response()->json(['data'=>'error in the insert'], 500);

        //calcule montant
    }






    public function refresh_addremove_fakeevent($intern_id){
        // remove les -999
        $data = DB::table('calendar')
            //    ->select(DB::raw('count(*)'))
            ->where ('id_user','=',-999)
            ->get();


        $my_array_data = json_decode($data, TRUE);
        Log::info(  $my_array_data    );

        if( sizeof($my_array_data) > 0 ){
            Log::info("Size > 0 ----> ".sizeof($my_array_data));

            //Log::info(  $my_array_data[0]['count(*)']    );
            $res = Calendar::where('id_user',-999)->delete();
            // Log::info($res);
            /*
                        if( sizeof($my_array_data) == 2 ){ //delete -999
                           // Log::info(  $my_array_data[0]['count(*)']    );
                            $res = Calendar::where('id_user',-999)->delete();
                            Log::info($res);

                        }else{ // add -999

                                $fakeRequest = array (
                                'client_id' => '0',
                                'installateur_id' => $intern_id,
                                'remarque' => 'test',
                                'lieu' => 'test',
                                'heure' => '00:00',
                                'update_at' => '2018-01-01',
                                'title' => 'TITRE DE L\'EVENEMENT FFF222',
                                'type' => '1',
                                'etat' => 0,
                                'opts_technique' => '[null,null,null,null,null,null]',
                                'id_user' => -999,
                            )   ;
                                if($calendar = Calendar::create($fakeRequest))
                                {
                                Log::info('------------------- AGENDA ADD --- NEW FAKE ID CREATED : ' );
                                $id_fake_event = $calendar['id'] ;
                                Log::info($id_fake_event); // FAKE ROWS A SUPPRIMER
                                return response()->json($calendar, 201);
                                }else {
                                return response()->json(['data' => 'error in the insert'], 500);
                                }

                        }
            */
        }else{
            Log::info("Size == 0 ---> ".sizeof($my_array_data)); // if size != 1

            $fakeRequest = array (
                'client_id' => '0',
                'installateur_id' => $intern_id,
                'remarque' => 'test',
                'lieu' => 'test',
                'heure' => '00:00',
                'update_at' => '2018-01-01',
                'title' => 'TITRE DE L\'EVENEMENT FFF222',
                'type' => '1',
                'etat' => 0,
                'date_vue' => 0,
                'created_at' => '' ,
                'opts_technique' => '[null,null,null,null,null,null]',
                'id_user' => -999,
            )   ;


            if($calendar = Calendar::create($fakeRequest))
            {
                Log::info('------------------- AGENDA ADD --- NEW FAKE ID CREATED : ' );
                $id_fake_event = $calendar['id'] ;
                Log::info($id_fake_event); // FAKE ROWS A SUPPRIMER
                return response()->json($calendar, 201);
            }else {
                return response()->json(['data' => 'error in the insert'], 500);
            }

        } // if size == 1

        /*
              $res = Calendar::where('id_user',-999)->delete();
              Log::info($res);

              $fakeRequest = array (
                  'client_id' => '0',
                  'installateur_id' => $intern_id,
                  'remarque' => 'test',
                  'lieu' => 'test',
                  'heure' => '00:00',
                  'update_at' => '2018-01-01',
                  'title' => 'TITRE DE L\'EVENEMENT FFF222',
                  'type' => '1',
                  'etat' => 0,
                  'opts_technique' => '[null,null,null,null,null,null]',
                  'id_user' => -999,
              )   ;

              if($calendar = Calendar::create($fakeRequest))
              {
                  Log::info('------------------- AGENDA ADD --- NEW FAKE ID CREATED : ' );
                  $id_fake_event = $calendar['id'] ;
                  Log::info($id_fake_event); // FAKE ROWS A SUPPRIMER

                   return response()->json($calendar, 201);
              }else {
                  return response()->json(['data' => 'error in the insert'], 500);
              }
        */
           return 1 ;
    }// end refresh_addremove_fakeevent









    /**
     * Display the specified resource.
     *
     * @param  \App\produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function getusers(Request $request)
    {

        return User::all();

    }



    public function getuser_by_mail($encoded_mail)
    {
        Log::info('encoded_mail :') ;
        Log::info($encoded_mail);
        $mail =  base64_decode( $encoded_mail );
         Log::info('decoded_mail :') ;
         Log::info($mail);


        $data = DB::table('users')
            ->where('email', '=', "{$mail}")
            ->get();

        Log::info($data);
        return $data ;

        //   return json_decode($data);
      //  return $data[0]->first_name.' '.$data[0]->last_name;
    }


    public function getusernamebyid($id_user)
    {

        $data = DB::table('users')
            ->where('id', '=', "{$id_user}")
            ->get();

        $fullname =  $data[0]->first_name.' '.$data[0]->last_name ;

        return response()->json(['fullname'=>$fullname ],200);
    }




    public function get_created_at_byidevent($id_event)
    {
        $data  = DB::table('calendar')
             ->where('id', '=', "{$id_event}")
             ->get();

        Log::info($data);

        //$created_at = base64_decode( $data[0]->created_at ) ;
        return response()->json([ 'created_at'=>$data[0]->created_at  ],200);
    }





    /**
     * Display the specified resource.
     *
     * @param  \App\produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        Log::info('backend : function show interval ');

        $date1 = $request->input('created_at');
        $date2 = $request->input('update_at');

        $val_id_user = $request->input('id_user');
        $val_role    = $request->input('role');

        $var1 =  date("Y/m/d", strtotime($date1) );
        $var2 =  date("Y/m/d", strtotime($date2) );

        Log::info($var1.' --> '.$var2);
        Log::info( $request);




//SELECT * FROM `calendar` where update_at between '2018/11/14' AND '2018/11/17'


        if($val_role == 'admin'){
            $data = DB::table('calendar')
                ->whereBetween('update_at', [$var1,$var2])
                ->orderBy('created_at','asc')
                ->get();

            Log::info($data);
        }else{

            $data = DB::table('calendar')
                ->where('installateur_id', '=', "{$val_id_user}")
                ->whereBetween('update_at', [$var1,$var2])
                ->orderBy('created_at','asc')
                ->get();

            Log::info($data);
        }

        //  $data = DB::raw("SELECT * FROM `calendar` WHERE `update_at` between $date1 and $date2 order by `update_at` asc");
        return response()->json(['data'=>$data],200);
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function geteventsuser($id_user)
    {

        //    Log::info('backend : function geteventsuser interval ');



        //   Log::info( 'id_user --> '.$id_user);

        $data = DB::table('calendar')
            ->where ('installateur_id','=',$id_user)
            //  ->orderBy('created_at','asc')
            ->get();

        //   Log::info($data);

        //  $data = DB::raw("SELECT * FROM `calendar` WHERE `update_at` between $date1 and $date2 order by `update_at` asc");
        return response()->json(['data'=>$data],200);
    }


    public function geteventsusersup($id_user)
    {

        Log::info('backend : function geteventsuser interval ');



        Log::info( 'id_user --> '.$id_user);

        $data = DB::table('calendar')
            ->where ('id_user','=',$id_user)
            //  ->orderBy('created_at','asc')
            ->get();

        Log::info($data);

        //  $data = DB::raw("SELECT * FROM `calendar` WHERE `update_at` between $date1 and $date2 order by `update_at` asc");
        return response()->json(['data'=>$data],200);
    }





    public function get_count_all_events_non_vues()
    {

        Log::info('backend : function get_count_all_events_non_vues ');
//
        $data = DB::table('calendar')
            ->select(DB::raw('count(*)'))
            ->where ('etat','=',0)
            ->where ('id_user','!=',-999)
            ->get();


        Log::info( 'data_count --> ');
        Log::info($data );



        //  $data = DB::raw("SELECT * FROM `calendar` WHERE `update_at` between $date1 and $date2 order by `update_at` asc");
        return response()->json(['data'=>$data],200);
    }


    public function get_count_event_non_vue_by_id_installateur($id_installateur)
    {

        Log::info('backend : function get_count_event_non_vue_by_id_installateur ');
        Log::info( 'id_installateur --> '.$id_installateur);
//
        $data = DB::table('calendar')
            ->select(DB::raw('count(*)'))
            ->where ('installateur_id','=',$id_installateur)
            ->where ('etat','=',0)
            ->where ('id_user','!=',-999)
            ->get();


             Log::info( 'data_count --> ');
             Log::info($data );



        //  $data = DB::raw("SELECT * FROM `calendar` WHERE `update_at` between $date1 and $date2 order by `update_at` asc");
        return response()->json(['data'=>$data],200);
    }



    public function getcountrowseventsuser($id_user)
    {

//        Log::info('backend : function getcountrowseventsuser ');
//        Log::info( 'id_user --> '.$id_user);
//
        $data = DB::table('calendar')
            ->select(DB::raw('count(*)'))
            ->where ('installateur_id','=',$id_user)
            ->get();


        //      Log::info( 'data_count --> '.$data);



        //  $data = DB::raw("SELECT * FROM `calendar` WHERE `update_at` between $date1 and $date2 order by `update_at` asc");
        return response()->json(['data'=>$data],200);
    }






    public function findusercalendarpermission(Request $request)
    {
        Log::info('backend : function find_user_calendarpermission interval ');

        $id_user = $request->input('id_user');


        Log::info( 'id_user --> '.$id_user);
        Log::info( $request);

        $data = DB::table('calendarpermission')
            ->where ('id_user','=',$id_user)
            //  ->orderBy('created_at','asc')
            ->get();

        //  $data = DB::raw("SELECT * FROM `calendar` WHERE `update_at` between $date1 and $date2 order by `update_at` asc");
        return response()->json(['data'=>$data],200);
    }




    public function addcalendarpermission($id_user)
    {
        return DB::table('calendarpermission')
            ->insert([
                'id_user' => $id_user
            ]);
    }


    public function updcalendarpermission(Request $request)
    {
        $requestData = $request->all();
        Log::info('updcalendarpermission $request :');
        Log::info($requestData);

        $id_user = $request->input('id_user');
        $date_debut_check = $request->input('date_debut_check');
        $date_fin_check = $request->input('date_fin_check');
        $type_check = $request->input('type_check');
        $client_check = $request->input('client_check');
        $installateur_check = $request->input('installateur_check');
        $titre_check = $request->input('titre_check');
        $lieu_check = $request->input('lieu_check');
        $personnel_check = $request->input('personnel_check');
        $ajout_check = $request->input('ajout_check');
        $update_check = $request->input('update_check');
        $delete_check = $request->input('delete_check');


        DB::table('calendarpermission')
            ->where('id_user', $id_user)  // find your user by their email
            ->limit(1)  // optional - to ensure only one record is updated.
            ->update(array('date_debut_check' => $date_debut_check ,
                'date_fin_check' => $date_fin_check ,
                'type_check' => $type_check ,
                'client_check' => $client_check ,
                'installateur_check' => $installateur_check ,
                'titre_check' => $titre_check ,
                'lieu_check' => $lieu_check ,
                'personnel_check' => $personnel_check ,
                'ajout_check' => $ajout_check ,
                'update_check' => $update_check ,
                'delete_check' => $delete_check  ));  // update the record in the DB.
    }



    public function checketateventbyidevent($idEvent)
    {



        Log::info('checketateventbyidevent  $idEvent = '.$idEvent);

        $data = DB::table('calendar')
            ->where('id','=',$idEvent)  // find your user by their email
            ->get();



        return $data  ;
        /*
        if(sizeof($data)>0){
            $current_etat = $data[0]->etat ;

            return $current_etat ;
        }else{

            return 0  ;
        }*/

    }


    public function enabletatcalendar($idEvent)
    {

        Log::info('enabletatcalendar  $idEvent = '.$idEvent);

        $data = DB::table('calendar')
            ->where('id', $idEvent)  // find your user by their email
            ->limit(1)  // optional - to ensure only one record is updated.
            ->update(array('etat' => 1 ));  // update the record in the DB.

        return $data  ;
    }

    public function add_datevue_calendar($idEvent,$encoded_date)
    {

        Log::info('add_datevue_calendar  $idEvent = '.$idEvent);
        Log::info('add_datevue_calendar  $encoded_date = '.$encoded_date);



       $data =  DB::table('calendar')
            ->where('id', $idEvent)  // find your user by their email
            ->limit(1)  // optional - to ensure only one record is updated.
            ->update(array('date_vue' => $encoded_date ));  // update the record in the DB.


 return $data ;
    }


    public function add_date_end($idEvent,$date_end)
    {

        Log::info('add_date_end  $idEvent = '.$idEvent);
       // Log::info('add_date_end  $encoded_date = '.$date_end);

   //    Log::info($date_end);
        $date_end_decode = base64_decode( $date_end );
        Log::info(    $date_end_decode  ) ;


        $data =  DB::table('calendar')
            ->where('id', $idEvent)  // find your user by their email
            ->limit(1)  // optional - to ensure only one record is updated.
            ->update(array('end' => $date_end_decode ));  // update the record in the DB.


        return $data ;
    }



    public function upd_dates_start_end($idEvent,$date_start,$date_end)
    {
      //  Log::info(     $date_start  ) ;
      //  Log::info(   $date_end    ) ;

        Log::info('upd_dates_start_end  $idEvent = '.$idEvent);
        // Log::info('add_date_end  $encoded_date = '.$date_end);

        //    Log::info($date_end);
        $date_start_decode = base64_decode( $date_start );
        $date_end_decode = base64_decode( $date_end );

        $heur_start = substr($date_start_decode,11);

        Log::info(  'start : '.  $date_start_decode  ) ;
        Log::info(  'end : '.  $date_end_decode    ) ;

      //  Log::info(  '$heur_start : '.  $heur_start  ) ;



        $data =  DB::table('calendar')
            ->where('id', $idEvent)  // find your user by their email
            ->limit(1)  // optional - to ensure only one record is updated.
            ->update(array('end' => $date_end_decode, 'update_at' => $date_start_decode , 'heure'=>$heur_start ));  // update the record in the DB.


        return $data ;

     return 1 ;
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        Log::info('backend : function filter type ');

        $val_type = $request->input('type');
        $val_title = $request->input('title');
        $val_lieu = $request->input('lieu');
        $val_client_id = $request->input('client_id');
        $val_installateur_id = $request->input('installateur_id');
        $val_date1 = $request->input('date1');
        $val_date2 = $request->input('date2');
        $val_id_user = $request->input('id_user');
        $val_role = $request->input('role');

        Log::info('val_type --> '.$val_type);
        Log::info('$val_title --> '.$val_title);
        Log::info('$val_lieu --> '.$val_lieu);
        Log::info('$val_client_id --> '.$val_client_id);
        Log::info('$val_installateur_id --> '.$val_installateur_id);
        Log::info('$val_date1 --> '.$val_date1);
        Log::info('$val_date2 --> '.$val_date2);
        Log::info('$val_id_user --> '.$val_id_user);
        Log::info('$val_role --> '.$val_role);



        if ($val_date1 != ''){
            if ($val_date2 != ''){

                if ($val_role == 'admin'){
                    Log::info('ROLE ==>  Admin');
                    $data = DB::table('calendar')
                        ->where([
                            ['type', 'LIKE', "%{$val_type}%"],
                            ['title', 'LIKE', "%{$val_title}%"],
                            ['lieu', 'LIKE', "%{$val_lieu}%"],
                            ['client_id', 'LIKE', "%{$val_client_id}%"],
                            ['installateur_id', 'LIKE', "%{$val_installateur_id}%"]
                        ])
                        ->whereBetween('update_at', [$val_date1,$val_date2])
                        ->orderBy('update_at','asc')
                        ->get();
                }else{
                    Log::info('ROLE ==>  NO_admin ');
                    $data = DB::table('calendar')
                        ->where([
                            ['type', 'LIKE', "%{$val_type}%"],
                            ['title', 'LIKE', "%{$val_title}%"],
                            ['lieu', 'LIKE', "%{$val_lieu}%"],
                            ['client_id', 'LIKE', "%{$val_client_id}%"],
                            ['installateur_id', 'LIKE', "%{$val_installateur_id}%"],
                            ['id_user', '=', "{$val_id_user}"]
                        ])
                        ->whereBetween('update_at', [$val_date1,$val_date2])
                        ->orderBy('update_at','asc')
                        ->get();
                }



            }
        }else{

            Log::info('------ NO DATE');

            /*    if ($val_role == 'admin'){*/
            Log::info('ROLE ==>  Admin');










            if($val_client_id == ''){


                if($val_installateur_id == ''){

                    $data = DB::table('calendar')
                        ->where([
                            ['type', 'LIKE', "%{$val_type}%"],
                            ['title', 'LIKE', "%{$val_title}%"],
                            ['lieu', 'LIKE', "%{$val_lieu}%"],
                            /*  ['client_id', '=', "{$val_client_id}"],*/
                            /*   ['installateur_id', '=', "{$val_installateur_id}"]*/
                        ])
                        ->orderBy('update_at','asc')
                        ->get();

                }else{

                    $data = DB::table('calendar')
                        ->where([
                            ['type', 'LIKE', "%{$val_type}%"],
                            ['title', 'LIKE', "%{$val_title}%"],
                            ['lieu', 'LIKE', "%{$val_lieu}%"],
                            /*  ['client_id', '=', "{$val_client_id}"],*/
                            ['installateur_id', '=', "{$val_installateur_id}"]
                        ])
                        ->orderBy('update_at','asc')
                        ->get();

                }


            }else{ // client_id ok

                if($val_installateur_id == ''){

                    $data = DB::table('calendar')
                        ->where([
                            ['type', 'LIKE', "%{$val_type}%"],
                            ['title', 'LIKE', "%{$val_title}%"],
                            ['lieu', 'LIKE', "%{$val_lieu}%"],
                            ['client_id', '=', "{$val_client_id}"],
                            /*   ['installateur_id', '=', "{$val_installateur_id}"]*/
                        ])
                        ->orderBy('update_at','asc')
                        ->get();

                }else{

                    $data = DB::table('calendar')
                        ->where([
                            ['type', 'LIKE', "%{$val_type}%"],
                            ['title', 'LIKE', "%{$val_title}%"],
                            ['lieu', 'LIKE', "%{$val_lieu}%"],
                            ['client_id', '=', "{$val_client_id}"],
                            ['installateur_id', '=', "{$val_installateur_id}"]
                        ])
                        ->orderBy('update_at','asc')
                        ->get();

                }

            }








            /*
                        }else{
                            Log::info('ROLE ==>  NO_admin ');

                      $data = DB::table('calendar')
                                ->where([
                                    ['type', 'LIKE', "%{$val_type}%"],
                                    ['title', 'LIKE', "%{$val_title}%"],
                                    ['lieu', 'LIKE', "%{$val_lieu}%"],
                                    ['client_id', '=', "{$val_client_id}"],
                                    ['installateur_id', '=', "{$val_installateur_id}"]
                                  //  ['installateur_id', '=', "{$val_id_user}"]
                                ])
                             //   ->whereBetween('update_at', [$val_date1,$val_date2])
                                ->orderBy('update_at','asc')
                                ->get();


                            Log::info('LOG ==>  DATA');
                            Log::info($data);

                        }
            */



        }






        return response()->json(['data'=>$data],200);


    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Log::info('backend : function store');
        Log::info($request->all());

        $calendarUpdate = Calendar::findOrFail($request->input('id'));
        if($calendar = $calendarUpdate->update($request->all()))
        {
            return response()->json($calendar, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy($idCalendar)
    {
        if($calendar = Calendar::find($idCalendar))
        {
            $calendar->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }
}
