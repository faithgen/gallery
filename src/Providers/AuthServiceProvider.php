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
         Gate::define('album.create', [AlbumPolicy::class, 'create']);
        // Gate::define('album.update', [AlbumPolicy::class, 'update']);
        // Gate::define('album.add.images', [AlbumPolicy::class, 'addImages']);
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
