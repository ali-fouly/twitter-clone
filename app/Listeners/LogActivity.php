<?php

namespace App\Listeners;

use App\Events\ActionTrigerred;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\ActivityLog;

class LogActivity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ActionTrigerred  $event
     * @return void
     */
    public function handle(ActionTrigerred $event)
    {   

        $activityLog = new ActivityLog;
        $activityLog->user_id = $event->user_id;
        $activityLog->action = $event->action;
        $activityLog->tweet_id = $event->tweet_id;
        $activityLog->mentioned_id = $event->mentioned_id;
        $activityLog->save();
        
    }
}
