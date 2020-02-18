<?php

namespace FaithGen\Gallery\Providers;

use FaithGen\Gallery\Models\Album;
use FaithGen\Gallery\Policies\AlbumPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Album::class => AlbumPolicy::class
    ];

    public function boot()
    {
        $this->registerPolicies();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }
}
