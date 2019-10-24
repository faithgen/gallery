<?php

namespace FaithGen\Gallery\Providers;

use FaithGen\Gallery\Models\Album;
use FaithGen\Gallery\Policies\AlbumPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Album::class => AlbumPolicy::class
    ];

    public function boot()
    {
        $this->registerPolicies();

        //albums gates
        Gate::define('album.create', '\FaithGen\Gallery\Policies\AlbumPolicy@create');
        Gate::define('album.update', '\FaithGen\Gallery\Policies\AlbumPolicy@update');
        Gate::define('album.delete', '\FaithGen\Gallery\Policies\AlbumPolicy@delete');
        Gate::define('album.view', '\FaithGen\Gallery\Policies\AlbumPolicy@view');
        Gate::define('album.add.images', '\FaithGen\Gallery\Policies\AlbumPolicy@addImages');
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
