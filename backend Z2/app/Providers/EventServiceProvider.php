<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;

use App\Http\Middleware\Session_prv ;

use Illuminate\Support\Facades\DB;

class EventServiceProvider extends ServiceProvider
{



    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];




    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        /*
        Event::listen('illuminate.query', function($query, $bindings, $time, $name)
        {
            // Code to log query goes here
            Log::info("HAMZAA");
        });*/
        //

 /*
        DB::listen(function ($query) {
            Log::info(' DB::listen   '  );
            Log::info(' query : '.$query->sql );
            Session_prv::setVar1($query->sql);
             Session_prv->var_1 = $query->sql ;
            //  $this->test($query->sql) ;
        }  );
*/
    }
}
