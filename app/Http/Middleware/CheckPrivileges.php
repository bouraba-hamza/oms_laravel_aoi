<?php


namespace App\Http\Middleware;
use Illuminate\Support\Facades\Event;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB ;
use App\Quotation;
use App\Events\InterceptAllRequests;
use App\Http\Middleware\Session_prv ;

//include '../../../app/events/database.php' ;
class CheckPrivileges
{


public $current_token ;
public $current_role  ;
public $current_module;
public $current_type_req;

public  $request_ ;
public  $next_  ;
public  $query_  ;

public  $next_request_ ;

    public $session_prv    ;

    /**
     * CheckPrivileges constructor.
     * @param $session_prv
     */
    public function __construct(Session_prv $session_prv)
    {
        $this->session_prv = $session_prv;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */






//Event::fire(new ActionDone());
    /*
             //       DB::listen(function ($query) {

                        $this->session_prv->var_1 = $query->sql ;

                        Log::info( '-----> 3    (SAVE QUERY)' ) ;
                        $current_token = $this->request_->header('Authorization');
                        Log::info('CURRENT_TOKEN : '.$current_token);
                        $current_role = $this->request_->header('rl');
                        //    Log::info($request->header());
                        Log::info('CURRENT_ROLE : '.$current_role);
                        $current_module = $this->request_->header('md');
                        Log::info('CURRENT_MODULE : '.$current_module);
                        $req =  $this->session_prv->var_1 ;
                        $type_req = substr($req, 0, 6);
                        Log::info('TYPE_REQUETTE var_1 => '.$type_req);


                       //     Log::info(' query : '.$query->sql );

                     //       $this->query_ = $query->sql ;
                        //   Log::info('this->query_ : '.$this->query_ );


                    //    $obj_1 = new InterceptAllRequests('A','B','C','D' );

                       // Event::fire(new InterceptAllRequests('A','B','C','D'));


                  //      $this->test($query->sql) ;
              //      }  );
    */


    public function handle($request, Closure $next) {

        $this->request_ = $request;

            if ($request->ajax() || $request->wantsJson()) {



                $current_route_api = $request->header('rt') ;
                $s = strstr($current_route_api, 'api');
           //     Log::info('*********');
           //     Log::info($s);
            //    Log::info('*********');
                $current_type = explode( '/', $s );
                $size_obj = sizeof($current_type);
                if($size_obj == 2){
                    // Log::info($current_type[1]);
                 //   $this->current_module = $current_type[1] ;
                    $this->current_type_req = 'select' ;
                  //  Log::info('$this->current_module  : '.$this->current_module );
                 //   Log::info('$this->current_type_req  : '.$this->current_type_req );
                }else if($size_obj == 3){
                    //  Log::info($current_type[1].'/'.$current_type[2]);
                 //   $this->current_module = $current_type[1] ;
                    $this->current_type_req = $current_type[2] ;
                 //   Log::info('$this->current_module  : '.$this->current_module );
                 //   Log::info('$this->current_type_req  : '.$this->current_type_req );
                }






                Log::info( '---------------------'  ) ;
                Log::info( '---------------------'  ) ;
                Log::info('--- CheckPrivileges.php : ---');


                $current_token = $this->request_->header('Authorization');
                Log::info('CURRENT_TOKEN : '.$current_token);

                $current_role = $this->request_->header('rl');
                Log::info('CURRENT_ROLE : '.$current_role);

                Log::info('TYPE_REQUETTE : '. $this->current_type_req);

                $current_module = $this->request_->header('md');
                $current_module =  substr($current_module, 1);
                Log::info('CURRENT_MODULE : '.$current_module);



                $this->check_privileges_from_db();


                if($current_role == 'admin')
                {
                    Log::info( '---------------------'  ) ;
                    Log::info( '---------------------'  ) ;
                     return $next($request);
                }
                else if($current_role == 'installateur')
                {
                    Log::info( '---------------------'  ) ;
                    Log::info( '---------------------'  ) ;
                    return $next($request);
                 //   return response()->json(['no_privileges' ],303);
                  //  return $next($request);
                }
                else if($current_role == 'stock')
                {
                    Log::info( '---------------------'  ) ;
                    Log::info( '---------------------'  ) ;
                    return $next($request);
                }
                else {
                    Log::info( '---------------------'  ) ;
                    Log::info( '---------------------'  ) ;
                    return response()->json(['privilege_off' ],303);
                }



            }
            /*else {
                return response()->json(['privilege_off_2' ],303);
            }*/



    }




/*
    function test($query){
        Log::info( '-----> 4' ) ;
        $current_token = $this->request_->header('Authorization');
        Log::info('CURRENT_TOKEN : '.$current_token);
        $current_role = $this->request_->header('rl');
        //    Log::info($request->header());
        Log::info('CURRENT_ROLE : '.$current_role);
        $current_module = $this->request_->header('md');
        Log::info('CURRENT_MODULE : '.$current_module);
        $req =  $this->session_prv->var_1 ;
        $type_req = substr($req, 0, 6);
        Log::info('TYPE_REQUETTE var_1 => '.$type_req);


        Log::info( '---------------------'  ) ;
        Log::info( '---------------------'  ) ;
        Log::info('--- CheckPrivileges.php : ---');


        $current_token = $this->request_->header('Authorization');
        Log::info('CURRENT_TOKEN : '.$current_token);

        $current_role = $this->request_->header('rl');
        //    Log::info($request->header());
        Log::info('CURRENT_ROLE : '.$current_role);


        $current_module = $this->request_->header('md');
        Log::info('CURRENT_MODULE : '.$current_module);


        $req =  $this->session_prv->var_1 ;
        $type_req = substr($req, 0, 6);
        Log::info('TYPE_REQUETTE var_1 => '.$type_req); // --------> TYPE requette exécutée






      //  return $next_($request_);


        Log::info( '---------------------'  ) ;
        Log::info( '---------------------'  ) ;





    }
*/

   function check_privileges_from_db($current_role_,$type_requette_,$current_module_){

        $current_role  = $current_role_ ;
        $type_requette   = $type_requette_ ;
        $current_module   = $current_module_ ;


       Log::info('-> check_privileges_from_db');
       Log::info('CURRENT_ROLE : '.$current_role);
       Log::info('TYPE_REQUETTE : '. $type_requette);
       Log::info('CURRENT_MODULE : '.$current_module);
       Log::info('-> END check_privileges_from_db');
       

      return 1 ;
   }

}
