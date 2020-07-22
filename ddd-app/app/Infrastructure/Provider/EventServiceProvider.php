<?php

namespace App\Infrastructure\Provider;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

//use Ddd\LaravelSubscriber;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
//        ResourceCreated::class => [
//            ResourceCreatedPolicy::class
//        ]
    ];

//    protected $subscribe = [
//        LaravelSubscriber::class,
//    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
//
//    public function shouldDiscoverEvents()
//    {
//        return true;
//    }
//
//    protected function discoverEventsWithin()
//    {
//        return [
//            $this->app->path('Event'),
//        ];
//    }
}
