<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use Closure;
use Illuminate\Support\Facades\DB ;
use App\Quotation;



class InterceptAllRequests
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $var_1 ;
    public $var_2 ;
    public $var_3 ;
    public $var_4 ;

    public function __construct($var_1,$var_2,$var_3,$var_4)
    {
        $this->var_1 = $var_1;
        $this->var_2 = $var_2;
        $this->var_3 = $var_3;
        $this->var_4 = $var_4;




    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {

        Log::info('InterceptAllRequests -> broadcastOn');
        Log::info('var_1 ->');
        Log::info($this->var_1);
        Log::info('var_2 ->');
        Log::info(($this->var_2)->sql);
      //  Log::info('var_3 ->');
      //  Log::info($this->var_3);

       // $next = $this->var_3 ;
       // $request = $this->var_1 ;

      //  return $next($request);


/*
        Event::listen('illuminate.query', function($query, $bindings, $time, $name)
        {
            //  $this->query_ = $query->sql ;
            Log::info('Event::listen  : ');
            Log::info($query );
        });
*/

      //  return new PrivateChannel('channel-name');
    }




    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    public function handle($request, Closure $next) {

        Log::info("++++++++++++++++++++++++++++++++++");
        Log::info("InterceptAllRequests handler");
        return $next($request);
        Log::info("++++++++++++++++++++++++++++++++++");

    }

}
