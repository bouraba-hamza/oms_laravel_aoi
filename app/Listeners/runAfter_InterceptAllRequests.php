<?php

namespace App\Listeners;

use App\Events\InterceptAllRequests;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Event;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB ;
use App\Quotation;


namespace App\Http\Middleware;
use Illuminate\Support\Facades\Event;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB ;
use App\Quotation;
use App\Events\InterceptAllRequests;


class runAfter_InterceptAllRequests
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  InterceptAllRequests  $event
     * @return void
     */
  public function handle(InterceptAllRequests $event  )
    {
        Log::info("---------------------------------");
        Log::info("runAfter_InterceptAllRequests");
            Log::info($event->broadcastOn());
        Log::info("------------------------------");

/*
        Event::listen('illuminate.query', function($query, $bindings, $time, $name)
        {
            //  $this->query_ = $query->sql ;
            Log::info('Event::listen  : ');
            Log::info($query );
        });
*/

    }







}
