<?php

namespace App\Listners;

use App\Events\TestEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class TestListener
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
     * @param  TestEvent  $event
     * @return void
     */
    public function handle(TestEvent $event)
    {
        
        Log::info("Hi, I'm {$event->name}");
    }
}
