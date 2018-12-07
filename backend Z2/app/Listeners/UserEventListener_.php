<?php

namespace App\Listeners;

use App\Events\InterceptAllRequests;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Log;
class UserEventListener_
{

    /**
     * Handle user login events.
     */
    public function onUserLogin($event) {

        Log::info('event catched');
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) {

        Log::info('event catched');

    }

    public function subscribe($events)
    {
        $events->listen(
            'App\Events\UserLoggedIn',
            'App\Listeners\UserEventListener@onUserLogin'
        );

        $events->listen(
            'App\Events\UserLoggedOut',
            'App\Listeners\UserEventListener@onUserLogout'
        );
    }
}
