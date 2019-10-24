<?php

namespace FaithGen\Gallery\Providers;

use FaithGen\Gallery\Models\Album;

use FaithGen\Gallery\Observers\Ministry\AlbumObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class GalleryServiceProvider extends ServiceProvider
{

    protected $listen = [
        \FaithGen\Gallery\Events\Album\ImageSaved::class => [
            \FaithGen\Gallery\Listeners\Album\ImageSaved\ProcessImage::class,
            \FaithGen\Gallery\Listeners\Album\ImageSaved\S3Upload::class,
        ],
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
        $this->loadRoutesFrom(__DIR__ . '/../routes/gallery.php');
        $this->mergeConfigFrom(__DIR__ . '/../config/faithgen-gallery.php', 'faithgen-gallery');
        $this->publishes([
            __DIR__ . '/../storage/gallery/' => storage_path('app/public/gallery')
        ]);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/faithgen-gallery.php' => config_path('faithgen-gallery.php'),
            ], 'faithgen-gallery-config');

            $this->publishes([
                __DIR__ . '/../database/migrations/' => database_path('migrations'),
            ], 'faithgen-gallery-migrations');


        }
        Album::observe(AlbumObserver::class);
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
