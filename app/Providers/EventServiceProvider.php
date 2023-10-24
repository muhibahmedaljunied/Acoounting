<?php

namespace App\Providers;
use Illuminate\Auth\Events\Registered;
use App\Events\TestEvent;
use App\Listners\TestListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        TestEvent::class => [
            TestListener::class,
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // 'App\Events\TestEvent' => [
        //     'App\Listners\TestListener',
        // ]
    ];

    public function register(){

        // app()->bind('service',TestEvent::class);

    }


    public function boot()
    {
        parent::boot();
        // $service = app()->make('service');
        // return $service;

    }
}
