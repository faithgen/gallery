<?php

namespace FaithGen\Gallery\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \FaithGen\Gallery\Events\Album\Created::class => [
            \FaithGen\Gallery\Listeners\Album\Created\MessageFollowUsers::class,
        ],
    ];
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
